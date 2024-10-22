<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('customer_interest', function (Blueprint $table) {
            $table->unsignedBigInteger('financial_support_id')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('customer_interest', function (Blueprint $table) {
            $table->unsignedBigInteger('financial_support_id')->nullable(false)->change();
        });
    }
};
