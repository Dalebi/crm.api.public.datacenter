<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('app');

});
//echo "!" . env('APP_VER') . 'quotes/pdf';
Route::post(env('APP_VER') . 'quotes/pdf',
function () {
    return 'hola';

});
//echo "!";
//Route::post('quotes/pdf', 'App\Http\Controllers\API\CRM\QuoteController@getPDF')->name('pdf_quotes');

