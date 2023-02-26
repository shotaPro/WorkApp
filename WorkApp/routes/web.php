<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailNotify;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

/////////////////////////////////
///管理者
/////////////////////////////////
Route::get('/category_register_page', [AdminController::class, 'category_register_page']);
Route::post('/register_category', [AdminController::class, 'register_category']);
Route::post('/register_subcategory', [AdminController::class, 'register_subcategory']);


/////////////////////////////////
///ユーザー
/////////////////////////////////
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/user_profile_page', [HomeController::class, 'user_profile_page']);
Route::get('/user_profile_register_page', [HomeController::class, 'user_profile_register_page']);
Route::post('/user_profile_register', [HomeController::class, 'user_profile_register']);
Route::get('/user_profile_edit_page/{id}', [HomeController::class, 'user_profile_edit_page']);
Route::post('/user_profile_edit/{id}', [HomeController::class, 'user_profile_edit']);
Route::get('/order_work_page', [HomeController::class, 'order_work_page']);
Route::get('/select_order_work_category/{id}', [HomeController::class, 'select_order_work_category']);
Route::post('/order_work_registration', [HomeController::class, 'order_work_registration']);
Route::get('/recruit_work_page', [HomeController::class, 'recruit_work_page']);
Route::get('/worker_list_page', [HomeController::class, 'worker_list_page']);
Route::get('/user_order_consult_page/{id}', [HomeController::class, 'user_order_consult_page']);
Route::get('/select_order_consult_work_category/{id}', [HomeController::class, 'select_order_consult_work_category']);
Route::post('/send_order_consult_work_message/{id}', [HomeController::class, 'send_order_consult_work_message']);
Route::get('/email-template', [HomeController::class, 'email-template']);
Route::get('/message_list_page', [HomeController::class, 'message_list_page']);
Route::get('/detail_consult_message/{id}', [HomeController::class, 'detail_consult_message']);
Route::post('/reply_consult_message/{id}', [HomeController::class, 'reply_consult_message']);
Route::get('/work_detail_info_page/{id}', [HomeController::class, 'work_detail_info_page']);
Route::get('/apply_job_page/{id}', [HomeController::class, 'apply_job_page']);
Route::post('/apply_job/{id}', [HomeController::class, 'apply_job']);
Route::post('/choose_applicant', [HomeController::class, 'choose_applicant']);

