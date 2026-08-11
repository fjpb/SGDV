<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {

        Schema::create('public_vehicle_views', function (Blueprint $table) {

            $table->id();

            $table->foreignId('vehicle_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('document_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->ipAddress('ip')
                ->nullable();

            $table->text('user_agent')
                ->nullable();

            $table->string('accion');

            $table->timestamps();

        });

    }


    public function down(): void
    {

        Schema::dropIfExists('public_vehicle_views');

    }

};
