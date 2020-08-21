<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    return "Cache is cleared";
});


/*********user routes************/
Route::get('/', 'Web@index');
Route::get('/faq', 'Web@faq');
Route::post('/store','Web@store')->name('store');
Route::post('/exchangeRate','Web@exchangeRate');
Route::post('/currency','Web@getCurrency');
Auth::routes(['verify' => true]);
Route::get('pmSuccess/{number}','Web@pmSuccess')->name('pmSuccess');
Route::match(['GET', 'POST'],'/pmCancel','Web@pmCancel')->name('pmCancel');
Route::post('/autoTransfer','Web@autoTransfer');
Route::post('autoTransferAdmin','Web@autoTransferAdmin');


// Route::post('/verifyUser','HomeController@verifyUser')->name('verify');
Route::get('/profile/{data?}','HomeController@profile')->name('profile');
Route::post('/profileupdate','HomeController@updateProfile')->name('profileupdate');
Route::resource('bitcoin', 'BitcoinPaymentController');

Route::post('/pmAlert','HomeController@pmAlert')->name('pmAlert');
Route::post('/ngnAutoFetch','HomeController@ngnAutoFetch')->name('ngnAutoFetch');
Route::post('/ngnAlert','HomeController@ngnAlert')->name('ngnAlert');
/*********user routes************/
    
Route::get('/home', 'HomeController@index')->name('home');
/*********Web Routes*************/
Route::group(['prefix'=>'home','as'=>'home.','middleware'=>'verified'],function(){
    // Route::get('/home', 'HomeController@index')->name('home');
    Route::get('verify/{type}','BankDetails@verify')->name('verify');
    Route::post('verifyAmount','BankDetails@verifyAmount')->name('verifyAmount');
});
/*******************/


/*********Admin Routes**********/
Route::group(['prefix' => 'admin','as' => 'admin.','middleware'=>['auth','is_admin']], function () {
    Route::get('/home', 'HomeController@adminHome')->name('home');
	Route::resource('currency', 'CurrencyController');
	Route::resource('transaction', 'TransactionController');
    Route::resource('profile','SettingsController');
    Route::resource('exchange-rate','ExchangeRateController');
    Route::resource('users','Utills');
});
/*******************/


/**********Payment Routes**********/
Route::get('/payMoney/{amount}/{from_currency}/{to_currency}/{status}','RaveController@index')->name('payMoney');
Route::match(['GET', 'POST'], '/pay', 'RaveController@initialize')->name('pay');
Route::get('/rave/callback', 'RaveController@callback')->name('callback');

Route::match(['GET', 'POST'], '/btc', 'RaveController@raveBTC')->name('btc');
Route::post('/btcPayment', 'Utills@btcPayment')->name('btcPayment');
Route::post('/checkConfirmation', 'Utills@checkConfirmation')->name('checkConfirmation');
Route::get('/confirmationCallback', 'Utills@confirmationCallback')->name('confirmationCallback');
Route::post('/btcPendingPayment', 'Utills@btcPendingPayment')->name('btcPendingPayment');
Route::get('/pending', 'RaveController@pendingBTC')->name('pendingBTC');
Route::get('/btcCallback', 'RaveController@btcCallback')->name('btcCallback');
/********************/