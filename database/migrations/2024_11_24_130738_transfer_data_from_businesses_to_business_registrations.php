<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('businesses')->orderBy('id')->chunk(100, function ($businesses) {
            foreach ($businesses as $business) {
                DB::table('business_registrations')->insert([
                    'id' => $business->id,
                    'business_name' => $business->business_name,
                    'business_code' => $business->business_code,
                    'address' => $business->business_address,
                    'business_field_id' => $business->business_fields, 
                    'email' => $business->email,
                    'phone_zalo' => $business->phone_number,
                    'representative_full_name' => $business->representative_name,
                    'representative_phone' => $business->phone_number,
                    'status' => $business->status,
                    'created_at' => $business->created_at,
                    'updated_at' => $business->updated_at,
                ]);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
    }
};
