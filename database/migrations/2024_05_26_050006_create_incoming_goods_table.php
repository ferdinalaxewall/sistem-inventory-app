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
        Schema::create('incoming_goods', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->char('code', 14);
            $table->foreignUuid('supplier_id')
                ->nullable()
                ->references('uuid')
                ->on('suppliers')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignUuid('user_id')
                ->references('uuid')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->date('incoming_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incoming_goods');
    }
};
