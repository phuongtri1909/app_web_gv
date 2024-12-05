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
        Schema::table('business_registrations', function (Blueprint $table) {
            $table->string('phone_zalo')->nullable()->change();
            $table->string('representative_full_name')->nullable()->change();
            $table->string('representative_phone')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('business_registrations', function (Blueprint $table) {
            $table->string('phone_zalo')->nullable(false)->change();
            $table->string('representative_full_name')->nullable(false)->change();
            $table->string('representative_phone')->nullable(false)->change();
        });
    }
};
