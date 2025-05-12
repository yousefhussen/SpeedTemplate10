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
        Schema::create('items', function (Blueprint $table) {
            $table->id(); // Manual primary key (string)
            $table->string('name');
            $table->string('brand');
            $table->decimal('price', 8, 2); // e.g., 1000.99
            $table->string('image'); // Path to image
            $table->decimal('totalRating', 3, 2)->default(0); // e.g., 4.50
            $table->timestamps(); // Optional (not in ERD)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
