<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Validaciones extends Model
{
    
    public function documento(){
        return $this->belongsTo(Documentos::class);
    }

}
