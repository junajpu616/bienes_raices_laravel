<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\Property;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuditController extends Controller
{
    /**
     * Mostrar todos los registros de auditoría (solo para administradores)
     */
    public function index(Request $request)
    {
        // Permitir acceso a usuarios web autenticados o sellers admin
        $isWebAuth = Auth::check();
        $isSellerAdmin = Auth::guard('seller')->check() && Auth::guard('seller')->user()->is_admin;
        
        if (!$isWebAuth && !$isSellerAdmin) {
            abort(403, 'Acceso denegado. Se requiere autenticación.');
        }

        $query = Audit::with(['auditable', 'user'])
                     ->orderBy('created_at', 'desc');

        // Filtros opcionales
        if ($request->filled('model')) {
            $query->where('auditable_type', $request->model);
        }

        if ($request->filled('event')) {
            $query->where('event', $request->event);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $audits = $query->paginate(20);

        // Si es una petición AJAX o API, devolver JSON
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'data' => $audits->items(),
                'pagination' => [
                    'current_page' => $audits->currentPage(),
                    'total' => $audits->total(),
                    'per_page' => $audits->perPage(),
                    'last_page' => $audits->lastPage()
                ]
            ]);
        }

        // Para peticiones web, devolver vista HTML
        return view('audits.index', compact('audits'));
    }

    /**
     * Mostrar auditoría de un modelo específico
     */
    public function show($model, $id, Request $request)
    {
        // Permitir acceso a usuarios web autenticados o sellers admin
        $isWebAuth = Auth::check();
        $isSellerAdmin = Auth::guard('seller')->check() && Auth::guard('seller')->user()->is_admin;
        
        if (!$isWebAuth && !$isSellerAdmin) {
            abort(403, 'Acceso denegado. Se requiere autenticación.');
        }

        // Mapear nombres de modelos a clases
        $modelClass = $this->getModelClass($model);
        if (!$modelClass) {
            abort(404, 'Modelo no encontrado');
        }

        $modelInstance = $modelClass::findOrFail($id);
        $audits = $modelInstance->audits()->with('user')->orderBy('created_at', 'desc')->get();

        // Si es una petición AJAX o API, devolver JSON
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'model' => $model,
                'record_id' => $id,
                'audits' => $audits->map(function ($audit) {
                    return [
                        'id' => $audit->id,
                        'event' => $audit->event,
                        'user' => $audit->user_name,
                        'changes' => $audit->getChanges(),
                        'created_at' => $audit->created_at->format('Y-m-d H:i:s'),
                        'ip_address' => $audit->ip_address,
                    ];
                })
            ]);
        }

        // Para peticiones web, devolver vista HTML
        return view('audits.show', compact('modelInstance', 'audits', 'model'));
    }

    /**
     * Mapear nombres de modelos a clases
     */
    private function getModelClass($model): ?string
    {
        $models = [
            'property' => Property::class,
            'properties' => Property::class,
            'seller' => Seller::class,
            'sellers' => Seller::class,
            'user' => User::class,
            'users' => User::class,
        ];

        return $models[strtolower($model)] ?? null;
    }

    /**
     * Mostrar estadísticas de auditoría
     */
    public function stats(Request $request)
    {
        // Permitir acceso a usuarios web autenticados o sellers admin
        $isWebAuth = Auth::check();
        $isSellerAdmin = Auth::guard('seller')->check() && Auth::guard('seller')->user()->is_admin;
        
        if (!$isWebAuth && !$isSellerAdmin) {
            abort(403, 'Acceso denegado. Se requiere autenticación.');
        }

        $stats = [
            'total_events' => Audit::count(),
            'events_today' => Audit::whereDate('created_at', today())->count(),
            'events_this_week' => Audit::whereBetween('created_at', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ])->count(),
            'events_this_month' => Audit::whereMonth('created_at', now()->month)
                                       ->whereYear('created_at', now()->year)
                                       ->count(),
            'by_event' => Audit::selectRaw('event, COUNT(*) as count')
                              ->groupBy('event')
                              ->pluck('count', 'event'),
            'by_model' => Audit::selectRaw('auditable_type, COUNT(*) as count')
                              ->groupBy('auditable_type')
                              ->get()
                              ->mapWithKeys(function ($item) {
                                  return [class_basename($item->auditable_type) => $item->count];
                              }),
            'top_users' => Audit::selectRaw('user_name, user_type, COUNT(*) as count')
                               ->whereNotNull('user_name')
                               ->groupBy(['user_name', 'user_type'])
                               ->orderBy('count', 'desc')
                               ->limit(10)
                               ->get(),
            'recent_activity' => Audit::with(['auditable'])
                                     ->orderBy('created_at', 'desc')
                                     ->limit(10)
                                     ->get()
        ];

        // Si es una petición AJAX o API, devolver JSON
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json($stats);
        }

        // Para peticiones web, devolver vista HTML
        return view('audits.stats', compact('stats'));
    }
}
