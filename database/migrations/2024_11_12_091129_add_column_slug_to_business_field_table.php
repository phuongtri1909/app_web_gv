<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('business_fields', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('name');
        });

        // Transfer data from 'name' to 'slug' with transformation
        $businessFields = DB::table('business_fields')->get();

        foreach ($businessFields as $field) {
            $slug = Str::slug($field->name, '-');
            DB::table('business_fields')
                ->where('id', $field->id)
                ->update(['slug' => $slug]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('business_fields', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};