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
            $table->foreignId('business_field_id')->nullable()->after('id')->constrained('business_fields'); //location cũng có ngành nghề kinh doanh lấy của business field
            $table->string('description')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->dropForeign(['business_field_id']);
            $table->dropColumn('business_field_id');
            $table->string('description')->change();
        });
    }
};
