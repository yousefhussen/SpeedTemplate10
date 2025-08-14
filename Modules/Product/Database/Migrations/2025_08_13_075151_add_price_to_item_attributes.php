<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('item_attributes', function (Blueprint $table) {

            $table->decimal('price', 10, 2)->after('amount')->default(0.00)->comment('Price of the item attribute');
        });
    }

    public function down(): void
    {
        Schema::table('item_attributes', function (Blueprint $table) {
            //
        });
    }
};
