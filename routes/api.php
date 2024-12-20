<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\FeedbackController;
use App\Http\Controllers\API\ZaloAuthController;
use App\Http\Controllers\API\DepartmentController;
use App\Http\Controllers\API\DigitalTransformationController;
use App\Http\Controllers\API\CitizenMeetingScheduleController;
use App\Http\Controllers\API\SatisfactionSurveyController;
use App\Http\Controllers\API\TopQuestionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::group(['prefix' => 'client'], function () {
    Route::middleware(['zalo.auth'])->group(function () {
        Route::group(['prefix' => 'p17'], function () {
            Route::get('auth/zalo', [ZaloAuthController::class, 'redirectToZalo']);
            Route::post('citizen-meeting-schedules', [CitizenMeetingScheduleController::class, 'store']); // tạo đặt lịch tiếp dân
            Route::get('citizen-meeting-schedules', [CitizenMeetingScheduleController::class, 'index']); //lịch sử đặt lịch tiếp dân user hiện tại
        
            Route::post('feedbacks', [FeedbackController::class, 'sendFeedback']); // tạo góp ý - phản ảnh
            Route::get('feedbacks', [FeedbackController::class, 'index']); // lịch sử góp ý - phản ảnh user hiện tại

            Route::post('satisfaction-survey', [SatisfactionSurveyController::class, 'store']); // tạo khảo sát hài lòng
        
            Route::post('top-questions', [TopQuestionController::class, 'store']); // send câu hỏi client
        });
    });

    Route::group(['prefix' => 'p17'], function () {
        Route::get('digital-transformations', [DigitalTransformationController::class, 'index']); // get chuyển đổi số P17
        Route::get('departments', [DepartmentController::class, 'index']); // get danh sách phòng ban
        Route::get('top-questions', [TopQuestionController::class, 'topQuestions']); // get câu hỏi thường gặp client
    });

    Route::group(['prefix' => 'qgv'], function () {
        Route::get('digital-transformations', [DigitalTransformationController::class, 'indexQGV']); // get chuyển đổi số P17
    });
});
