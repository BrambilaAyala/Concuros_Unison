<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Revisores extends Model
{
    
    public function validaciones(){
        return $this->belongsTo(Validaciones::class);
    }

}
