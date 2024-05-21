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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('account_id')->nullable();
            $table->string('customers_id')->nullable();
            $table->string('email')->unique();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('object')->nullable();
            $table->json('address')->nullable();
            $table->float('balance')->nullable();
            $table->string('currency')->nullable();
            $table->string('default_source')->nullable();
            $table->boolean('delinquent')->nullable();
            $table->string('description')->nullable();
            $table->string('discount')->nullable();
            $table->string('invoice_prefix')->nullable();
            $table->json('invoice_settings')->nullable();
            $table->string('metadata')->nullable();
            $table->float('next_invoice_sequence')->nullable();
            $table->json('preferred_locales')->nullable();
            $table->json('shipping')->nullable();
            $table->string('tax_exempt')->nullable();
            $table->string('test_clock')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
