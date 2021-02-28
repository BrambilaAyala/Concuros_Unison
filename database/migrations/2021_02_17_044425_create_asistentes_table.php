<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsistentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asistentes', function (Blueprint $table) {
            $table->id();
            $table->string('curp',55)->nullable();
            $table->bigInteger('folio',false,true)->nullable();
            $table->string('nombre', 80);
            $table->string('apellido_paterno', 80)->nullable();
            $table->string('apellido_materno', 80)->nullable();
            $table->string('escuela_origen', 255)->nullable();
            $table->string('correo_electronico', 80)->unique();
            $table->string('contrasena', 100);
            $table->date('fecha_nacimiento')->nullable();
            $table->bigInteger('telefono',false,true)->nullable();
            $table->date('fecha_registro_aceptado')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asistentes');
    }
}
