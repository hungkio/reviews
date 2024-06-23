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
        Schema::create('setting_review_destination', function (Blueprint $table) {
            $table->id();
            $table->string('account_id')->nullable();
            $table->string('social')->nullable();
            $table->string('username')->nullable();
            $table->string('url')->nullable();
            $table->tinyInteger('send_notice')->comment('1: có gửi email, 0: Không gửi email')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setting_review_destination');
    }
};
