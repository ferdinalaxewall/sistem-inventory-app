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
        Schema::create('incoming_goods_items', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->foreignUuid('item_id')
                ->references('uuid')
                ->on('items')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->bigInteger('initial_stock')->default(0);
            $table->bigInteger('total_stock')->default(0);
            $table->bigInteger('current_stock')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incoming_goods_items');
    }
};
