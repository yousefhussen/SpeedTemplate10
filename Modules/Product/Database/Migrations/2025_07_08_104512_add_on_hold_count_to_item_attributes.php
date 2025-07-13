<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('item_attributes', function (Blueprint $table) {
            $table->integer('on_hold_count')->default(0);// Adding on_hold_count column
        });
    }

    public function down(): void
    {
        Schema::table('item_attributes', function (Blueprint $table) {
            $table->dropColumn('on_hold_count'); // Dropping on_hold_count column
        });
    }
};
