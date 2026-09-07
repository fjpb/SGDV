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
    Schema::create('documents', function (Blueprint $table) {

    $table->id();


    $table->foreignId('vehicle_id')
        ->constrained()
        ->cascadeOnDelete();


    $table->uuid('uuid')
        ->unique();


    $table->string('tipo_documento', 100);


    $table->string('nombre', 200);


    $table->string('archivo')
        ->nullable();


    $table->date('fecha_emision')
        ->nullable();


    $table->date('fecha_vencimiento')
        ->nullable();


    $table->enum('estado', [
        'vigente',
        'vencido',
        'pendiente'
    ])
    ->default('vigente');


    $table->text('observacion')
        ->nullable();


    $table->timestamps();


    $table->softDeletes();

});
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
