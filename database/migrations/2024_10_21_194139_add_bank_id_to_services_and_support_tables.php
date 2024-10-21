<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('bank_services_interest', function (Blueprint $table) {
            $table->foreignId('bank_id')->nullable()->after('slug')->constrained('banks')->onDelete('cascade');
        });

        Schema::table('financial_support', function (Blueprint $table) {
            $table->foreignId('bank_id')->nullable()->after('slug')->constrained('banks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bank_services_interest', function (Blueprint $table) {
            $table->dropForeign(['bank_id']);
            $table->dropColumn('bank_id');
        });

        Schema::table('financial_support', function (Blueprint $table) {
            $table->dropForeign(['bank_id']);
            $table->dropColumn('bank_id');
        });
    }
};
