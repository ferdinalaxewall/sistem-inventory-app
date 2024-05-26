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
        Schema::table('incoming_goods_items', function (Blueprint $table) {
            $table->bigInteger('initial_stock')->default(0)->after('item_id');
            $table->bigInteger('current_stock')->default(0)->after('total_stock');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('incoming_goods_items', function (Blueprint $table) {
            //
        });
    }
};
