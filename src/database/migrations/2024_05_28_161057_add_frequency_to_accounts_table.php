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
        Schema::table('accounts', function (Blueprint $table) {
            //
            $table->unsignedTinyInteger('frequency')->nullable()->comment('Frequency of review requests: 0=Every payment, 1=First payment only, 2=Skip first payment, send from second onwards, 3=Skip first two payments, send from third onwards, 4=Alternative payments, 5=Skip the customer when a review has been submitted before')->after('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('accounts', function (Blueprint $table) {
            //
            $table->dropColumn('frequency');
        });
    }
};