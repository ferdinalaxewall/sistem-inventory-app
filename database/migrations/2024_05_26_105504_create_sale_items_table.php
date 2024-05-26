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
        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->foreignUuid('sale_id')
                ->references('uuid')
                ->on('sales')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignUuid('item_id')
                ->references('uuid')
                ->on('items')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->bigInteger('hpp')->default(0);
            $table->bigInteger('price')->default(0);
            $table->bigInteger('quantity')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_items');
    }
};
