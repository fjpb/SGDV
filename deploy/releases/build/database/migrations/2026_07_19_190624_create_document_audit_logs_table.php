<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('document_audit_logs', function (Blueprint $table) {

            $table->id();


            /*
            |--------------------------------------------------------------------------
            | Documento afectado
            |--------------------------------------------------------------------------
            */
            $table->foreignId('document_id')
                ->constrained()
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Usuario que realizó la acción
            |--------------------------------------------------------------------------
            */
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Acción realizada
            |--------------------------------------------------------------------------
            */
            $table->enum('accion', [

                'creacion',
                'edicion',
                'reemplazo',
                'restauracion',
                'eliminacion'

            ]);


            /*
            |--------------------------------------------------------------------------
            | Datos antes/después del cambio
            |--------------------------------------------------------------------------
            */
            $table->json('datos_anteriores')
                ->nullable();


            $table->json('datos_nuevos')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Información técnica
            |--------------------------------------------------------------------------
            */
            $table->string('ip_address')
                ->nullable();


            $table->text('user_agent')
                ->nullable();


            $table->timestamps();

        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_audit_logs');
    }
};
