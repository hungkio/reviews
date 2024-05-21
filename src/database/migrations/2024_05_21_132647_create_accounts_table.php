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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('accounts_id')->nullable();
            $table->string('object')->nullable();
            $table->json('capabilities')->nullable();
            $table->boolean('charges_enabled')->nullable();
            $table->string('country')->nullable();
            $table->string('default_currency')->nullable();
            $table->string('details_submitted')->nullable();
            $table->json('future_requirements')->nullable();
            $table->boolean('payouts_enabled')->nullable();
            $table->json('requirements')->nullable();
            $table->json('settings')->nullable();
            $table->string('type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
