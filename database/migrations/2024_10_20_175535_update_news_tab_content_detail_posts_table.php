<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateNewsTabContentDetailPostsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('news_tab_content_detail_posts', function (Blueprint $table) {
            // Kiểm tra và xóa khóa ngoại nếu tồn tại
            if (Schema::hasColumn('news_tab_content_detail_posts', 'news_id')) {
                $sm = Schema::getConnection()->getDoctrineSchemaManager();
                $doctrineTable = $sm->listTableDetails('news_tab_content_detail_posts');
                if ($doctrineTable->hasForeignKey('news_tab_content_detail_posts_news_id_foreign')) {
                    $table->dropForeign(['news_id']);
                }
                $table->dropColumn('news_id');
            }

            // Thêm cột financial_support_id
            $table->foreignId('financial_support_id')->constrained('financial_support')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news_tab_content_detail_posts', function (Blueprint $table) {
            // Thêm lại cột news_id và khóa ngoại nếu cần
            $table->unsignedBigInteger('news_id');
            $table->foreign('news_id')->references('id')->on('news')->onDelete('cascade');

            // Xóa cột financial_support_id
            $table->dropForeign(['financial_support_id']);
            $table->dropColumn('financial_support_id');
        });
    }
}