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
        Schema::table('personal_business_interest', function (Blueprint $table) {
            $table->string('name')->change();
        });

        Schema::table('bank_services_interest', function (Blueprint $table) {
            $table->string('name')->change();
        });
    }

    public function down()
    {
        Schema::table('personal_business_interest', function (Blueprint $table) {
            $table->json('name')->change();
        });

        Schema::table('bank_services_interest', function (Blueprint $table) {
            $table->json('name')->change();
        });
    }

};
