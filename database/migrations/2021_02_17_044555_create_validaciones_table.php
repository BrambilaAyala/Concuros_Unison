<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValidacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('validaciones', function (Blueprint $table) {
            $table->id();
            $table->string('id_documento');
            $table->string('id_revisor');
            $table->text('comentario');
            $table->string('doc_aprobado');
            $table->string('doc_rechazado');
            $table->enum('estado',['Rechazado','En espera a validar','Aprobado']);
            $table->date('fecha_validacion');
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
        Schema::dropIfExists('validaciones');
    }
}
