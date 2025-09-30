<?php

namespace App\Traits;

use App\Models\Audit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

trait Auditable
{
    /**
     * Boot del trait - se ejecuta automáticamente cuando se usa el trait
     */
    public static function bootAuditable()
    {
        // Cuando se crea un registro
        static::created(function ($model) {
            $model->auditEvent('created', [], $model->getAuditableAttributes());
        });

        // Cuando se actualiza un registro
        static::updated(function ($model) {
            $old = $model->getOriginal();
            $new = $model->getAuditableAttributes();
            
            // Solo auditar si hay cambios reales
            if ($old != $new) {
                $model->auditEvent('updated', $old, $new);
            }
        });

        // Cuando se elimina un registro
        static::deleted(function ($model) {
            $model->auditEvent('deleted', $model->getAuditableAttributes(), []);
        });
    }

    /**
     * Crear un registro de auditoría
     */
    protected function auditEvent(string $event, array $oldValues, array $newValues)
    {
        // Obtener el usuario actual (puede ser User o Seller)
        $user = $this->getCurrentAuditUser();
        
        Audit::create([
            'auditable_type' => get_class($this),
            'auditable_id' => $this->id,
            'user_type' => $user ? get_class($user) : null,
            'user_id' => $user ? $user->id : null,
            'user_name' => $user ? $this->getUserDisplayName($user) : 'Sistema',
            'event' => $event,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }

    /**
     * Obtener el usuario actual que puede ser User o Seller
     */
    protected function getCurrentAuditUser()
    {
        // Primero intentar obtener el usuario autenticado por defecto
        $user = Auth::user();
        if ($user) {
            return $user;
        }

        // Si no hay usuario por defecto, verificar otros guards
        // Esto es útil si tienes guards separados para sellers
        if (Auth::guard('seller')->check()) {
            return Auth::guard('seller')->user();
        }

        return null;
    }

    /**
     * Obtener el nombre del usuario para mostrar en la auditoría
     */
    protected function getUserDisplayName($user): string
    {
        if ($user instanceof \App\Models\User) {
            return $user->name;
        } elseif ($user instanceof \App\Models\Seller) {
            return $user->nombre . ' ' . $user->apellido;
        }
        
        return 'Usuario desconocido';
    }

    /**
     * Obtener los atributos que se pueden auditar
     * Excluye campos sensibles como passwords y tokens
     */
    protected function getAuditableAttributes(): array
    {
        $attributes = $this->getAttributes();
        
        // Campos que no queremos auditar
        $excluded = [
            'password',
            'remember_token',
            'email_verified_at',
            'created_at',
            'updated_at'
        ];

        return array_diff_key($attributes, array_flip($excluded));
    }

    /**
     * Relación con los registros de auditoría
     */
    public function audits()
    {
        return $this->morphMany(Audit::class, 'auditable')->orderBy('created_at', 'desc');
    }

    /**
     * Obtener el último cambio
     */
    public function latestAudit()
    {
        return $this->morphOne(Audit::class, 'auditable')->latest();
    }
}