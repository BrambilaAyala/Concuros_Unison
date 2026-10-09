<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $table = 'eventos';

    protected $fillable = [
        'nombre',
        'edicion',
        'fecha_cierre',
        'activo',
        'mensaje_cierre',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'fecha_cierre' => 'date',
    ];
}
