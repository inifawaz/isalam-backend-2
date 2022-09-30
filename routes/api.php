<?php

use App\Http\Controllers\AdminArticleController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminInformationController;
use App\Http\Controllers\AdminProjectController;
use App\Http\Controllers\AdminReportController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\MeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TopicController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/test', TestController::class);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/projects', [ProjectController::class, 'index']);
Route::get('/projects/{project}', [ProjectController::class, 'show']);

Route::get('/articles', [ArticleController::class, 'index']);
Route::get('/articles/{article}', [ArticleController::class, 'show']);
Route::get('/topics', [TopicController::class, 'index']);

// Callback
Route::post('/paymentcallback', [PaymentController::class, 'callback']);


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/logout', [AuthController::class, 'logout']);

    Route::post('/getpaymentmethods', [PaymentController::class, 'getPaymentMethods']);
    Route::post('/payments', [PaymentController::class, 'store']);
    Route::get('/payments', [PaymentController::class, 'getMyPayments']);
    Route::get('/payments/{payment}', [PaymentController::class, 'getPaymentDetails']);

    // Me
    Route::get('/me', [AuthController::class, 'me']);
    Route::put('/me', [AuthController::class, 'update']);
    Route::get('/me/dashboard', [MeController::class, 'getMyDashboardData']);
    Route::get('/me/payments/{id}', [MeController::class, 'getMyPaymentDetails']);
});

Route::group(['middleware' => ['auth:sanctum', "role:admin"]], function () {


    // Project
    Route::get('/admin/projects', [AdminProjectController::class, 'index']);
    Route::get('/admin/projects/{project}', [AdminProjectController::class, 'show']);
    Route::post('/admin/projects', [ProjectController::class, 'store']);
    Route::post('/assets/img/projects/content', [AssetController::class, 'uploadImageProjectContent']);
    Route::put('/admin/projects/{project}', [ProjectController::class, 'update']);

    // Category
    Route::get('/admin/categories', [CategoryController::class, 'index']);
    Route::post('/admin/categories', [CategoryController::class, 'store']);
    Route::put('/admin/categories/{category}', [CategoryController::class, 'update']);
    Route::delete('/admin/categories/{category}', [CategoryController::class, 'destroy']);

    // Topic
    Route::get('/admin/topics', [TopicController::class, 'index']);
    Route::post('/admin/topics', [TopicController::class, 'store']);
    Route::put('/admin/topics/{topic}', [TopicController::class, 'update']);
    Route::delete('/admin/topics/{topic}', [TopicController::class, 'destroy']);

    // Information
    Route::put('/admin/information/{information}', [InformationController::class, 'update']);
    Route::delete('/admin/information/{information}', [InformationController::class, 'destroy']);
    Route::post('/admin/information', [InformationController::class, 'store']);

    // Report
    Route::post('/admin/reports', [AdminReportController::class, 'store']);
    Route::delete('/admin/reports/{report}', [AdminReportController::class, 'destroy']);
    Route::put('/admin/reports/{report}', [AdminReportController::class, 'update']);

    // Article
    Route::get('/admin/articles', [AdminArticleController::class, 'index']);
    Route::get('/admin/articles/{article}', [AdminArticleController::class, 'show']);
    Route::put('/admin/articles/{article}', [AdminArticleController::class, 'update']);
    Route::delete('/admin/articles/{article}', [AdminArticleController::class, 'destroy']);
    Route::post('/admin/articles', [AdminArticleController::class, 'store']);

    // User
    Route::get('/admin/users', [AdminUserController::class, 'index']);

    // User
    Route::post('/admin', [AuthController::class, 'registerAdmin']);
    Route::delete('/admin/users/{user}', [AuthController::class, 'destroyUser']);

    // Dashboad Admin Data
    Route::get('/admin/dashboard', AdminDashboardController::class);

    // Topic
    Route::get('/admin/topics', [TopicController::class, 'index']);
});
