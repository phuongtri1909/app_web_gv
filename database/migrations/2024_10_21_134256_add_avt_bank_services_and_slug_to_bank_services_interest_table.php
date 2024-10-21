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
        Schema::table('bank_services_interest', function (Blueprint $table) {
            $table->string('avt_bank_services')->nullable();
            $table->string('slug')->unique()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bank_services_interest', function (Blueprint $table) {
            $table->dropColumn('avt_bank_services');
            $table->dropColumn('slug');
        });
    }

};
