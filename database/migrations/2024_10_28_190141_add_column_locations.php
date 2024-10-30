<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('locations', function (Blueprint $table) {
            DB::statement('ALTER TABLE locations CHANGE business_code_id business_id BIGINT UNSIGNED');
            $table->foreign('business_id')
                  ->references('id')
                  ->on('businesses')
                  ->onDelete('cascade');

            $table->text('description');
            $table->string('image');
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->dropForeign(['business_id']);
            DB::statement('ALTER TABLE locations CHANGE business_id business_code_id BIGINT UNSIGNED');
            $table->foreign('business_code_id')
                ->references('id')
                ->on('businesses')
                ->onDelete('cascade');

            $table->dropColumn(['description', 'image', 'status']);
            $table->dropTimestamps();
        });
    }
};
