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
        Schema::table('customer_interest', function (Blueprint $table) {
            // Kiểm tra và xóa khóa ngoại nếu tồn tại
            if (Schema::hasColumn('customer_interest', 'bank_services_id')) {
                $sm = Schema::getConnection()->getDoctrineSchemaManager();
                $doctrineTable = $sm->listTableDetails('customer_interest');
                if ($doctrineTable->hasForeignKey('customer_interest_bank_services_id_foreign')) {
                    $table->dropForeign(['bank_services_id']);
                }
                $table->dropColumn('bank_services_id');
            }

            if (Schema::hasColumn('customer_interest', 'interest_id')) {
                $sm = Schema::getConnection()->getDoctrineSchemaManager();
                $doctrineTable = $sm->listTableDetails('customer_interest');
                if ($doctrineTable->hasForeignKey('customer_interest_interest_id_foreign')) {
                    $table->dropForeign(['interest_id']);
                }
                $table->dropColumn('interest_id');
            }

            $table->dropColumn('time');
            $table->string('birth_year');
            $table->string('gender');
            $table->string('residence_address');
            $table->string('business_address');
            $table->string('company_name');
            $table->string('business_field');
            $table->string('tax_code');
            $table->string('email');
            $table->string('fanpage')->nullable();
            $table->text('support_needs');
        });
    }

    public function down()
    {
        Schema::table('customer_interest', function (Blueprint $table) {
            $table->foreignId('bank_services_id')->constrained('bank_services_interest')->nullable();
            $table->foreignId('interest_id')->constrained('personal_business_interest')->nullable();
            $table->string('time')->nullable();

            $table->dropColumn([
                'birth_year', 'gender', 'residence_address', 'business_address',
                'company_name', 'business_field', 'tax_code', 'email',
                'fanpage', 'support_needs'
            ]);
        });
    }
};
