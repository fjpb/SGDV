<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {

        Schema::table('public_vehicle_views', function (Blueprint $table) {

            $table->foreignId('vehicle_id')
                ->after('id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('document_id')
                ->nullable()
                ->after('vehicle_id')
                ->constrained()
                ->nullOnDelete();

            $table->ipAddress('ip')
                ->nullable()
                ->after('document_id');

            $table->text('user_agent')
                ->nullable()
                ->after('ip');

            $table->string('accion')
                ->after('user_agent');

        });

    }


    public function down(): void
    {

        Schema::table('public_vehicle_views', function (Blueprint $table) {

            $table->dropForeign(['vehicle_id']);
            $table->dropForeign(['document_id']);

            $table->dropColumn([
                'vehicle_id',
                'document_id',
                'ip',
                'user_agent',
                'accion'
            ]);

        });

    }

};
