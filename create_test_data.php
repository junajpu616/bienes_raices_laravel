<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== CREANDO DATOS DE PRUEBA PARA LA INTERFAZ WEB ===\n\n";

try {
    // 1. Crear usuarios de prueba
    echo "1. Creando usuarios de prueba...\n";
    
    $admin = App\Models\User::create([
        'name' => 'Administrador Principal',
        'email' => 'admin@bienesraices.com',
        'password' => bcrypt('admin123'),
        'is_admin' => true
    ]);
    echo "✅ Admin creado: {$admin->name} (ID: {$admin->id})\n";

    $user = App\Models\User::create([
        'name' => 'Usuario Regular',
        'email' => 'usuario@bienesraices.com',
        'password' => bcrypt('usuario123'),
        'is_admin' => false
    ]);
    echo "✅ Usuario creado: {$user->name} (ID: {$user->id})\n";

    // 2. Crear vendedores de prueba
    echo "\n2. Creando vendedores de prueba...\n";
    
    $seller1 = App\Models\Seller::create([
        'nombre' => 'María',
        'apellido' => 'González',
        'telefono' => '555-0001',
        'email' => 'maria@bienesraices.com',
        'password' => bcrypt('maria123'),
        'is_admin' => false
    ]);
    echo "✅ Vendedora creada: {$seller1->nombre} {$seller1->apellido} (ID: {$seller1->id})\n";

    $seller2 = App\Models\Seller::create([
        'nombre' => 'Carlos',
        'apellido' => 'Rodríguez',
        'telefono' => '555-0002',
        'email' => 'carlos@bienesraices.com',
        'password' => bcrypt('carlos123'),
        'is_admin' => true
    ]);
    echo "✅ Vendedor admin creado: {$seller2->nombre} {$seller2->apellido} (ID: {$seller2->id})\n";

    // 3. Crear propiedades de prueba
    echo "\n3. Creando propiedades de prueba...\n";
    
    $properties = [
        [
            'titulo' => 'Casa de Lujo en Zona Residencial',
            'precio' => 850000,
            'imagen' => 'casa_lujo.jpg',
            'descripcion' => 'Hermosa casa de lujo con acabados de primera calidad',
            'habitaciones' => 4,
            'wc' => 3,
            'estacionamiento' => 2,
            'seller_id' => $seller1->id
        ],
        [
            'titulo' => 'Departamento Moderno Centro',
            'precio' => 420000,
            'imagen' => 'depto_moderno.jpg',
            'descripcion' => 'Departamento moderno en el centro de la ciudad',
            'habitaciones' => 2,
            'wc' => 2,
            'estacionamiento' => 1,
            'seller_id' => $seller2->id
        ],
        [
            'titulo' => 'Casa Familiar con Jardín',
            'precio' => 650000,
            'imagen' => 'casa_jardin.jpg',
            'descripcion' => 'Perfecta para familias grandes, amplio jardín',
            'habitaciones' => 5,
            'wc' => 3,
            'estacionamiento' => 2,
            'seller_id' => $seller1->id
        ]
    ];

    foreach ($properties as $propData) {
        $property = App\Models\Property::create($propData);
        echo "✅ Propiedad creada: {$property->titulo} (ID: {$property->id})\n";
    }

    // 4. Hacer algunas modificaciones para generar más auditorías
    echo "\n4. Generando actividad de auditoría...\n";
    
    // Modificar precios
    $property1 = App\Models\Property::find(1);
    if ($property1) {
        $property1->update(['precio' => 900000]);
        echo "✅ Precio actualizado para: {$property1->titulo}\n";
    }

    // Modificar información de vendedor
    $seller1->update(['telefono' => '555-0001-NEW']);
    echo "✅ Teléfono actualizado para: {$seller1->nombre}\n";

    // Crear y eliminar una propiedad temporal
    $tempProperty = App\Models\Property::create([
        'titulo' => 'Propiedad Temporal',
        'precio' => 300000,
        'imagen' => 'temp.jpg',
        'descripcion' => 'Esta será eliminada',
        'habitaciones' => 2,
        'wc' => 1,
        'estacionamiento' => 1,
        'seller_id' => $seller2->id
    ]);
    echo "✅ Propiedad temporal creada (ID: {$tempProperty->id})\n";
    
    $tempProperty->delete();
    echo "✅ Propiedad temporal eliminada\n";

    // 5. Resumen final
    echo "\n=== RESUMEN FINAL ===\n";
    $totalAudits = App\Models\Audit::count();
    $users = App\Models\User::count();
    $sellers = App\Models\Seller::count();
    $properties = App\Models\Property::count();
    
    echo "📊 DATOS CREADOS:\n";
    echo "   - Usuarios: {$users}\n";
    echo "   - Vendedores: {$sellers}\n";
    echo "   - Propiedades: {$properties}\n";
    echo "   - Auditorías generadas: {$totalAudits}\n\n";
    
    echo "🔐 CREDENCIALES DE PRUEBA:\n";
    echo "   Admin: admin@bienesraices.com / admin123\n";
    echo "   Usuario: usuario@bienesraices.com / usuario123\n";
    echo "   Vendedora: maria@bienesraices.com / maria123\n";
    echo "   Vendedor Admin: carlos@bienesraices.com / carlos123\n\n";
    
    echo "🌐 URLS PARA PROBAR:\n";
    echo "   - Lista de auditorías: http://127.0.0.1:8000/admin/audits\n";
    echo "   - Estadísticas: http://127.0.0.1:8000/admin/audits/stats\n";
    echo "   - Historial de propiedad #1: http://127.0.0.1:8000/admin/audits/property/1\n";
    echo "   - Historial de vendedor #1: http://127.0.0.1:8000/admin/audits/seller/1\n\n";
    
    echo "🎉 ¡DATOS DE PRUEBA CREADOS EXITOSAMENTE!\n";
    echo "Ahora puedes abrir el navegador y probar la interfaz de auditoría.\n";

} catch (Exception $e) {
    echo "❌ Error: {$e->getMessage()}\n";
    echo "Trace: {$e->getTraceAsString()}\n";
}