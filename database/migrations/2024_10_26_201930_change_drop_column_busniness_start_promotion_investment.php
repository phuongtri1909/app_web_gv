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
        Schema::table('business_start_promotion_investment', function (Blueprint $table) {
            $columns = [
                'representative_name',
                'birth_year', 
                'gender',
                'phone',
                'address',
                'business_address', 
                'business_name',
                'business_field',
                'business_code',
                'email',
                'fanpage'
            ];
        
            foreach ($columns as $column) {
                if (Schema::hasColumn('business_start_promotion_investment', $column)) {
                    $table->dropColumn($column);
                }
            }

            if (!Schema::hasColumn('business_start_promotion_investment', 'business_id')) {
                $table->foreignId('business_id')->nullable()->after('id')->constrained()->cascadeOnDelete();
            }
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('business_start_promotion_investment', function (Blueprint $table) {
            $table->string('representative_name');
            $table->year('birth_year');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('phone');
            $table->string('address');
            $table->string('business_address');
            $table->string('business_name');
            $table->string('business_field');
            $table->string('business_code');
            $table->string('email');
            $table->string('fanpage')->nullable();
            $table->dropForeign(['business_id']);
            $table->dropColumn('business_id');
        });
    }
};
