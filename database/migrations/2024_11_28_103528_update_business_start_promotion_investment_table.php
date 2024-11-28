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
        Schema::table('business_start_promotion_investment', function (Blueprint $table) {
            if (Schema::hasColumn('business_start_promotion_investment', 'business_id')) {
                $table->dropForeign(['business_id']);
                $table->dropColumn('business_id');
            }
            if (!Schema::hasColumn('business_start_promotion_investment', 'name')) {
                $table->string('name')->after('id');
            }

            if (!Schema::hasColumn('business_start_promotion_investment', 'birth_year')) {
                $table->year('birth_year')->after('name');
            }

            if (!Schema::hasColumn('business_start_promotion_investment', 'gender')) {
                $table->enum('gender', ['male', 'female', 'other'])->after('birth_year');
            }

            if (!Schema::hasColumn('business_start_promotion_investment', 'phone')) {
                $table->string('phone')->after('gender');
            }

            if (!Schema::hasColumn('business_start_promotion_investment', 'startup_address')) {
                $table->text('startup_address')->after('phone');
            }

            if (!Schema::hasColumn('business_start_promotion_investment', 'business_field')) {
                $table->string('business_field')->after('startup_address');
            }

            if (!Schema::hasColumn('business_start_promotion_investment', 'startup_activity_info')) {
                $table->text('startup_activity_info')->nullable()->after('business_field');
            }
            $table->longText('business_support_needs_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('business_start_promotion_investment', function (Blueprint $table) {
            $columns = [
                'name',
                'birth_year',
                'gender',
                'phone',
                'startup_address',
                'business_field',
                'startup_activity_info',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('business_start_promotion_investment', $column)) {
                    $table->dropColumn($column);
                }
            }

            // Thêm lại cột business_id
            if (!Schema::hasColumn('business_start_promotion_investment', 'business_id')) {
                $table->foreignId('business_id')->nullable()->after('id')->constrained()->cascadeOnDelete();
            }
            $table->unsignedBigInteger('business_support_needs_id')->change();
        });
    }
};
