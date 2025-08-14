<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('item_attributes', function (Blueprint $table) {
            $table->unique(['item_id', 'color', 'size'], 'item_color_size_unique')
                  ->comment('Unique index for item attributes based on item_id, color, and size');
        });
    }

    public function down(): void
    {
        Schema::table('item_attribute', function (Blueprint $table) {
            $table->dropUnique('item_color_size_unique');
        });
    }
};
