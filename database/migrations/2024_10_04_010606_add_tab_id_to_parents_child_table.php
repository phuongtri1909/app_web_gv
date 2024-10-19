<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('parents_child', function (Blueprint $table) {
            $table->unsignedBigInteger('tab_id')->nullable()->after('id');

            $table->foreign('tab_id')->references('id')->on('tabs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('parents_child', function (Blueprint $table) {
            $table->dropForeign(['tab_id']);
            $table->dropColumn('tab_id');
        });
    }
};
