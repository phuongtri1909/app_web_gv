<?php

use App\Models\Tab;
use App\Models\User;
use App\Models\SlideProgram;
use UniSharp\LaravelFilemanager\Lfm;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LawsController;
use App\Http\Controllers\TabsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BanksController;
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\PaperController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\BannersController;
use App\Http\Controllers\TagNewsController;
use App\Http\Controllers\TuitionController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\EvironmentController;
use App\Http\Controllers\TabsCustomController;
use App\Http\Controllers\LegalAdviceController;
use App\Http\Controllers\BankServicerController;
use App\Http\Controllers\CategoryNewsController;
use App\Http\Controllers\CustomUploadController;
use App\Http\Controllers\ParentsChildController;
use App\Http\Controllers\SlideProgramController;
use App\Http\Controllers\TabAdmissionController;
use App\Http\Controllers\TestimonialsController;
use App\Models\BusinessStartPromotionInvestment;
use App\Http\Controllers\AdminQuestionController;
use App\Http\Controllers\BusinessFieldController;
use App\Http\Controllers\DetailContentController;
use App\Http\Controllers\TabDetailPostController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\MemberBusinessController;
use App\Http\Controllers\TabsForParentsController;
use App\Http\Controllers\ProductBusinessController;
use App\Http\Controllers\ProgramOverviewController;
use App\Http\Controllers\AdmissionProcessController;
use App\Http\Controllers\BusinessFeedBackController;
use App\Http\Controllers\CategoryQuestionController;
use App\Http\Controllers\CustomerInterestController;
use App\Http\Controllers\FinancialSupportController;
use App\Http\Controllers\BusinessCapitalNeedController;
use App\Http\Controllers\BusinessRecruitmentController;
use App\Http\Controllers\ContactConsultationController;
use App\Http\Controllers\AdmissionProcessDetailController;
use App\Http\Controllers\BusinessFairRegistrationController;
use App\Http\Controllers\NewsTabContentDetailPostController;
use App\Http\Controllers\PersonalBusinessInterestController;
use App\Http\Controllers\BusinessStartPromotionInvestmentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['language'])->group(function () {

    Route::get('/clear-cache', function () {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        return "Cache is cleared";
    })->name('clear.cache');

    Route::group(['prefix' => 'client'], function () {
        Route::get('business', [BusinessController::class, 'business'])->name('business');
        Route::get('business/{business_code}', [BusinessController::class, 'businessDetail'])->name('business.detail');
        Route::get('business-products', [BusinessController::class, 'businessProducts'])->name('business.products');
        Route::get('product/{slug}', [BusinessController::class, 'productDetail'])->name('product.detail');

        Route::get('/home-bank/{slug}', [FinancialSupportController::class, 'showFinancial'])->name('show.financical');
        Route::get('/home-bank', [BanksController::class, 'showHomeBank'])->name('show.home.bank');

        Route::get('/post-detail/{slug}', [BlogsController::class, 'showPostIndex'])->name('post-detail');

        //tạm gán như này cho kết nối việc làm
        Route::get('/job-connector', [BusinessRecruitmentController::class, 'jobConnector'])->name('job-connector');

        Route::get('/legal-advice', [ContactConsultationController::class, 'legalAdvice'])->name('legal-advice');

        //Locations
        Route::get('/locations', [LocationController::class, 'clientIndex'])->name('locations');
        Route::get('/search-locations', [LocationController::class, 'searchLocations'])->name('search.locations');
        Route::get('/get-locations', [LocationController::class, 'getAllLocations'])->name('get.locations');

        //cho phường 17
        Route::get('/locations-17', [LocationController::class, 'clientIndex'])->name('locations-17');

        //tam gán trang intro HDN
        Route::get('/intro-hdn', function () {
            return view('pages.client.introduction-hdn');
        })->name('introduction');

        Route::get('form-check-business', function () {
            return view('pages.client.gv.form-check-business');
        })->name('form.check.business');

        Route::get('/member-business', [MemberBusinessController::class, 'showFormMemberBusiness'])->name('show.form.member.business'); //form đk hội viên doanh nghiệp chuyển sang đk app
        Route::post('/member-business', [MemberBusinessController::class, 'storFormMemberBusiness'])->name('form.member.business.store');

        Route::get('/form-job-application', [JobApplicationController::class, 'jobApplication'])->name('job.application'); //form ứng tuyển
        Route::post('/form-job-application', [JobApplicationController::class, 'storeForm'])->name('job.application.store');

        Route::middleware(['check.business.code'])->group(function () {

            Route::post('form-check-business', function () {
                
            })->name('form.check.business');

            Route::get('/form-connect-supply-demand', [ProductBusinessController::class, 'connectSupplyDemand'])->name('connect.supply.demand'); //form kết nối cung cầu
            Route::post('/form-connect-supply-demand', [ProductBusinessController::class, 'storeConnectSupplyDemand'])->name('connect.supply.demand.store');

            Route::get('/form-start-promotion', [BusinessStartPromotionInvestmentController::class, 'showFormStartPromotion'])->name('show.form.start.promotion'); // khởi nghiệp xúc tiến thương mại đầu tư
            Route::post('/form-start-promotion', [BusinessStartPromotionInvestmentController::class, 'storeFormStartPromotion'])->name('form.start.promotion.store');

            Route::get('/form-registering-capital-needs/{slug?}', [BusinessCapitalNeedController::class, 'showFormCapitalNeeds'])->name('show.form.capital.need'); //ĐĂNG KÝ NHU CẦU VỀ VỐN
            Route::post('/form-registering-capital-needs', [BusinessCapitalNeedController::class, 'storeFormCapitalNeeds'])->name('show.form.capital.need.store');

            Route::get('/form-promotional-introduction', [LocationController::class, 'showFormPromotional'])->name('show.form.promotional'); //form đăng ký điểm đến
            Route::post('/form-promotional-introduction', [LocationController::class, 'storeFormPromotional'])->name('form.promotional.store');

            Route::get('/form-recruitment-registration', [BusinessRecruitmentController::class, 'recruitmentRegistration'])->name('recruitment.registration'); //form đăng ký tuyển dụng
            Route::post('/form-recruitment-registration', [BusinessRecruitmentController::class, 'storeForm'])->name('recruitment.registration.store');

            Route::get('/form-business-opinion', [BusinessFeedBackController::class, 'businessOpinion'])->name('business.opinion'); //form ý kiến doanh nghiệp
            // Route::post('/form-business-opinion', [BusinessFeedBackController::class, 'storeBusinessOpinion'])->name('business.opinion.store');

            Route::post('/form-business', [BusinessController::class, 'store'])->name('business.store'); //form đăng ký doanh nghiệp
            Route::get('/form-business', [BusinessController::class, 'index'])->name('business.index');

            Route::get('/form-legal-advice', [LegalAdviceController::class, 'showFormLegal'])->name('show.form.legal'); //form tư vấn pháp lý
            Route::post('/form-legal-advice', [LegalAdviceController::class, 'storeForm'])->name('legal.advice.store');

            Route::get('/business-fair-registrations/{news_id}', [BusinessFairRegistrationController::class, 'businessFairRegistration'])->name('business-fair-registrations');
            Route::post('/business-fair-registrations', [BusinessFairRegistrationController::class, 'storeBusinessFairRegistration'])->name('business-fair-registrations.store');
            Route::get('/fair-registrations', [BusinessFairRegistrationController::class, 'businessFairRegistrations'])->name('business.fair.registrations');
        });
    });

    Route::get('switch-language/{locale}', [LanguageController::class, 'switchLanguage'])->name('language.switch');

    Route::get('/b/blogs', [BlogsController::class, 'blogIndex'])->name('list-blogs');

    Route::get('/detail-blog/{slug}', [BlogsController::class, 'showBlogIndex'])->name('detail-blog');
    Route::get('/detail-blog/mini/{slug}', [BlogsController::class, 'showBlogIndexMini'])->name('detail-blog-mini');

    Route::get('page-tab/{slug}', function ($slug) {
        return view('pages.tab-custom.index', compact('slug'));
    })->name('page.tab');

    Route::middleware(['auth'])->group(function () {
        Route::get('/logout', [AuthController::class, 'logout'])->name('admin.logout');
        Route::middleware(['role.admin'])->group(function () {
            Route::prefix('admin')->group(function () {
                Route::get('/', function () {
                    return view('admin.pages.dashboard');
                })->name('admin.dashboard');


                Route::resource('languages', LanguageController::class)->except(['show']);
                Route::get('languages/edit-system/{locale}', [LanguageController::class, 'editSystem'])->name('languages.edit-system');
                Route::put('languages/update-system/{locale}', [LanguageController::class, 'updateSystem'])->name('languages.update-system');


                Route::resource('tags-news', TagNewsController::class);
                Route::resource('categories-news', CategoryNewsController::class);
                Route::resource('news', BlogsController::class);

                Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
                    Lfm::routes();
                
                    Route::post('/upload', [CustomUploadController::class, 'upload'])->name('lfm.upload');
                });
                

                Route::resource('tabs_posts', TabDetailPostController::class);
                Route::resource('news_contents', NewsTabContentDetailPostController::class);

                Route::resource('bank-servicers', BankServicerController::class);

                Route::resource('personal-business-interests', PersonalBusinessInterestController::class);

                Route::resource('financial-support', FinancialSupportController::class);

                Route::resource('banks', BanksController::class);

                Route::resource('businesses', BusinessController::class)->except('create', 'store', 'edit', 'update');

                Route::resource('start-promotion-investment', BusinessStartPromotionInvestmentController::class);

                Route::resource('capital-needs', BusinessCapitalNeedController::class);

                Route::resource('job-applications', JobApplicationController::class)->except('create', 'store', 'edit', 'update');

                Route::resource('feedback', BusinessFeedBackController::class)->except('show');

                Route::resource('recruitment',  BusinessRecruitmentController::class)->except('create', 'store', 'edit', 'update','show');

                Route::get('/form-business', [BusinessController::class, 'adminIndex'])->name('admin.business');

                Route::post('/update-status', [StatusController::class, 'updateStatus'])->name('update.status');
                Route::post('/update-status-1', [StatusController::class, 'updateStatus1'])->name('update.status.1');

                Route::resource('members',  MemberBusinessController::class)->except('create', 'store', 'edit', 'update');

                Route::resource('business-fields',  BusinessFieldController::class);

                Route::resource('contact-consultations',  ContactConsultationController::class);

                Route::resource('form-legal-advice',  LegalAdviceController::class)->except('create', 'store', 'edit', 'update');

                Route::resource('users', UserController::class)->except('show');

                Route::post('/user/status', [UserController::class, 'changeStatus'])->name('user.changeStatus');

                Route::resource('fair-registrations', BusinessFairRegistrationController::class)->except('show');
                Route::get('business-products', [ProductBusinessController::class, 'index'])->name('business.products.index');
                Route::get('business-products/detail/{id}', [ProductBusinessController::class, 'show'])->name('business.products.show');
                Route::delete('business-products/destroy/{id}', [ProductBusinessController::class, 'destroy'])->name('business.products.destroy');
            
                Route::get('locations', [LocationController::class, 'index'])->name('locations.index');
                Route::delete('locations/destroy/{id}', [LocationController::class, 'destroy'])->name('locations.destroy');
                Route::get('locations/detail/{id}', [LocationController::class, 'show'])->name('locations.show');
            });
        });

        Route::middleware(['role.business'])->group(function () {});
    });

    Route::middleware(['guest'])->group(function () {
        Route::get('/login', function () {
            return view('admin.pages.auth.login');
        })->name('admin.login');

        Route::post('/login', [AuthController::class, 'login'])->name('admin.login');
    });
});
