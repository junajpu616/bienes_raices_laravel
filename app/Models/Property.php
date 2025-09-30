<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use Auditable;
    protected $fillable = [
        'titulo',
        'precio',
        'imagen',
        'descripcion',
        'habitaciones',
        'wc',
        'estacionamiento',
        'seller_id'
    ];

    public function vendedor()
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }
}
