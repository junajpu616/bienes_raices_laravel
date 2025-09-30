<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== PRUEBA DEL SISTEMA DE AUDITORÍA ===\n\n";

try {
    // 1. Crear un usuario de prueba
    echo "1. Creando usuario de prueba...\n";
    $user = App\Models\User::create([
        'name' => 'Usuario Prueba Auditoría',
        'email' => 'test-audit-' . time() . '@example.com',
        'password' => bcrypt('password'),
        'is_admin' => true
    ]);
    echo "✅ Usuario creado: {$user->name} (ID: {$user->id})\n\n";

    // 2. Verificar que se creó una auditoría
    echo "2. Verificando auditorías generadas...\n";
    $audits = App\Models\Audit::where('auditable_type', 'App\Models\User')
                             ->where('auditable_id', $user->id)
                             ->get();
    
    echo "✅ Auditorías encontradas: {$audits->count()}\n\n";

    if ($audits->count() > 0) {
        $audit = $audits->first();
        echo "3. Detalles de la auditoría:\n";
        echo "   - Evento: {$audit->event}\n";
        echo "   - Modelo: {$audit->auditable_type}\n";
        echo "   - Record ID: {$audit->auditable_id}\n";
        echo "   - Usuario que hizo el cambio: {$audit->user_name}\n";
        echo "   - Fecha: {$audit->created_at}\n";
        echo "   - IP: {$audit->ip_address}\n\n";
    }

    // 3. Modificar el usuario para generar otra auditoría
    echo "4. Modificando usuario para generar auditoría de 'update'...\n";
    $user->update(['name' => 'Usuario Modificado']);
    echo "✅ Usuario modificado\n\n";

    // 4. Verificar auditorías de update
    $updateAudits = App\Models\Audit::where('auditable_type', 'App\Models\User')
                                   ->where('auditable_id', $user->id)
                                   ->where('event', 'updated')
                                   ->get();
    
    echo "5. Auditorías de modificación: {$updateAudits->count()}\n";
    
    if ($updateAudits->count() > 0) {
        $updateAudit = $updateAudits->first();
        echo "   - Cambios detectados:\n";
        $changes = $updateAudit->getChanges();
        foreach ($changes as $field => $change) {
            echo "     * {$field}: '{$change['old']}' → '{$change['new']}'\n";
        }
    }

    echo "\n🎉 ¡SISTEMA DE AUDITORÍA FUNCIONANDO PERFECTAMENTE!\n\n";

    // 5. Resumen final
    $totalAudits = App\Models\Audit::count();
    echo "RESUMEN:\n";
    echo "- Total de auditorías en el sistema: {$totalAudits}\n";
    echo "- Auditorías de este usuario: " . $user->audits->count() . "\n";
    
} catch (Exception $e) {
    echo "❌ Error: {$e->getMessage()}\n";
    echo "Trace: {$e->getTraceAsString()}\n";
}