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
        // Por ahora, permitir acceso solo a usuarios autenticados
        if (!Auth::check()) {
            abort(403, 'No autorizado');
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

        $audits = $query->paginate(20);

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

    /**
     * Mostrar auditoría de un modelo específico
     */
    public function show($model, $id)
    {
        if (!Auth::check()) {
            abort(403, 'No autorizado');
        }

        // Mapear nombres de modelos a clases
        $modelClass = $this->getModelClass($model);
        if (!$modelClass) {
            abort(404, 'Modelo no encontrado');
        }

        $modelInstance = $modelClass::findOrFail($id);
        $audits = $modelInstance->audits()->with('user')->get();

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
}
