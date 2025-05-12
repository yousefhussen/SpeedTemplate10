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
        Schema::create('item_attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('itemId')->constrained("items"); // Matches ERD's camelCase
            $table->string('color');
            $table->string('size');
            $table->integer('amount'); // Stock quantity
            $table->timestamps(); // Optional

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_attributes');
    }
};
