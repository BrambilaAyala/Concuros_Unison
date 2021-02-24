<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asistente extends Model
{

    public function asesor(){
        return $this->belongsTo(Asesor::class);
    }

}
