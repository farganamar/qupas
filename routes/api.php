<?php

use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('user/register', 'APIRegisterController@register');
Route::post('user/login', 'APILoginController@login');

Route::group(['middleware' => 'jwt.auth'], function() {
    Route::get('profile' , function(Request $request){
        return auth()->user();
    });
    Route::post('transfer_saldo',  'WalletController@transfer');
    Route::get('history', 'WalletController@history');
    Route::get('detail-history' , 'WalletController@detailHistory');
    Route::get('filter-jenis-transaksi', 'WalletController@jenisTransaksi');
    Route::get('sort-date-asc' , 'WalletController@sortDateOld');
    Route::get('sort-date-desc', 'WalletController@sortDateNew');




    Route::get('user/logout', 'APILoginController@logout');
});
