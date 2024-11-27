<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('product_businesses', function (Blueprint $table) {

            $table->dropColumn('product_story');
            $table->dropColumn('price_mini_app');
            $table->dropColumn('start_date');
            $table->dropColumn('end_date');

            $table->text('related_confirmation_document')->nullable();

            $table->unsignedBigInteger('business_member_id')->nullable();
        });
        DB::statement('UPDATE product_businesses SET business_member_id = business_id');
        Schema::table('product_businesses', function (Blueprint $table) {
            $table->foreign('business_member_id')->references('id')->on('business_registrations')->onDelete('cascade');

            $table->unsignedBigInteger('business_member_id')->nullable(false)->change();

            $table->dropForeign(['business_id']);
            $table->dropColumn('business_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_businesses', function (Blueprint $table) {
            $table->string('product_story')->nullable();
            $table->string('price_mini_app')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
        });



        Schema::table('product_businesses', function (Blueprint $table) {
            $table->dropColumn('related_confirmation_document');

            $table->unsignedBigInteger('business_id')->nullable();
        });

        DB::statement('UPDATE product_businesses SET business_id = business_member_id');

        Schema::table('product_businesses', function (Blueprint $table) {

            $table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade');

            $table->dropForeign(['business_member_id']);
            $table->dropColumn('business_member_id');
        });
    }
};
