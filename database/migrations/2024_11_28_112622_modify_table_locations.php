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
        Schema::table('locations', function (Blueprint $table) {

            $table->dropForeign(['business_id']);
            $table->dropColumn('business_id'); 
            $table->dropColumn('image');

            $table->unsignedBigInteger('business_member_id')->nullable();

            // Add the foreign key constraint
            $table->foreign('business_member_id')
                  ->references('id')
                  ->on('business_registrations')
                  ->onDelete('set null');
            


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->foreignId('business_id')->constrained('business_registrations')->onDelete('set null');
            $table->string('image')->nullable();
            $table->dropForeign(['business_member_id']);
            $table->dropColumn('business_member_id');
        });
    }
};
