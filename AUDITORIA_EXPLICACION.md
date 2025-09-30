# Sistema de Auditoría para Bienes Raíces Laravel

## ¿Qué es la Auditoría en Base de Datos?

La auditoría en base de datos es un sistema que registra **automáticamente** todos los cambios que se hacen en tu aplicación. Es como tener un "historial" de todo lo que pasa:

- **¿Quién?** - Qué usuario hizo el cambio
- **¿Qué?** - Qué modelo/tabla fue modificado
- **¿Cuándo?** - Fecha y hora exacta del cambio
- **¿Cómo?** - Si fue creación, edición o eliminación
- **¿Desde dónde?** - IP del usuario y navegador

## ¿Por qué es importante?

1. **Seguridad**: Sabes exactamente quién modificó qué
2. **Responsabilidad**: Los usuarios son responsables de sus acciones
3. **Recuperación**: Puedes ver qué cambió para deshacer errores
4. **Cumplimiento**: Muchas empresas requieren auditoría por ley
5. **Debugging**: Ayuda a encontrar por qué algo se rompió

## Cómo funciona en tu proyecto

### 1. Tabla de Auditoría (`audits`)
```sql
audits:
- id
- auditable_type (ej: "App\Models\Property")
- auditable_id (ej: 123)
- user_type (ej: "App\Models\Seller")
- user_id (ej: 45)
- user_name (ej: "Juan Pérez")
- event (created/updated/deleted)
- old_values (valores anteriores en JSON)
- new_values (valores nuevos en JSON)
- ip_address
- user_agent
- created_at
```

### 2. Trait Auditable
Es un "componente" que agregas a tus modelos para que automáticamente se registren los cambios:

```php
class Property extends Model
{
    use Auditable; // ← Esto hace que se audite automáticamente
}
```

### 3. Modelos Auditados
En tu proyecto, estos modelos ahora se auditan automáticamente:
- **User** - Usuarios del sistema
- **Seller** - Vendedores/Agentes
- **Property** - Propiedades inmobiliarias

## Ejemplos Reales

### Ejemplo 1: Crear una Propiedad
```php
$property = Property::create([
    'titulo' => 'Casa en venta',
    'precio' => 250000,
    'seller_id' => 1
]);
```

**Registro de Auditoría Generado:**
```json
{
    "event": "created",
    "model": "Property",
    "record_id": 123,
    "user": "Juan Pérez",
    "new_values": {
        "titulo": "Casa en venta",
        "precio": 250000,
        "seller_id": 1
    },
    "created_at": "2025-09-30 10:30:00"
}
```

### Ejemplo 2: Actualizar el Precio
```php
$property->update(['precio' => 300000]);
```

**Registro de Auditoría Generado:**
```json
{
    "event": "updated",
    "model": "Property",
    "record_id": 123,
    "user": "Juan Pérez",
    "changes": {
        "precio": {
            "old": 250000,
            "new": 300000
        }
    },
    "created_at": "2025-09-30 15:45:00"
}
```

### Ejemplo 3: Eliminar una Propiedad
```php
$property->delete();
```

**Registro de Auditoría Generado:**
```json
{
    "event": "deleted",
    "model": "Property",
    "record_id": 123,
    "user": "Juan Pérez",
    "old_values": {
        "titulo": "Casa en venta",
        "precio": 300000,
        "seller_id": 1
    },
    "created_at": "2025-09-30 16:00:00"
}
```

## Cómo Usar el Sistema

### 1. Instalación
```bash
# Ejecutar la migración para crear la tabla
php artisan migrate
```

### 2. Consultar Auditorías
```php
// Ver todas las auditorías
GET /admin/audits

// Ver auditorías de una propiedad específica
GET /admin/audits/property/123

// En código PHP:
$audits = Audit::with(['auditable', 'user'])
              ->orderBy('created_at', 'desc')
              ->get();

// Ver auditorías de un modelo específico
$property = Property::find(1);
$audits = $property->audits; // Todas las auditorías de esta propiedad
```

### 3. Filtrar Auditorías
```php
// Solo creaciones
$audits = Audit::where('event', 'created')->get();

// Solo de un usuario específico
$audits = Audit::where('user_id', 1)
              ->where('user_type', 'App\Models\Seller')
              ->get();

// Por fechas
$audits = Audit::whereDate('created_at', '2025-09-30')->get();
```

## Casos de Uso Reales

### Caso 1: "¿Quién cambió el precio de esta casa?"
```php
$property = Property::find(123);
$priceChanges = $property->audits()
                        ->where('event', 'updated')
                        ->get()
                        ->filter(function($audit) {
                            $changes = $audit->getChanges();
                            return isset($changes['precio']);
                        });

foreach($priceChanges as $change) {
    echo "El {$change->created_at}, {$change->user_name} cambió el precio de {$change->getChanges()['precio']['old']} a {$change->getChanges()['precio']['new']}";
}
```

### Caso 2: "¿Qué propiedades eliminó este vendedor?"
```php
$seller = Seller::find(5);
$deletedProperties = Audit::where('user_id', $seller->id)
                         ->where('user_type', 'App\Models\Seller')
                         ->where('event', 'deleted')
                         ->where('auditable_type', 'App\Models\Property')
                         ->get();
```

### Caso 3: "Actividad del día de hoy"
```php
$todayActivity = Audit::whereDate('created_at', today())
                     ->with(['auditable', 'user'])
                     ->orderBy('created_at', 'desc')
                     ->get();
```

## Configuración Avanzada

### Excluir Campos Sensibles
El trait ya excluye automáticamente:
- passwords
- remember_token
- email_verified_at
- created_at/updated_at

### Personalizar Campos Auditables
```php
// En tu modelo, puedes personalizar:
protected function getAuditableAttributes(): array
{
    $attributes = parent::getAuditableAttributes();
    
    // Excluir campos adicionales
    unset($attributes['campo_privado']);
    
    return $attributes;
}
```

## Seguridad y Mejores Prácticas

1. **Solo Administradores**: La auditoría debe ser visible solo para administradores
2. **No Modificable**: Los registros de auditoría nunca deben editarse o eliminarse
3. **Backup Regular**: Respalda la tabla de audits regularmente
4. **Limpieza Periódica**: Considera eliminar auditorías muy antiguas (ej: +2 años)

## Próximos Pasos

1. ✅ Sistema básico implementado
2. 🔄 Crear vistas web para consultar auditorías
3. 📊 Dashboard con estadísticas de auditoría
4. ⚠️ Alertas para cambios críticos
5. 🔍 Búsqueda avanzada por usuario, fecha, modelo
6. 📧 Notificaciones por email de cambios importantes

---

**¡Tu sistema de auditoría está listo! Ahora cada cambio en Properties, Sellers y Users se registra automáticamente.**