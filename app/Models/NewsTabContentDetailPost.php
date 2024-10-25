<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class NewsTabContentDetailPost extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = [
        'content',
    ];

    protected $table = 'news_tab_content_detail_posts';

    protected $fillable = ['content', 'financial_support_id', 'tab_id','bank_service_id'];


    public function tab()
    {
        return $this->belongsTo(TabDetailPost::class, 'tab_id');
    }


    public function financialSupport()
    {
        return $this->belongsTo(FinancialSupport::class, 'financial_support_id');
    }

    public function bankServices()
    {
        return $this->belongsTo(BankServicesInterest::class, 'bank_service_id');
    }
}
