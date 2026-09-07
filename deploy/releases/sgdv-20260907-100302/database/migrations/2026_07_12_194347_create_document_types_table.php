<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


/**
 * Crea catálogo maestro de tipos documentales
 */
return new class extends Migration
{


    /**
     * Ejecuta creación tabla
     */
    public function up(): void
    {


        Schema::create('document_types', function (Blueprint $table) {


            $table->id();


            /*
            |--------------------------------------------------------------------------
            | Nombre del tipo documento
            |--------------------------------------------------------------------------
            */

            $table->string('nombre');



            /*
            |--------------------------------------------------------------------------
            | Descripción opcional
            |--------------------------------------------------------------------------
            */

            $table->text('descripcion')
                  ->nullable();



            /*
            |--------------------------------------------------------------------------
            | Permite activar/desactivar tipos
            |--------------------------------------------------------------------------
            */

            $table->boolean('activo')
                  ->default(true);



            $table->timestamps();


        });


    }




    /**
     * Revierte cambios
     */
    public function down(): void
    {

        Schema::dropIfExists('document_types');

    }

};