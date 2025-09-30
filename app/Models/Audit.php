<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Audit extends Model
{
    protected $fillable = [
        'auditable_type',
        'auditable_id',
        'user_type',
        'user_id',
        'user_name',
        'event',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    /**
     * Relación polimórfica con el modelo auditado
     */
    public function auditable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Relación polimórfica con el usuario que hizo el cambio
     */
    public function user(): MorphTo
    {
        return $this->morphTo('user');
    }

    /**
     * Obtener los cambios de manera legible
     */
    public function getChanges(): array
    {
        $changes = [];
        
        if ($this->event === 'created') {
            return $this->new_values ?? [];
        }
        
        if ($this->event === 'deleted') {
            return $this->old_values ?? [];
        }
        
        // Para updates, mostrar solo los campos que cambiaron
        $old = $this->old_values ?? [];
        $new = $this->new_values ?? [];
        
        foreach ($new as $key => $value) {
            if (isset($old[$key]) && $old[$key] !== $value) {
                $changes[$key] = [
                    'old' => $old[$key],
                    'new' => $value
                ];
            }
        }
        
        return $changes;
    }

    /**
     * Scope para filtrar por modelo
     */
    public function scopeForModel($query, $model)
    {
        return $query->where('auditable_type', get_class($model))
                    ->where('auditable_id', $model->id);
    }

    /**
     * Scope para filtrar por usuario
     */
    public function scopeByUser($query, $user)
    {
        return $query->where('user_type', get_class($user))
                    ->where('user_id', $user->id);
    }
}
