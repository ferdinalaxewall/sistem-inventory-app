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
            $table->foreignUuid('incoming_goods_id')
                ->after('uuid')
                ->references('uuid')
                ->on('incoming_goods')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
