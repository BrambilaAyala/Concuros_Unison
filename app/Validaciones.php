<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Validaciones extends Model
{
    protected $fillable = [
        'id_documento', 'id_revisor', 'estado', 'comentario', 'doc_aprobado', 'doc_rechazado', 'fecha_validacion',
    ];
    
    public function documento(){
        return $this->belongsTo(Documentos::class, 'id_documento');
    }

}
