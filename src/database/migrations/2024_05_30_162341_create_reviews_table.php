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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('star');
            $table->string('review')->nullable();
            $table->string('order')->nullable();
            $table->string('customer_id')->nullable();
            $table->string('account_id')->nullable();
            $table->string('source')->nullable();
            $table->tinyInteger('status')->comment('null: no status, 1: approved, 0 denied')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
