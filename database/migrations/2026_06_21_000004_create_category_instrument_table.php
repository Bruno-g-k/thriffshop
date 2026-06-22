<?php

// database/migrations/2026_06_21_000004_create_category_instrument_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('category_instrument', function (Blueprint $table) {
            $table->foreignId('instrument_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->primary(['instrument_id', 'category_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_instrument');
    }
};
