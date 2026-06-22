<?php

// database/migrations/2026_06_21_000005_create_instrument_images_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('instrument_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instrument_id')->constrained()->onDelete('cascade');
            $table->string('image_path');
            $table->boolean('is_cover')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('instrument_images');
    }
};
