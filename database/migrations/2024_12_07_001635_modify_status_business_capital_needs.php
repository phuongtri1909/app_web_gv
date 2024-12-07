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
        Schema::table('business_capital_needs', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->enum('email_status', ['sent', 'not_sent'])->default('not_sent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('business_capital_needs', function (Blueprint $table) {
            $table->dropColumn('email_status');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
        });
    }
};
