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
        Schema::table('customers', function (Blueprint $table) {
            //
            $table->enum('status_email', [
                'Scheduled',
                'Sent',
                'Canceled',
                'Reviews',
                'Opened',
                'Delivered',
                'Unsubscribed'
            ])->default('Scheduled');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            //
            $table->dropColumn('status_email');
        });
    }
};
