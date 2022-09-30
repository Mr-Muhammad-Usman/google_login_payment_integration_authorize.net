<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\GoogleController;
use \App\Http\Controllers\PaymentController;
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

//Route::get('/', function () {
//    return view('Login');
//});
//for detail of google login read googlegide.blade.php
//https://www.youtube.com/watch?v=T8Jq3XE2sxo&ab_channel=ExpertRohila
Route::get('/',[GoogleController::class,'index'])->name('index');
Route::get('/google',[GoogleController::class,'redirectGoogle'])->name('redirectGoogle');
Route::get('/google/callback',[GoogleController::class,'getGoogleData'])->name('getGoogleData');

Route::get('login/instagram','Auth\GoogleController@redirectToInstagramProvider')->name('instagramlogin');
Route::get('login/instagram/callback', 'Auth\GoogleController@instagramProviderCallback')->name('instagramlogin.callback');

Route::get('/facebook',[GoogleController::class,'redirectfacebook'])->name('redirectfacebook');
Route::get('/facebook/callback',[GoogleController::class,'getfacebookData'])->name('facebookData');

Route::get('/instagram/Gallery',[GoogleController::class,'instagramGallery'])->name('instagramGallery');

Route::group(['middleware'=>['userProtect']],function (){
    Route::get('Authorize-Page',[PaymentController::class,'authorizePage'])->name('authorizePage');
    Route::post('Authorize-Payment',[PaymentController::class,'authorizePayment'])->name('authorizePayment');
    Route::get('thank-you-page',[PaymentController::class,'thankYouPage'])->name('thankYouPage');
    Route::get('Orders',[PaymentController::class,'order'])->name('orderPage');
    Route::get('logout',[PaymentController::class,'user_logout'])->name('user_logout');
    Route::get('chase-page',[PaymentController::class,'chase_page'])->name('ChasePage');
});
