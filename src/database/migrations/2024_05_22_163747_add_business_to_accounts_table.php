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
            $table->string('business_name')->nullable();
            $table->string('website_url')->nullable();
            $table->string('logo')->nullable();
            $table->string('color')->nullable();
            $table->string('from_email')->nullable();
            $table->string('reply_to_email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('accounts', function (Blueprint $table) {
            //
            $table->dropColumn('business_name');
            $table->dropColumn('website_url');
            $table->dropColumn('logo');
            $table->dropColumn('color');
            $table->dropColumn('from_email');
            $table->dropColumn('reply_to_email');
        });
    }
};
