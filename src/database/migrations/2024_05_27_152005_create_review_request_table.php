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
        Schema::create('review_request', function (Blueprint $table) {
            $table->id();
            $table->string('account_id')->nullable();
            $table->string('interval_date')->nullable();
            $table->string('interval_type')->nullable();
            $table->string('rating_style')->nullable();
            $table->text('email_subject')->nullable();
            $table->longText('email_body')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_request');
    }
};
