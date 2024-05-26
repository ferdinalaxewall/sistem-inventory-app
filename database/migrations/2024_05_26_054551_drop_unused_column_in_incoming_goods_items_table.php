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
            if (Schema::hasColumn('incoming_goods_items', 'initial_stock')) $table->dropColumn('initial_stock');
            if (Schema::hasColumn('incoming_goods_items', 'current_stock')) $table->dropColumn('current_stock');
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
