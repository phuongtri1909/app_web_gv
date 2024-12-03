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
        Schema::table('business_registrations', function (Blueprint $table) {
            Schema::table('business_registrations', function (Blueprint $table) {
                $table->dropForeign('business_registrations_business_field_id_foreign');
                $table->dropIndex('business_registrations_business_field_id_foreign');
            });
        
            Schema::table('business_registrations', function (Blueprint $table) {
                $table->longText('business_field_id')->nullable()->change();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('business_registrations', function (Blueprint $table) {
            $table->bigInteger('business_field_id')->unsigned()->nullable()->change();
            $table->foreign('business_field_id')
                ->references('id')
                ->on('business_fields')
                ->onDelete('set null');
        });
    }
};
