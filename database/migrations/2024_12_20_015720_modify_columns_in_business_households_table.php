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
        Schema::table('business_households', function (Blueprint $table) {
            $table->string('license_number')->nullable()->change();
            $table->date('date_issued')->nullable()->change();
            $table->string('business_owner_full_name')->nullable()->change();
            $table->string('business_dob')->nullable()->change();
            $table->string('house_number')->nullable()->change();
            $table->text('business_field')->nullable()->change();
            $table->string('cccd')->nullable()->change();
            $table->string('address')->nullable()->change();

            $table->text('stalls')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('business_households', function (Blueprint $table) {
            $table->string('license_number')->nullable(false)->change();
            $table->date('date_issued')->nullable(false)->change();
            $table->string('business_owner_full_name')->nullable(false)->change();
            $table->string('business_dob')->nullable(false)->change();
            $table->string('house_number')->nullable(false)->change();
            $table->text('business_field')->nullable(false)->change();
            $table->string('cccd')->nullable(false)->change();
            $table->string('address')->nullable(false)->change();
            $table->dropColumn('stalls');
        });
    }
};
