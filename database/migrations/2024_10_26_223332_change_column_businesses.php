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
        Schema::table('businesses', function (Blueprint $table) {
            // $table->unsignedBigInteger('ward_id')->nullable()->change();
            // $table->string('address')->nullable()->change();
            // $table->string('avt_businesses')->nullable()->change();
    
            // $table->enum('status', ['pending', 'approved', 'rejected', 'other'])->default('pending')->change();
    
            // $table->unsignedBigInteger('business_fields')->nullable()->change();
            // $table->foreign('business_fields')
            //     ->references('id')
            //     ->on('business_fields')
            //     ->onDelete('cascade');
                });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('businesses', function (Blueprint $table) {
            $table->unsignedBigInteger('ward_id')->nullable(false)->change();
            $table->string('address')->nullable(false)->change();
            $table->string('avt_businesses')->nullable(false)->change();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->change();
            $table->dropForeign(['business_fields']);
            $table->dropColumn('business_fields');
        });
    }
};
