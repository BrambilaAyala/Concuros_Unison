<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Model;

class Asistente extends Authenticatable
{
    use Notifiable;

    protected $table = 'asistentes';
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'apellido_paterno', 'apellido_materno' , 'correo_electronico', 'contrasena',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'contrasena', 'remember_token',
    ];

    public function asesor(){
        return $this->belongsTo(Asesor::class);
    }

    public function concursos(){
        return $this->belongsToMany(Concursos::class,'asistente_concurso','id_asistente','id_concurso');
    }

    public function documentos(){
        return $this->hasMany(Documentos::class,'id_asistente');
    }
}
