<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyActiveColumnInSlidersTable extends Migration
{
    public function up()
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->enum('active', ['yes', 'no'])->default('yes')->change();
        });
    }

    public function down()
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->string('active')->change();
        });
    }
}
