<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('qr_consultations');
    }

    public function down(): void
    {
        // No se recrea porque esta tabla fue descartada del diseño.
    }
};
