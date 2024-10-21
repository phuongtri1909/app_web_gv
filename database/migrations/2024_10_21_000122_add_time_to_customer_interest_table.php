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
        Schema::table('customer_interest', function (Blueprint $table) {
            $table->string('time')->after('financial_support_id');
        });
    }

    public function down()
    {
        Schema::table('customer_interest', function (Blueprint $table) {
            $table->dropColumn('time'); 
        });
    }

};
