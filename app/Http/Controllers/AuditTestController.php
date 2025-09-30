<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\Property;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Http\Request;

class AuditTestController extends Controller
{
    /**
     * Probar la funcionalidad de auditoría creando algunos datos de ejemplo
     */
    public function test()
    {
        try {
            // Verificar que la tabla de audits existe
            $auditsCount = Audit::count();
            
            return response()->json([
                'success' => true,
                'message' => 'Sistema de auditoría funcionando correctamente',
                'audits_count' => $auditsCount,
                'instructions' => [
                    '1. Crea, edita o elimina una Property, Seller o User',
                    '2. Automáticamente se creará un registro en la tabla audits',
                    '3. Puedes consultar los cambios en /admin/audits',
                    '4. O para un modelo específico: /admin/audits/property/1'
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'hint' => 'Asegúrate de ejecutar: php artisan migrate'
            ]);
        }
    }

    /**
     * Crear datos de prueba para demostrar la auditoría
     */
    public function createTestData()
    {
        try {
            // Crear un usuario de prueba
            $user = User::create([
                'name' => 'Usuario Prueba Auditoría',
                'email' => 'audit-test@example.com',
                'password' => bcrypt('password'),
                'is_admin' => true
            ]);

            // Crear un vendedor de prueba
            $seller = Seller::create([
                'nombre' => 'Vendedor',
                'apellido' => 'Auditoría',
                'telefono' => '123456789',
                'email' => 'seller-audit@example.com',
                'password' => bcrypt('password'),
                'is_admin' => false
            ]);

            // Crear una propiedad de prueba
            $property = Property::create([
                'titulo' => 'Casa de Prueba Auditoría',
                'precio' => 250000,
                'imagen' => 'test.jpg',
                'descripcion' => 'Propiedad creada para probar el sistema de auditoría',
                'habitaciones' => 3,
                'wc' => 2,
                'estacionamiento' => 1,
                'seller_id' => $seller->id
            ]);

            // Ahora vamos a hacer algunos cambios para generar más auditorías
            $property->update(['titulo' => 'Casa de Prueba Auditoría - MODIFICADA']);
            $seller->update(['telefono' => '987654321']);

            // Obtener las auditorías generadas
            $audits = Audit::with(['auditable', 'user'])
                          ->orderBy('created_at', 'desc')
                          ->limit(10)
                          ->get();

            return response()->json([
                'success' => true,
                'message' => 'Datos de prueba creados exitosamente',
                'created' => [
                    'user' => $user->only(['id', 'name', 'email']),
                    'seller' => $seller->only(['id', 'nombre', 'apellido', 'telefono']),
                    'property' => $property->only(['id', 'titulo', 'precio'])
                ],
                'audits_generated' => $audits->map(function ($audit) {
                    return [
                        'id' => $audit->id,
                        'event' => $audit->event,
                        'model' => class_basename($audit->auditable_type),
                        'record_id' => $audit->auditable_id,
                        'user' => $audit->user_name,
                        'changes' => $audit->getChanges(),
                        'created_at' => $audit->created_at->format('Y-m-d H:i:s')
                    ];
                })
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}