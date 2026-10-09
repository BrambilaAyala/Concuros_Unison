<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UpdateAsesoresTableSchema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE asesores 
            MODIFY telefono BIGINT UNSIGNED NOT NULL,
            MODIFY apellido_materno VARCHAR(80) NULL,
            MODIFY escuela_origen VARCHAR(255) NULL");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE asesores 
            MODIFY telefono INT UNSIGNED NOT NULL,
            MODIFY apellido_materno VARCHAR(80) NOT NULL");
    }
}
