<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{

    /**
     * Crear catálogo tipos documentos
     */
    public function up(): void
    {

        Schema::create('document_types', function (Blueprint $table) {


            $table->id();


            /*
            |--------------------------------------------------------------------------
            | Información del tipo documental
            |--------------------------------------------------------------------------
            */

            $table->string('nombre');

            $table->text('descripcion')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Control activo/inactivo
            |--------------------------------------------------------------------------
            */

            $table->boolean('activo')
                ->default(true);


            $table->timestamps();


        });

    }



    /**
     * Eliminar tabla
     */
    public function down(): void
    {

        Schema::dropIfExists('document_types');

    }

};