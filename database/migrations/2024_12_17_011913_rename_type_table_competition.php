<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
    
        DB::statement("ALTER TABLE `competition` MODIFY COLUMN `type` ENUM('competition', 'survey-p') NOT NULL DEFAULT 'competition';");
    }
    
    public function down(): void
    {
        
        DB::statement("ALTER TABLE `competition` MODIFY COLUMN `type` ENUM('competition', 'survey') NOT NULL DEFAULT 'competition';");
    }
    
};
