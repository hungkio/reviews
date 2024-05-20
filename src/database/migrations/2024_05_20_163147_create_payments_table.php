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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('object_id')->nullable();
            $table->string('payment_intent_id')->nullable();
            $table->string('object')->nullable();
            $table->integer('amount');
            $table->integer('amount_capturable')->default(0);
            $table->json('amount_details')->nullable();

            $table->integer('amount_received')->nullable();
            $table->string('application')->nullable();
            $table->string('currency');
            $table->string('customer')->nullable();
            $table->text('description')->nullable();
            $table->string('latest_charge')->nullable();
            $table->boolean('livemode')->default(false);
            $table->string('metadata')->nullable();
            $table->string('payment_method')->nullable();
            $table->json('payment_method_types')->nullable();
            $table->string('status');
            $table->string('request_id')->nullable();
            $table->string('idempotency_key')->nullable();

            $table->integer('amount_details_tip')->default(0);
            $table->integer('application_fee_amount')->nullable();
            $table->string('automatic_payment_methods')->nullable();
            $table->timestamp('canceled_at')->nullable();
            $table->string('cancellation_reason')->nullable();
            $table->string('capture_method')->nullable();
            $table->string('client_secret')->nullable();
            $table->string('confirmation_method')->nullable();
            $table->string('invoice')->nullable();
            $table->text('last_payment_error')->nullable();
            $table->text('next_action')->nullable();
            $table->string('on_behalf_of')->nullable();
            $table->string('payment_method_configuration_details')->nullable();
            $table->json('payment_method_options')->nullable();
            $table->boolean('processing')->nullable();
            $table->string('receipt_email')->nullable();
            $table->string('review')->nullable();
            $table->string('setup_future_usage')->nullable();
            $table->string('shipping')->nullable();
            $table->string('source')->nullable();
            $table->string('statement_descriptor')->nullable();
            $table->string('statement_descriptor_suffix')->nullable();
            $table->string('transfer_data')->nullable();
            $table->string('transfer_group')->nullable();
            $table->string('pending_webhooks')->nullable();
            $table->json('request')->nullable();
            $table->string('type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};