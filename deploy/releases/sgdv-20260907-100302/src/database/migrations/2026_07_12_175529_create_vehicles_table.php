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
    Schema::create('vehicles', function (Blueprint $table) {

        $table->id();

        $table->foreignId('user_id')
            ->constrained()
            ->cascadeOnDelete();

        $table->uuid('uuid')
            ->unique();

        $table->string('patente', 10)
            ->index();

        $table->string('tipo', 50);

        $table->string('marca', 100)
            ->nullable();

        $table->string('modelo', 100)
            ->nullable();

        $table->year('anio')
            ->nullable();

        $table->string('color', 50)
            ->nullable();

        $table->enum('estado', [
            'activo',
            'archivado'
        ])
        ->default('activo');


        $table->timestamps();

        $table->softDeletes();

    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
