<?php

use App\Models\Tab;
use App\Models\User;
use App\Models\SlideProgram;
use App\Models\BusinessHousehold;
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
use App\Http\Controllers\EmailController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\PaperController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AdTypeController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\BannersController;
use App\Http\Controllers\TagNewsController;
use App\Http\Controllers\TuitionController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\AdCategoryController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EvironmentController;
use App\Http\Controllers\OnlineXamsController;
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
use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\BusinessFieldController;
use App\Http\Controllers\DetailContentController;
use App\Http\Controllers\TabDetailPostController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\BusinessSurveyController;
use App\Http\Controllers\EmailTemplatesController;
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
use App\Http\Controllers\BusinessDashboardController;
use App\Http\Controllers\BusinessHouseholdController;
use App\Http\Controllers\SatisfactionSurveyController;
use App\Http\Controllers\BusinessCapitalNeedController;
use App\Http\Controllers\BusinessRecruitmentController;
use App\Http\Controllers\ContactConsultationController;
use App\Http\Controllers\DigitalTransformationController;
use App\Http\Controllers\AdmissionProcessDetailController;
use App\Http\Controllers\CitizenMeetingScheduleController;
use App\Http\Controllers\BusinessFairRegistrationController;
use App\Http\Controllers\NewsTabContentDetailPostController;
use App\Http\Controllers\PersonalBusinessInterestController;
use App\Http\Controllers\BusinessStartPromotionInvestmentController;
use App\Http\Controllers\CaptchaController;
use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\QuizController;

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

    Route::get('switch-language/{locale}', [LanguageController::class, 'switchLanguage'])->name('language.switch');

    Route::get('/b/blogs', [BlogsController::class, 'blogIndex'])->name('list-blogs');

    Route::get('/detail-blog/{slug}', [BlogsController::class, 'showBlogIndex'])->name('detail-blog');
    // Route::get('/detail-blog/mini/{slug}', [BlogsController::class, 'showBlogIndexMini'])->name('detail-blog-mini');

    Route::get('page-tab/{slug}', function ($slug) {
        return view('pages.tab-custom.index', compact('slug'));
    })->name('page.tab');

    Route::get('recruitment/{id}', [BusinessRecruitmentController::class, 'show'])->name('recruitment.show');

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
        Route::get('/job-connector/{id}', [BusinessRecruitmentController::class, 'jobConnectorDetail'])->name('job-connector.detail');

        Route::get('/legal-advice', [ContactConsultationController::class, 'legalAdvice'])->name('legal-advice');

        //Locations
        Route::get('/locations', [LocationController::class, 'clientIndex'])->name('locations');
        Route::get('/search-locations', [LocationController::class, 'searchLocations'])->name('search.locations');
        Route::get('/get-locations', [LocationController::class, 'getAllLocations'])->name('get.locations');

        //tam gán trang intro HDN
        Route::get('/intro-hdn', function () {
            return view('pages.client.introduction-hdn');
        })->name('introduction');

        Route::get('/member-business', [MemberBusinessController::class, 'showFormMemberBusiness'])->name('show.form.member.business'); //form đk hội viên doanh nghiệp chuyển sang đk app
        Route::post('/member-business', [MemberBusinessController::class, 'storFormMemberBusiness'])->name('form.member.business.store');

        Route::get('/form-job-application', [JobApplicationController::class, 'jobApplication'])->name('job.application'); //form ứng tuyển
        Route::post('/form-job-application', [JobApplicationController::class, 'storeForm'])->name('job.application.store');

        Route::middleware(['check.business.code', 'check.active', 'check.business.member'])->group(function () {

            Route::get('/form-connect-supply-demand', [ProductBusinessController::class, 'connectSupplyDemand'])->name('connect.supply.demand'); //form kết nối cung cầu
            Route::post('/form-connect-supply-demand', [ProductBusinessController::class, 'storeConnectSupplyDemand'])->name('connect.supply.demand.store');

            Route::get('/form-registering-capital-needs/{slug?}', [BusinessCapitalNeedController::class, 'showFormCapitalNeeds'])->name('show.form.capital.need'); //ĐĂNG KÝ NHU CẦU VỀ VỐN
            Route::post('/form-registering-capital-needs', [BusinessCapitalNeedController::class, 'storeFormCapitalNeeds'])->name('show.form.capital.need.store');

            Route::get('/form-promotional-introduction', [LocationController::class, 'showFormPromotional'])->name('show.form.promotional'); //form đăng ký điểm đến
            Route::post('/form-promotional-introduction', [LocationController::class, 'storeFormPromotional'])->name('form.promotional.store');

            Route::get('/form-recruitment-registration', [BusinessRecruitmentController::class, 'recruitmentRegistration'])->name('recruitment.registration'); //form đăng ký tuyển dụng
            Route::post('/form-recruitment-registration', [BusinessRecruitmentController::class, 'storeForm'])->name('recruitment.registration.store');

            Route::get('/form-business-opinion', [BusinessFeedBackController::class, 'businessOpinion'])->name('business.opinion'); //form ý kiến doanh nghiệp
            Route::post('/form-business-opinion', [BusinessFeedBackController::class, 'storeBusinessOpinion'])->name('business.opinion.store');

            Route::get('/business-survey', [BusinessSurveyController::class, 'businessSurvey'])->name('business.survey'); // khảo sát doanh nghiệp


            Route::post('/form-business', [BusinessController::class, 'store'])->name('business.store'); //form đăng ký doanh nghiệp
            Route::get('/form-business', [BusinessController::class, 'index'])->name('business.index');

            Route::get('/form-legal-advice', [LegalAdviceController::class, 'showFormLegal'])->name('show.form.legal'); //form tư vấn pháp lý
            Route::post('/form-legal-advice', [LegalAdviceController::class, 'storeForm'])->name('legal.advice.store');

            Route::get('/business-fair-registrations/{news_id}', [BusinessFairRegistrationController::class, 'businessFairRegistration'])->name('business-fair-registrations');
            Route::post('/business-fair-registrations', [BusinessFairRegistrationController::class, 'storeBusinessFairRegistration'])->name('business-fair-registrations.store');
            Route::get('/fair-registrations', [BusinessFairRegistrationController::class, 'businessFairRegistrations'])->name('business.fair.registrations');
        });
        Route::get('/form-start-promotion', [BusinessStartPromotionInvestmentController::class, 'showFormStartPromotion'])->name('show.form.start.promotion'); // khởi nghiệp xúc tiến thương mại đầu tư
        Route::post('/form-start-promotion', [BusinessStartPromotionInvestmentController::class, 'storeFormStartPromotion'])->name('form.start.promotion.store');


        //cho phường 17
        Route::get('/locations-17', [LocationController::class, 'clientIndex17'])->name('locations-17');

        Route::group(['prefix' => 'p17'], function () {
            Route::get('business-households', [BusinessHouseholdController::class, 'clientIndex'])->name('p17.households.client.index');
            Route::get('/business-household/{id}', [BusinessHouseholdController::class, 'clientShow'])->name('p17.households.client.show');
            Route::get('advertising', [AdvertisementController::class, 'advertising'])->name('p17.advertising.client.index');
            Route::get('advertising/{id}', [AdvertisementController::class, 'show'])->name('p17.advertising.client.show');
            Route::get('form-advertising', [AdvertisementController::class, 'formAdvertising'])->name('p17.advertising.client.form');
            Route::post('form-advertising', [AdvertisementController::class, 'storeFormAdvertising'])->name('p17.advertising.client.store');
            Route::get('register-exams', [OnlineXamsController::class, 'registerOnline'])->name('p17.online.xams.client.index');
            Route::get('list-quiz/{competitionId}', [OnlineXamsController::class, 'listQuizOnline'])->name('p17.list.quiz.client');
            Route::get('list-questions/{competitionId}', [OnlineXamsController::class, 'listQuestionsOnline'])->name('p17.list.questions.client');
            Route::get('list-competitions', [OnlineXamsController::class, 'listCompetitionsOnline'])->name('p17.list.competitions.exams.client');
            Route::post('list-competitions', [OnlineXamsController::class, 'submitCompetitionsOnline'])->name('p17.submit.competitions.exams.client');
            Route::get('start-online-exams/{quizId}', [OnlineXamsController::class, 'startOnlineExams'])->name('p17.start.online.exams.client');
            Route::post('submit-quiz/{quizId}', [OnlineXamsController::class, 'submitQuiz'])->name('p17.submit.quiz.client');
            Route::get('list-quiz-result/{quizId}', [OnlineXamsController::class, 'listQuizResult'])->name('p17.list.quiz.result.client');
            Route::get('generate-captcha', [CaptchaController::class, 'generateCaptcha'])->name('p17.generate.captcha');
            Route::post('forget-session', [OnlineXamsController::class, 'forgetSession'])->name('p17.forget.session');

            Route::get('list-surveys', [OnlineXamsController::class, 'listSurveys'])->name('p17.list.surveys.client');
            Route::post('submit-survey/{surveyId}', [OnlineXamsController::class, 'submitSurvey'])->name('p17.submit.survey.client');
            Route::get('start-survey/{surveyId}', [OnlineXamsController::class, 'startSurvey'])->name('p17.start.survey.client');
            Route::get('list-survey-result/{surveyId}', [OnlineXamsController::class, 'listSurveyResult'])->name('p17.list.survey.result.client');
            // Route::post('import', [BusinessHouseholdController::class, 'import'])->name('p17.households.import');
        });
    });

    Route::middleware(['auth'])->group(function () {
        Route::get('/logout', [AuthController::class, 'logout'])->name('admin.logout');

        Route::middleware(['role.admin'])->group(function () {
            Route::prefix('admin')->group(function () {
                Route::get('/', [AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');

                Route::resource('languages', LanguageController::class)->except(['show']);
                Route::get('languages/edit-system/{locale}', [LanguageController::class, 'editSystem'])->name('languages.edit-system');
                Route::put('languages/update-system/{locale}', [LanguageController::class, 'updateSystem'])->name('languages.update-system');

                Route::resource('tags-news', TagNewsController::class);
                Route::resource('categories-news', CategoryNewsController::class)->except('show');
                Route::resource('news', BlogsController::class);

                Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
                    Lfm::routes();

                    Route::post('/upload', [CustomUploadController::class, 'upload'])->name('lfm.upload');
                });

                Route::resource('tabs_posts', TabDetailPostController::class);
                Route::resource('news_contents', NewsTabContentDetailPostController::class);

                Route::post('/update-status', [StatusController::class, 'updateStatus'])->name('update.status');
                Route::post('/update-status-1', [StatusController::class, 'updateStatus1'])->name('update.status.1');
                Route::post('/update-status-2', [StatusController::class, 'updateStatus2'])->name('update.status.2');


                Route::resource('users', UserController::class)->except('show');

                Route::post('/user/status', [UserController::class, 'changeStatus'])->name('user.changeStatus');

                Route::get('locations', [LocationController::class, 'index'])->name('locations.index');
                Route::delete('locations/destroy/{id}', [LocationController::class, 'destroy'])->name('locations.destroy');
                Route::get('locations/detail/{id}', [LocationController::class, 'show'])->name('locations.show');

                Route::resource('digital-transformations', DigitalTransformationController::class)->except('show');

                Route::post('/news/toggle-digital-transformation', [BlogsController::class, 'toggleDigitalTransformation'])->name('news.toggleDigitalTransformation');

                Route::middleware(['role.admin.qgv'])->group(function () {
                    Route::resource('bank-servicers', BankServicerController::class);

                    Route::resource('personal-business-interests', PersonalBusinessInterestController::class);

                    Route::resource('financial-support', FinancialSupportController::class);

                    Route::resource('banks', BanksController::class);

                    Route::resource('businesses', BusinessController::class)->except('create', 'store', 'edit', 'update');

                    Route::resource('start-promotion-investment', BusinessStartPromotionInvestmentController::class);

                    Route::resource('capital-needs', BusinessCapitalNeedController::class);
                    Route::post('/send-email', [BusinessCapitalNeedController::class, 'sendEmailToBank'])->name('capital-needs.send-email');


                    Route::resource('job-applications', JobApplicationController::class)->except('create', 'store', 'edit', 'update');

                    Route::resource('feedback', BusinessFeedBackController::class)->except('create', 'store', 'edit', 'update');

                    Route::resource('survey', BusinessSurveyController::class)->except('show');

                    Route::resource('recruitment',  BusinessRecruitmentController::class)->except('create', 'store', 'edit', 'update', 'show');

                    Route::get('/form-business', [BusinessController::class, 'adminIndex'])->name('admin.business');

                    Route::resource('members',  MemberBusinessController::class)->except('create', 'store', 'edit', 'update');
                    Route::post('/import-business', [MemberBusinessController::class, 'import'])->name('import.business');

                    Route::resource('business-fields',  BusinessFieldController::class);

                    Route::resource('contact-consultations',  ContactConsultationController::class);

                    Route::resource('form-legal-advice',  LegalAdviceController::class)->except('create', 'store', 'edit', 'update');

                    Route::resource('fair-registrations', BusinessFairRegistrationController::class)->except('show');
                    Route::get('/fair-registrations/join', [BusinessFairRegistrationController::class, 'indexJoin'])->name('business-fair-registrations.indexJoin');
                    Route::get('/fair-registrations/join/{id}', [BusinessFairRegistrationController::class, 'showIndexJoin'])->name('business-fair-registrations.showIndexJoin');
                    Route::delete('/fair-registrations/destroy/{id}', [BusinessFairRegistrationController::class, 'destroyindexJoin'])->name('business-fair-registrations.destroyindexJoin');
                    Route::get('business-products', [ProductBusinessController::class, 'index'])->name('business.products.index');
                    Route::get('business-products/detail/{id}', [ProductBusinessController::class, 'show'])->name('business.products.show');
                    Route::delete('business-products/destroy/{id}', [ProductBusinessController::class, 'destroy'])->name('business.products.destroy');

                    Route::resource('emails', EmailController::class);

                    Route::resource('email_templates', EmailTemplatesController::class);
                });

                Route::middleware(['role.admin.p17'])->group(function () {

                    Route::resource('ad-types', AdTypeController::class)->except('show');
                    Route::resource('ad-categories', AdCategoryController::class)->except('show');
                    Route::resource('advertisements', AdvertisementController::class);

                  Route::get('/{type?}', [CompetitionController::class, 'index'])->name('competitions.index');
                  Route::get('/{type?}/create', [CompetitionController::class, 'create'])->name('competitions.create');
                  Route::post('/{type?}/store', [CompetitionController::class, 'store'])->name('competitions.store');
                  Route::get('/{type?}/{id}/edit', [CompetitionController::class, 'edit'])->name('competitions.edit');
                  Route::put('/{type?}/{id}', [CompetitionController::class, 'update'])->name('competitions.update');
                  Route::delete('/{type?}/{id}', [CompetitionController::class, 'destroy'])->name('competitions.destroy');
                  Route::get('/{type?}/{competitionId}/quizzes', [QuizController::class, 'index'])->name('quizzes.index');
                  Route::get('/{type?}/{competitionId}/quizzes/create', [QuizController::class, 'create'])->name('quizzes.create');
                  Route::post('/{type?}/{competitionId}/quizzes', [QuizController::class, 'store'])->name('quizzes.store');
                  Route::get('/{type?}/quizzes/{id}/edit', [QuizController::class, 'edit'])->name('quizzes.edit');
                  Route::put('/{type?}/quizzes/{id}', [QuizController::class, 'update'])->name('quizzes.update');
                  Route::delete('/{type?}/quizzes/{id}', [QuizController::class, 'destroy'])->name('quizzes.destroy');

                  Route::get('/{type?}/quizzes/{quizId}/questions', [QuestionController::class, 'index'])->name('questions.index');
                  Route::get('/{type?}/quizzes/{quizId}/questions/create', [QuestionController::class, 'create'])->name('questions.create');
                  Route::post('/{type?}/quizzes/{quizId}/questions', [QuestionController::class, 'store'])->name('questions.store');
                  Route::get('/{type?}/questions/{id}/edit', [QuestionController::class, 'edit'])->name('questions.edit');
                  Route::put('/{type?}/questions/{id}', [QuestionController::class, 'update'])->name('questions.update');
                  Route::delete('/{type?}/questions/{id}', [QuestionController::class, 'destroy'])->name('questions.destroy');
                  Route::post('{type?}/import', [CompetitionController::class, 'import'])->name('competitions.import');

                    Route::resource('departments', DepartmentController::class)->except('show');

                    Route::get('work-schedules', [CitizenMeetingScheduleController::class, 'index'])->name('work-schedules.index');
                    Route::get('work-schedules/{id}', [CitizenMeetingScheduleController::class, 'show'])->name('work-schedules.show');
                    Route::post('/work-schedules/{id}/update-status', [CitizenMeetingScheduleController::class, 'update'])->name('work-schedules.update');

                    Route::get('feedbacks', [FeedbackController::class, 'index'])->name('feedbacks.index');
                    Route::get('satisfaction-survey' , [SatisfactionSurveyController::class, 'index'])->name('satisfaction-survey.index');
                });
            });
        });

        Route::middleware(['role.business'])->group(function () {
            Route::middleware(['check.active'])->group(function () {
                Route::prefix('business')->group(function () {
                    Route::get('/', [BusinessDashboardController::class, 'index'])->name('business.dashboard');

                    Route::put('update-business', [BusinessDashboardController::class, 'updateBusiness'])->name('update.business');

                    Route::put('update-business-member', [BusinessDashboardController::class, 'updateBusinessMember'])->name('update.business.member');

                    Route::put('update-representative-info', [BusinessDashboardController::class, 'updateRepresentativeInfo'])->name('update.representative.info');

                    Route::put('update-account-info', [BusinessDashboardController::class, 'updateAccountInfo'])->name('update.account.info');
                });
            });
        });
    });

    Route::middleware(['guest'])->group(function () {
        Route::get('/login', function () {
            return view('admin.pages.auth.login');
        })->name('admin.login');

        Route::post('/login', [AuthController::class, 'login'])->name('admin.login');
    });
});
