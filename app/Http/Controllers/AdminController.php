<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use App\Models\Property;
use App\Models\User;
use App\Models\Audit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function adminIndex()
    {
        // Allow admins from both guards
        $isWebAdmin = Auth::check() && Auth::user()->is_admin;
        $isSellerAdmin = Auth::guard('seller')->check() && Auth::guard('seller')->user()->is_admin;
        
        if (!$isWebAdmin && !$isSellerAdmin) {
            abort(403, 'Acceso denegado. Se requieren permisos de administrador.');
        }

        $vendedores = Seller::all();

        return view('vendedores.index', [
            'vendedores' => $vendedores,
            'inicio' => false
        ]);
    }

    public function destroy(Seller $vendedor)
    {
        // Allow admins from both guards
        $isWebAdmin = Auth::check() && Auth::user()->is_admin;
        $isSellerAdmin = Auth::guard('seller')->check() && Auth::guard('seller')->user()->is_admin;
        
        if (!$isWebAdmin && !$isSellerAdmin) {
            abort(403, 'Acceso denegado. Se requieren permisos de administrador.');
        }

        $vendedor->delete();

        return redirect()->route('vendedores.index')->with('exito', '¡Vendedor Eliminado Exitosamente!');
    }

    public function stats()
    {
        // Allow admins from both guards
        $isWebAdmin = Auth::check() && Auth::user()->is_admin;
        $isSellerAdmin = Auth::guard('seller')->check() && Auth::guard('seller')->user()->is_admin;

        if (!$isWebAdmin && !$isSellerAdmin) {
            abort(403, 'Acceso denegado. Se requieren permisos de administrador.');
        }

        $stats = [
            'total_properties' => Property::count(),
            'total_sellers' => Seller::count(),
            'total_users' => User::count(),
            'total_audits' => Audit::count(),
            'properties_today' => Property::whereDate('created_at', today())->count(),
            'sellers_today' => Seller::whereDate('created_at', today())->count(),
            'users_today' => User::whereDate('created_at', today())->count(),
            'audits_today' => Audit::whereDate('created_at', today())->count(),
        ];

        return view('admin.stats', compact('stats'));
    }

    public function propertyStats()
    {
        // Allow admins from both guards
        $isWebAdmin = Auth::check() && Auth::user()->is_admin;
        $isSellerAdmin = Auth::guard('seller')->check() && Auth::guard('seller')->user()->is_admin;

        if (!$isWebAdmin && !$isSellerAdmin) {
            abort(403, 'Acceso denegado. Se requieren permisos de administrador.');
        }

        $properties = Property::with('vendedor')->get();

        // Estadísticas generales de propiedades
        $stats = [
            'total_properties' => $properties->count(),
            'avg_price' => $properties->avg('precio'),
            'max_price' => $properties->max('precio'),
            'min_price' => $properties->min('precio'),
            'avg_bedrooms' => $properties->avg('habitaciones'),
            'avg_bathrooms' => $properties->avg('wc'),
            'avg_parking' => $properties->avg('estacionamiento'),
        ];

        // Propiedades por rango de precio
        $priceRanges = [
            '0-100000' => $properties->where('precio', '<=', 100000)->count(),
            '100001-200000' => $properties->whereBetween('precio', [100001, 200000])->count(),
            '200001-300000' => $properties->whereBetween('precio', [200001, 300000])->count(),
            '300001-500000' => $properties->whereBetween('precio', [300001, 500000])->count(),
            '500001+' => $properties->where('precio', '>', 500000)->count(),
        ];

        // Propiedades por habitaciones
        $bedroomStats = [];
        for ($i = 0; $i <= 10; $i++) {
            $bedroomStats[$i] = $properties->where('habitaciones', $i)->count();
        }

        // Propiedades por baños
        $bathroomStats = [];
        for ($i = 0; $i <= 5; $i++) {
            $bathroomStats[$i] = $properties->where('wc', $i)->count();
        }

        // Propiedades por estacionamiento
        $parkingStats = [];
        for ($i = 0; $i <= 5; $i++) {
            $parkingStats[$i] = $properties->where('estacionamiento', $i)->count();
        }

        // Propiedades por vendedor
        $sellerStats = $properties->groupBy('seller_id')->map(function ($group) {
            $seller = $group->first()->vendedor;
            return [
                'seller_name' => $seller ? ($seller->nombre . ' ' . $seller->apellido) : 'Sin vendedor',
                'count' => $group->count(),
                'avg_price' => $group->avg('precio'),
                'total_value' => $group->sum('precio'),
            ];
        })->sortByDesc('count')->take(10);

        // Propiedades por mes (últimos 12 meses)
        $monthlyStats = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $count = Property::whereYear('created_at', $date->year)
                            ->whereMonth('created_at', $date->month)
                            ->count();
            $monthlyStats[] = [
                'month' => $date->format('M Y'),
                'count' => $count,
            ];
        }

        return view('admin.property-stats', compact('stats', 'priceRanges', 'bedroomStats', 'bathroomStats', 'parkingStats', 'sellerStats', 'monthlyStats'));
    }

    public function exportExcel()
    {
        $isWebAdmin = Auth::check() && Auth::user()->is_admin;
        $isSellerAdmin = Auth::guard('seller')->check() && Auth::guard('seller')->user()->is_admin;

        if (!$isWebAdmin && !$isSellerAdmin) {
            abort(403, 'Acceso denegado. Se requieren permisos de administrador.');
        }

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

        // Sheet 1: Estadísticas Generales
        $statsSheet = $spreadsheet->getActiveSheet();
        $statsSheet->setTitle('Estadísticas');

        $statsSheet->setCellValue('A1', 'Métrica');
        $statsSheet->setCellValue('B1', 'Valor');

        $statsSheet->setCellValue('A2', 'Total Propiedades');
        $statsSheet->setCellValue('B2', Property::count());

        $statsSheet->setCellValue('A3', 'Total Vendedores');
        $statsSheet->setCellValue('B3', Seller::count());

        $statsSheet->setCellValue('A4', 'Total Usuarios');
        $statsSheet->setCellValue('B4', User::count());

        $statsSheet->setCellValue('A5', 'Total Auditorías');
        $statsSheet->setCellValue('B5', Audit::count());

        $statsSheet->setCellValue('A6', 'Propiedades Hoy');
        $statsSheet->setCellValue('B6', Property::whereDate('created_at', today())->count());

        $statsSheet->setCellValue('A7', 'Vendedores Hoy');
        $statsSheet->setCellValue('B7', Seller::whereDate('created_at', today())->count());

        $statsSheet->setCellValue('A8', 'Usuarios Hoy');
        $statsSheet->setCellValue('B8', User::whereDate('created_at', today())->count());

        $statsSheet->setCellValue('A9', 'Auditorías Hoy');
        $statsSheet->setCellValue('B9', Audit::whereDate('created_at', today())->count());

        // Sheet 2: Propiedades
        $propertiesSheet = $spreadsheet->createSheet();
        $propertiesSheet->setTitle('Propiedades');

        $propertiesSheet->setCellValue('A1', 'ID');
        $propertiesSheet->setCellValue('B1', 'Título');
        $propertiesSheet->setCellValue('C1', 'Precio');
        $propertiesSheet->setCellValue('D1', 'Vendedor');
        $propertiesSheet->setCellValue('E1', 'Fecha Creación');

        $properties = Property::with('vendedor')->get();
        $row = 2;
        foreach ($properties as $property) {
            $propertiesSheet->setCellValue('A' . $row, $property->id);
            $propertiesSheet->setCellValue('B' . $row, $property->titulo);
            $propertiesSheet->setCellValue('C' . $row, $property->precio);
            $propertiesSheet->setCellValue('D' . $row, $property->vendedor ? ($property->vendedor->nombre . ' ' . $property->vendedor->apellido) : 'N/A');
            $propertiesSheet->setCellValue('E' . $row, $property->created_at ? $property->created_at->format('Y-m-d H:i:s') : 'N/A');
            $row++;
        }

        // Sheet 3: Vendedores
        $sellersSheet = $spreadsheet->createSheet();
        $sellersSheet->setTitle('Vendedores');

        $sellersSheet->setCellValue('A1', 'ID');
        $sellersSheet->setCellValue('B1', 'Nombre');
        $sellersSheet->setCellValue('C1', 'Apellido');
        $sellersSheet->setCellValue('D1', 'Email');
        $sellersSheet->setCellValue('E1', 'Teléfono');
        $sellersSheet->setCellValue('F1', 'Admin');
        $sellersSheet->setCellValue('G1', 'Fecha Creación');

        $sellers = Seller::all();
        $row = 2;
        foreach ($sellers as $seller) {
            $sellersSheet->setCellValue('A' . $row, $seller->id);
            $sellersSheet->setCellValue('B' . $row, $seller->nombre);
            $sellersSheet->setCellValue('C' . $row, $seller->apellido);
            $sellersSheet->setCellValue('D' . $row, $seller->email);
            $sellersSheet->setCellValue('E' . $row, $seller->telefono);
            $sellersSheet->setCellValue('F' . $row, $seller->is_admin ? 'Sí' : 'No');
            $sellersSheet->setCellValue('G' . $row, $seller->created_at ? $seller->created_at->format('Y-m-d H:i:s') : 'N/A');
            $row++;
        }

        // Sheet 4: Usuarios
        $usersSheet = $spreadsheet->createSheet();
        $usersSheet->setTitle('Usuarios');

        $usersSheet->setCellValue('A1', 'ID');
        $usersSheet->setCellValue('B1', 'Nombre');
        $usersSheet->setCellValue('C1', 'Email');
        $usersSheet->setCellValue('D1', 'Admin');
        $usersSheet->setCellValue('E1', 'Fecha Creación');

        $users = User::all();
        $row = 2;
        foreach ($users as $user) {
            $usersSheet->setCellValue('A' . $row, $user->id);
            $usersSheet->setCellValue('B' . $row, $user->name);
            $usersSheet->setCellValue('C' . $row, $user->email);
            $usersSheet->setCellValue('D' . $row, $user->is_admin ? 'Sí' : 'No');
            $usersSheet->setCellValue('E' . $row, $user->created_at ? $user->created_at->format('Y-m-d H:i:s') : 'N/A');
            $row++;
        }

        // Sheet 5: Auditorías
        $auditsSheet = $spreadsheet->createSheet();
        $auditsSheet->setTitle('Auditorías');

        $auditsSheet->setCellValue('A1', 'ID');
        $auditsSheet->setCellValue('B1', 'Usuario');
        $auditsSheet->setCellValue('C1', 'Tipo de Usuario');
        $auditsSheet->setCellValue('D1', 'Evento');
        $auditsSheet->setCellValue('E1', 'Modelo');
        $auditsSheet->setCellValue('F1', 'ID Modelo');
        $auditsSheet->setCellValue('G1', 'Fecha');

        $audits = Audit::all();
        $row = 2;
        foreach ($audits as $audit) {
            $auditsSheet->setCellValue('A' . $row, $audit->id);
            $auditsSheet->setCellValue('B' . $row, $audit->user_name ?? 'Sistema');
            $auditsSheet->setCellValue('C' . $row, class_basename($audit->user_type));
            $auditsSheet->setCellValue('D' . $row, $audit->event);
            $auditsSheet->setCellValue('E' . $row, class_basename($audit->auditable_type));
            $auditsSheet->setCellValue('F' . $row, $audit->auditable_id);
            $auditsSheet->setCellValue('G' . $row, $audit->created_at->format('Y-m-d H:i:s'));
            $row++;
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        $fileName = 'estadisticas_completas_' . date('Ymd_His') . '.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        $writer->save($temp_file);

        return response()->download($temp_file, $fileName)->deleteFileAfterSend(true);
    }
}
