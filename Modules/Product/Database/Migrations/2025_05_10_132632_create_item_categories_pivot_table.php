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
        Schema::create('item_categories', function (Blueprint $table) {
            $table->id(); // Pivot table has its own ID (per ERD)
            $table->foreignId('item_id')->constrained('items'); // Matches ERD's camelCase
            $table->foreignId('categoryId')->constrained('categories'); // Matches ERD's camelCase
            $table->timestamps(); // Optional
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_categories_pivot');
    }
};
