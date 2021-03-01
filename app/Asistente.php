<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


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

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAuthPassword(){       
        return $this->contrasena;     
    }

    public function asesor(){
        return $this->belongsTo(Asesor::class);
    }

    public function concursos(){
        return $this->belongsToMany(Concursos::class,'asistente_concurso','id_asistente','id_concurso');
    }

    /**
     * linea comentada por si quieren que la relacion sea de 1 a muchos
     */
    // public function documentos(){
    //     return $this->hasMany(Documentos::class,'id_asistente');
    // }

    public function documentos(){
        return $this->hasOne(Documentos::class,'id_asistente');
    }
}
