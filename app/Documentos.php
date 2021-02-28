<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documentos extends Model
{
    //
    protected $fillable = [
        'foto_asistente', 'acta_asistente', 'constancia_escuela','fecha_creacion', 
    ];

    public function asistente(){
        return $this->hasOne(Asistente::class);
    }
    
}
