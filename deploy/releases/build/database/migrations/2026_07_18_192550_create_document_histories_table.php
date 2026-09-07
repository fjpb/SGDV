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
        Schema::create('document_histories', function (Blueprint $table) {

            $table->id();

            $table->foreignId('document_id')
                ->constrained()
                ->restrictOnDelete();

            $table->foreignId('created_by')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->unsignedInteger('version');

            $table->enum('accion', [
                'reemplazo',
                'edicion',
                'restauracion'
            ])->default('reemplazo');

            $table->string('tipo_documento');

            $table->string('nombre');

            $table->string('archivo');

            $table->date('fecha_emision')
                ->nullable();

            $table->date('fecha_vencimiento')
                ->nullable();

            $table->text('observacion')
                ->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_histories');
    }
};
