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
        Schema::create('document_access_logs', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Documento asociado
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
            | Tipo de acceso
            |--------------------------------------------------------------------------
            | visualizacion
            | descarga
            |--------------------------------------------------------------------------
            */
            $table->enum('accion', [
                'visualizacion',
                'descarga',
            ]);


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
        Schema::dropIfExists('document_access_logs');
    }
};
