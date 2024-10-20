<?php

use App\Http\Controllers\BankServicerController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\CategoryQuestionController;
use App\Http\Controllers\NewsTabContentDetailPostController;
use App\Http\Controllers\PaperController;
use App\Http\Controllers\PersonalBusinessInterestController;
use App\Http\Controllers\TabDetailPostController;
use App\Models\Tab;
use App\Models\SlideProgram;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\TabsForParentsController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AdminQuestionController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\TagNewsController;
use App\Http\Controllers\TabsController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\BannersController;
use App\Http\Controllers\TuitionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\EvironmentController;
use App\Http\Controllers\TabsCustomController;
use App\Http\Controllers\SlideProgramController;
use App\Http\Controllers\TabAdmissionController;
use App\Http\Controllers\TestimonialsController;
use App\Http\Controllers\DetailContentController;
use App\Http\Controllers\ProgramOverviewController;
use App\Http\Controllers\AdmissionProcessController;
use App\Http\Controllers\AdmissionProcessDetailController;
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\CategoryNewsController;
use App\Http\Controllers\CustomerInterestController;
use App\Http\Controllers\FinancialSupportController;
use App\Http\Controllers\ParentsChildController;

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

    Route::group(['prefix' => 'client'], function(){
        Route::get('business', [BusinessController::class,'business'])->name('business');
        Route::get('business/{business_code}', [BusinessController::class,'businessDetail'])->name('business.detail');
        Route::get('product/{slug}', [BusinessController::class,'productDetail'])->name('product.detail');
        //Route::get('/form-business', [BusinessController::class, 'create'])->name('business.create');
        Route::post('/form-business', [BusinessController::class, 'store'])->name('business.store');
        Route::get('/form-business', [BusinessController::class, 'index'])->name('business.index');
        Route::get('/form-customer/{financialSupportId}', [CustomerInterestController::class, 'showForm'])->name('show.form');
        Route::post('/form-customer', [CustomerInterestController::class, 'storeForm'])->name('store.form');
        Route::get('/home-business', [FinancialSupportController::class, 'showFinancial'])->name('show.financical');
        Route::get('/post-detail/{slug}', [BlogsController::class, 'showPostIndex'])->name('post-detail');
    });

    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/admission/{slug}', [AdmissionController::class, 'tabAdmission'])->name('tab.admission');
    Route::get('/parents/{slug}', [TabsForParentsController::class, 'tabForParent'])->name('tab.parent');

    Route::get('/detail-parent/{slug}', [TabsForParentsController::class, 'showForParent'])->name('detail.parent');

    Route::get('/projects/{id}', [TabsController::class, 'showDetailTab'])->name('detail-dev-mini');
    Route::get('/env/{slug}', [EvironmentController::class, 'tabEnvironment'])->name('tab.environment');
    Route::get('/env/detail/{id}', [EvironmentController::class, 'showDetailTab'])->name('tab.environment.show.detail');

    Route::get('/detail-album/{id}', [TabsForParentsController::class, 'showDetailAlbum'])->name('detail.album');


    Route::get('/learn-env', function () {
        return view('pages.learn-env');
    })->name('learn-env');

    Route::get('/detail-program/{id}', [DetailContentController::class, 'pageDetailProgram'])->name('detail-program');

    Route::get('/program/{slug}', [ProgramOverviewController::class, 'pagePrograms'])->name('programms');

    Route::get('switch-language/{locale}', [LanguageController::class, 'switchLanguage'])->name('language.switch');

    Route::post('send-admission', [AdmissionController::class, 'sendAdmission'])->name('send-admission');

    Route::get('/advisory-board', [QuestionController::class, 'index'])->name('advisory-board');
    Route::post('/questions/{id}/increment-view', [QuestionController::class, 'incrementView'])->name('questions.incrementView');
    Route::post('/questions', [QuestionController::class, 'store'])->name('questions.store');


    Route::get('/b/{slug}', [BlogsController::class, 'blogIndex'])->name('list-blogs');
    Route::get('/detail-blog/{slug}', [BlogsController::class, 'showBlogIndex'])->name('detail-blog');

    Route::get('/detail-blog/mini/{slug}', [BlogsController::class, 'showBlogIndexMini'])->name('detail-blog-mini');

    Route::get('aboutUs/{slug}', [AboutUsController::class, 'pageAboutUsDetail'])->name('page.aboutUs.detail');




    Route::get('page-tab/{slug}', function ($slug) {
        return view('pages.tab-custom.index', compact('slug'));
    })->name('page.tab');

    Route::get('select-campus', function () {
        return abort(404);
    })->name('select-campus');
    Route::post('select-campus', [BranchController::class, 'selectCampus'])->name('select-campus');

    Route::middleware(['auth'])->group(function () {

        Route::middleware(['role.admin'])->group(function(){
            Route::prefix('admin')->group(function () {
                Route::get('/', function () {
                    return view('admin.pages.dashboard');
                })->name('admin.dashboard');

                Route::get('/logout', [AuthController::class, 'logout'])->name('admin.logout');

                Route::resource('languages', LanguageController::class)->except(['show']);
                Route::get('languages/edit-system/{locale}', [LanguageController::class, 'editSystem'])->name('languages.edit-system');
                Route::put('languages/update-system/{locale}', [LanguageController::class, 'updateSystem'])->name('languages.update-system');

                Route::resource('banners', BannersController::class);

                Route::resource('sliders', SliderController::class);

                Route::resource('aboutUs', AboutUsController::class);

                Route::resource('categories', CategoryController::class)->except('destroy', 'create', 'store', 'show');

                Route::resource('programs', ProgramOverviewController::class);

                Route::resource('slide_program', SlideProgramController::class)->except('index', 'create', 'edit');

                Route::resource('detail_contents', DetailContentController::class)->except('index', 'create', 'edit');

                Route::resource('testimonials', TestimonialsController::class);

                Route::get('admissions', [AdmissionController::class, 'index'])->name('admissions.index');
                Route::post('admissions/approve/{id}', [AdmissionController::class, 'approve'])->name('admissions.approve');
                Route::post('admissions/reject/{id}', [AdmissionController::class, 'reject'])->name('admissions.reject');

                Route::resource('tuitions', TuitionController::class);

                Route::get('content-tuitions/create/{tuition}', [TuitionController::class, 'createContent'])->name('content-tuitions.create');
                Route::post('content-tuitions/store/{tuition}', [TuitionController::class, 'storeContent'])->name('content-tuitions.store');
                Route::get('content-tuitions/edit/{content}', [TuitionController::class, 'editContent'])->name('content-tuitions.edit');
                Route::put('content-tuitions/update/{content}', [TuitionController::class, 'updateContent'])->name('content-tuitions.update');
                Route::delete('content-tuitions/destroy/{content}', [TuitionController::class, 'destroyContent'])->name('content-tuitions.destroy');

                Route::get('overviewprograms/{category_id}', [ProgramOverviewController::class, 'index'])->name('overviewprograms.index');

                Route::get('detail_program/{program_id}', [DetailContentController::class, 'index'])->name('detail_contents.index');

                Route::get('slider_programms/{program_id}', [SlideProgramController::class, 'index'])->name('slider_programms.index');

                Route::get('slide_programs/{program_id}/create', [SlideProgramController::class, 'create'])->name('slide_programs.create');

                Route::get('slider_prog/{id}/edit', [SlideProgramController::class, 'edit'])->name('slider_prog.edit');

                Route::get('detail_content/{program_id}/create', [DetailContentController::class, 'create'])->name('detail_content.create');


                Route::get('details_content/{id}/edit', [DetailContentController::class, 'edit'])->name('details_content.edit');

                Route::resource('tabs-admissions', TabAdmissionController::class)->except('create', 'store', 'edit', 'update', 'destroy');
                Route::get('tabs-programs/{id}/component1', [TabsController::class, 'showComponent1'])->name('tabs-programs.component1');
                Route::get('tabs-programs/component1/edit/{id}', [TabsController::class, 'editComponent1'])->name('tabs-programs.component1.edit');
                Route::put('tabs-programs/component1/update/{id}', [TabsController::class, 'updateComponent1'])->name('tabs-programs.component1.update');
                Route::get('tabs-programs/component2/edit/{id}', [TabsController::class, 'editComponent2'])->name('tabs-programs.component2.edit');
                Route::put('tabs-programs/component2/update/{id}', [TabsController::class, 'updateComponent2'])->name('tabs-programs.component2.update');
                Route::get('tabs-programs/{id}/component2/create', [TabsController::class, 'createComponent2'])->name('tabs-programs.component2.create');
                Route::post('tabs-programs/{id}/component2', [TabsController::class, 'storeComponent2'])->name('tabs-programs.component2.store');
                Route::delete('tabs-programs/{tab_id}/component2/{id}', [TabsController::class, 'destroyComponent2'])->name('tabs-programs.component2.destroy');


                Route::get('tabs-programs/{id}/component1pp', [TabsController::class, 'showComponent1PP'])->name('tabs-programs.component1pp');
                Route::get('tabs-programs/{id}/component2pp', [TabsController::class, 'showComponent2PP'])->name('tabs-programs.component2pp');
                Route::get('tabs-programs/{id}/component3pp', [TabsController::class, 'showComponent3PP'])->name('tabs-programs.component3pp');
                Route::post('tabs-programs/component1pp/store/{id}', [TabsController::class, 'storeContentComponent1PP'])->name('tabs-programs.component1pp.store');
                Route::get('tabs-programs/component1pp/create/{id}', [TabsController::class, 'createContentComponent1PP'])->name('tabs-programs.component1pp.create');
                Route::get('tabs-programs/component1pp/edit/{id}', [TabsController::class, 'editContentComponent1PP'])->name('tabs-programs.component1pp.edit');
                Route::put('tabs-programs/component1pp/update/{id}', [TabsController::class, 'updateContentComponent1PP'])->name('tabs-programs.component1pp.update');
                Route::delete('tabs-programs/component1pp/destroy/{tab_id}/{id}', [TabsController::class, 'destroyContentComponent1PP'])->name('tabs-programs.component1pp.destroy');

                Route::get('tabs-programs/{id}/component2pp/create', [TabsController::class, 'createComponent2PP'])->name('tabs-programs.component2pp.create');
                Route::post('tabs-programs/{id}/component2pp', [TabsController::class, 'storeComponent2PP'])->name('tabs-programs.component2pp.store');
                Route::get('tabs-programs/component2pp/edit/{id}', [TabsController::class, 'editComponent2PP'])->name('tabs-programs.component2pp.edit');
                Route::put('tabs-programs/component2pp/update/{id}', [TabsController::class, 'updateComponent2PP'])->name('tabs-programs.component2pp.update');
                Route::delete('tabs-programs/{tab_id}/component2pp/{id}', [TabsController::class, 'destroyComponent2PP'])->name('tabs-programs.component2pp.destroy');



                Route::get('tabs-programs/{id}/component3pp/create', [TabsController::class, 'createComponent3PP'])->name('tabs-programs.component3pp.create');
                Route::post('tabs-programs/{id}/component3pp', [TabsController::class, 'storeComponent3PP'])->name('tabs-programs.component3pp.store');
                Route::get('tabs-programs/component3pp/edit/{id}', [TabsController::class, 'editComponent3PP'])->name('tabs-programs.component3pp.edit');
                Route::put('tabs-programs/component3pp/update/{id}', [TabsController::class, 'updateComponent3PP'])->name('tabs-programs.component3pp.update');
                Route::delete('tabs-programs/{tab_id}/component3pp/{id}', [TabsController::class, 'destroyComponent3PP'])->name('tabs-programs.component3pp.destroy');



                Route::get('tabs-programs/component3pp/detail/{id}', [TabsController::class, 'showComponent3PPDetail'])->name('tabs-programs.component3pp.show.detail');
                Route::get('tabs-programs/component3pp/{id}/detail/create', [TabsController::class, 'createComponent3PPDetail'])->name('tabs-programs.component3pp.create.detail');
                Route::post('tabs-programs/component3pp/{id}/detail/store', [TabsController::class, 'storeComponent3PPDetail'])->name('tabs-programs.component3pp.store.detail');
                Route::get('tabs-programs/component3pp/{tab_id}/detail/{detail_id}/edit', [TabsController::class, 'editComponent3PPDetail'])->name('tabs-programs.component3pp.edit.detail');
                Route::post('tabs-programs/component3pp/{tab_id}/detail/{detail_id}/update', [TabsController::class, 'updateComponent3PPDetail'])->name('tabs-programs.component3pp.update.detail');
                Route::delete('tabs-programs/component3pp/{tab_id}/details/{detail_id}/destroy', [TabsController::class, 'destroyComponent3PPDetail'])->name('tabs-programs.component3pp.destroy.detail');

                Route::get('tabs-programs/{id}/component2', [TabsController::class, 'showComponent2'])->name('tabs-programs.component2');

                Route::resource('tabs-programs', TabsController::class)->except('create', 'store', 'edit', 'update', 'destroy');

                Route::get('show-page', [TabsController::class, 'showPageAll'])->name('show.page.all');
                Route::get('show-page/{id}/edit', [TabsController::class, 'showPageEdit'])->name('show.page.edit');
                Route::put('show-page/{id}/update', [TabsController::class, 'showPageUpdate'])->name('show.page.update');


                Route::get('an_questions', [AdminQuestionController::class, 'adminIndex'])->name('admin.questions.index');
                Route::post('an_questions', [AdminQuestionController::class, 'storeAnswer'])->name('admin.answers.store');
                Route::put('an_questions', [AdminQuestionController::class, 'updateAnswer'])->name('admin.answers.update');
                Route::delete('an_questions/{id}', [AdminQuestionController::class, 'destroyQuestion'])->name('admin.questions.destroy');


                Route::resource('forums', ForumController::class);


                Route::resource('tabs-parents', TabsForParentsController::class);
                Route::post('content_parent/store/{tab_id}', [TabsForParentsController::class, 'storeContent'])->name('content_tab_parent.store');
                Route::get('content_parent/create/{tab_id}', [TabsForParentsController::class, 'createContent'])->name('content_tab_parent.create');
                Route::get('content_parent/edit/{id}', [TabsForParentsController::class, 'editContent'])->name('content_tab_parent.edit');
                Route::put('content_parent/update/{id}', [TabsForParentsController::class, 'updateContent'])->name('content_tab_parent.update');


                Route::resource('parents-child', ParentsChildController::class);
                Route::get('parents-children/{id}', [ParentsChildController::class, 'indexParents'])->name('parents-children.index');
                Route::get('parents-children/create/{tab_id}', [ParentsChildController::class, 'createContent'])->name('parents-children.create');
                Route::post('parents-children/store/{tab_id}', [ParentsChildController::class, 'storeContent'])->name('parents-children.store');
                Route::get('parents-children/edit/{id}', [ParentsChildController::class, 'editContent'])->name('parents-children.edit');
                Route::put('parents-children/update/{id}', [ParentsChildController::class, 'updateContent'])->name('parents-children.update');

                Route::resource('papers', PaperController::class);

                Route::get('parents-children/ParentChildDetail/detail/{id}', [ParentsChildController::class, 'showParentChildDetail'])->name('ParentChildDetail.index.detail');
                Route::get('parents-children/ParentChildDetail/{id}/detail/create', [ParentsChildController::class, 'createParentChildDetail'])->name('ParentChildDetail.create.detail');
                Route::post('parents-children/ParentChildDetail/{id}/detail/store', [ParentsChildController::class, 'storeParentChildDetail'])->name('ParentChildDetail.store.detail');
                Route::get('parents-children/ParentChildDetail/{tab_id}/detail/{detail_id}/edit', [ParentsChildController::class, 'editParentChildDetail'])->name('ParentChildDetail.edit.detail');
                Route::post('parents-children/ParentChildDetail/{tab_id}/detail/{detail_id}/update', [ParentsChildController::class, 'updateParentChildDetail'])->name('ParentChildDetail.update.detail');
                Route::delete('parents-children/ParentChildDetail/{tab_id}/details/{detail_id}/destroy', [ParentsChildController::class, 'destroyParentChildDetail'])->name('ParentChildDetail.destroy.detail');


                Route::resource('tabs-environment', EvironmentController::class);
                Route::get('show-environment/{id}', [EvironmentController::class, 'show_content'])->name('show_content');
                Route::get('tabs-environment/edit/{id}', [EvironmentController::class, 'editContent'])->name('tabs-environment.section.edit');
                Route::put('tabs-environment/update/{id}', [EvironmentController::class, 'updateContent'])->name('tabs-environment.section.update');
                Route::post('tabs-environment/store/{id}', [EvironmentController::class, 'storeContent'])->name('tabs-environment.section.store');
                Route::get('tabs-environment/create/{id}', [EvironmentController::class, 'createContent'])->name('tabs-environment.section.create');
                Route::delete('tabs-environment/destroy/{tab_id}/{id}', [EvironmentController::class, 'destroyContent'])->name('tabs-environment.section.destroy');
                Route::get('show-detail/{id}', [EvironmentController::class, 'show_content_detail'])->name('tabs-environment.section.show.detail');

                Route::get('tabs-environment/section/{id}/details/create', [EvironmentController::class, 'createDetail'])->name('tabs-environment.section.create.detail');
                Route::post('tabs-environment/section/{id}/details/store', [EvironmentController::class, 'storeDetail'])->name('tabs-environment.section.store.detail');
                Route::get('tabs-environment/section/{tab_id}/details/{detail_id}/edit', [EvironmentController::class, 'editDetail'])->name('tabs-environment.section.edit.detail');
                Route::post('tabs-environment/section/{tab_id}/details/{detail_id}/update', [EvironmentController::class, 'updateDetail'])->name('tabs-environment.section.update.detail');
                Route::delete('tabs-environment/section/{tab_id}/details/{detail_id}/destroy', [EvironmentController::class, 'destroyDetail'])->name('tabs-environment.section.destroy.detail');


                Route::resource('admission-process', AdmissionProcessController::class)->except('index', 'create');
                Route::get('admission-process/create/{tab_id}', [AdmissionProcessController::class, 'create'])->name('admission-process.create');

                Route::resource('admission-process-detail', AdmissionProcessDetailController::class)->except('index', 'create', 'store', 'show');
                Route::get('admission-process-detail/create/{process_id}', [AdmissionProcessDetailController::class, 'create'])->name('admission-process-detail.create');
                Route::post('admission-process-detail/store/{process_id}', [AdmissionProcessDetailController::class, 'store'])->name('admission-process-detail.store');

                Route::put('update-process/{tab_img_content_id}', [AdmissionProcessController::class, 'updateProcess'])->name('update-process');


                Route::put('content_tab/update/{tab_img_content_id}', [TabAdmissionController::class, 'updateContentTab'])->name('content_tab.update');

                Route::get('tab-about-us', [AboutUsController::class, 'tabIndex'])->name('tab.aboutUs');
                Route::get('tab-about-us/edit/{id_content}', [AboutUsController::class, 'tabEdit'])->name('tab.aboutUs.edit');
                Route::put('tab-about-us/update/{tab_img_content_id}', [AboutUsController::class, 'tabUpdate'])->name('tab.aboutUs.update');
                Route::get('all-data-component/{slug}', [AboutUsController::class, 'allDataComponent'])->name('all.data.component');
                Route::get('all-data-component-collapse/{slug}', [AboutUsController::class, 'allDataComponentCollapse'])->name('all.data.component.collapse');
                Route::get('collapse/create/{tab_id}', [AboutUsController::class, 'createCollapse'])->name('create.collapse');
                Route::post('collapse/store/{tab_id}', [AboutUsController::class, 'storeCollapse'])->name('store.collapse');
                Route::get('collapse/edit/{id}', [AboutUsController::class, 'editCollapse'])->name('edit.collapse');
                Route::put('collapse/update/{id}', [AboutUsController::class, 'updateCollapse'])->name('update.collapse');
                Route::delete('collapse/destroy/{id}', [AboutUsController::class, 'destroyCollapse'])->name('destroy.collapse');

                Route::get('tab-about-us-message', [AboutUsController::class, 'tabIndexMessage'])->name('tab.aboutUs.message');
                Route::get('tab-custom-about-us', [AboutUsController::class, 'tabAboutUs'])->name('tab.aboutUs.custom');

                Route::get('edit/tab-custom/{slug}', [TabsCustomController::class, 'edit'])->name('edit.tab');
                Route::put('update/tab-custom/{slug}', [TabsCustomController::class, 'update'])->name('update.tab');

                Route::get('create/tab-custom/{key_page}', [TabsCustomController::class, 'create'])->name('create.tab');
                Route::post('store/tab-custom/{key_page}', [TabsCustomController::class, 'store'])->name('store.tab');

                Route::delete('destroy/tab-custom/{id}', [TabsCustomController::class, 'destroy'])->name('destroy.tab');

                Route::get('content_one_tab/custom/{slug}', [TabsCustomController::class, 'createContent1Tab'])->name('content_one_tab.create');
                Route::post('content_one_tab/store/{slug}', [TabsCustomController::class, 'storeContent1Tab'])->name('content_one_tab.store');
                Route::put('content_one_tab/update/{id}', [TabsCustomController::class, 'updateContent1Tab'])->name('content_one_tab.update');

                Route::get('content_tab_custom/{slug}', [TabsCustomController::class, 'show'])->name('content_tab_custom');
                Route::get('content_two_tab/create/{slug}', [TabsCustomController::class, 'createContent2Tab'])->name('content_two_tab.create');
                Route::post('content_two_tab/store/{slug}', [TabsCustomController::class, 'storeContent2Tab'])->name('content_two_tab.store');
                Route::get('content_two_tab/edit/{id}', [TabsCustomController::class, 'editContent2Tab'])->name('content_two_tab.edit');
                Route::put('content_two_tab/update/{id}', [TabsCustomController::class, 'updateContent2Tab'])->name('content_two_tab.update');
                Route::delete('content_two_tab/destroy/{id}', [TabsCustomController::class, 'destroyContent2Tab'])->name('content_two_tab.destroy');

                Route::get('all-content/{slug}', [TabsCustomController::class, 'allContent'])->name('all.content');

                Route::resource('campuses', BranchController::class);
                Route::resource('staffs', StaffController::class)->except('index', 'show', 'create', 'store');
                Route::get('staffs/create/{branch_id}', [StaffController::class, 'create'])->name('staffs.create');
                Route::post('staffs/store/{branch_id}', [StaffController::class, 'store'])->name('staffs.store');


                Route::resource('tags-news', TagNewsController::class);
                Route::resource('categories-news', CategoryNewsController::class);
                Route::resource('news', BlogsController::class);

                Route::group(['prefix' => 'laravel-filemanager'], function () {
                    \UniSharp\LaravelFilemanager\Lfm::routes();
                });

                Route::resource('categories-questions', CategoryQuestionController::class);

                Route::resource('tabs_posts', TabDetailPostController::class);
                Route::resource('news_contents', NewsTabContentDetailPostController::class);

                Route::resource('bank-servicers', BankServicerController::class);

                Route::resource('personal-business-interests', PersonalBusinessInterestController::class);
            });
        });

        Route::middleware(['role.business'])->group(function () {

        });
    });

    Route::middleware(['guest'])->group(function () {
        Route::get('/login', function () {
            return view('admin.pages.auth.login');
        })->name('admin.login');

        Route::post('/login', [AuthController::class, 'login'])->name('admin.login');
    });
});

