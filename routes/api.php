<?php

use App\Http\Controllers\API\CRM\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
//echo "entra" . env('APP_VER') . 'login', 'App\Http\Controllers\API\CRM\AuthController@login';
Route::post(env('APP_VER') . 'login', 'App\Http\Controllers\API\CRM\AuthController@login');

Route::post(env('APP_VER') . 'register', 'App\Http\Controllers\API\CRM\AuthController@register');
Route::middleware('auth:api')->post(env('APP_VER') . 'logout', 'App\Http\Controllers\API\CRM\AuthController@logout');

/*
|--------------------------------------------------------------------------
| Users
|--------------------------------------------------------------------------
*/
Route::middleware('auth:api')->group(function () {
    Route::resource(env('APP_VER') . '/users', 'App\Http\Controllers\API\CRM\UserController');
});

Route::middleware('auth:api')->post(env('APP_VER') . 'users/query', 'App\Http\Controllers\API\CRM\UserController@query');
Route::middleware('auth:api')->post(env('APP_VER') . 'users/uploadImage', 'App\Http\Controllers\API\CRM\UserController@uploadImage');
Route::middleware('auth:api')->post(env('APP_VER') . 'users/deleteImage', 'App\Http\Controllers\API\CRM\UserController@deleteImage');
Route::middleware('auth:api')->post(env('APP_VER') . 'users/forSelect', 'App\Http\Controllers\API\CRM\UserController@forSelect');
Route::middleware('auth:api')->post(env('APP_VER') . 'users/forSelectUsersReports', 'App\Http\Controllers\API\CRM\UserController@forSelectUsersReports');
Route::middleware('auth:api')->post(env('APP_VER') . 'users/logs', 'App\Http\Controllers\API\CRM\UserController@logs');

Route::middleware('auth:api')->group(function () {
    Route::resource(env('APP_VER') . '/userRoles', 'App\Http\Controllers\API\CRM\UserRolesController');
});
Route::middleware('auth:api')->post(env('APP_VER') . 'userRoles/authUserRoles', 'App\Http\Controllers\API\CRM\UserRolesController@authUserRoles');
Route::middleware('auth:api')->post(env('APP_VER') . 'userRoles/query', 'App\Http\Controllers\API\CRM\UserRolesController@query');

/*
|--------------------------------------------------------------------------
| Contacts
|--------------------------------------------------------------------------
*/
Route::middleware('auth:api')->group(function () {
    Route::resource(env('APP_VER') . '/contacts', 'App\Http\Controllers\API\CRM\ContactController');
});
Route::middleware('auth:api')->post(env('APP_VER') . 'contacts/query', 'App\Http\Controllers\API\CRM\ContactController@query');


/*
|--------------------------------------------------------------------------
| Corporates
|--------------------------------------------------------------------------
*/
Route::middleware('auth:api')->group(function () {
    Route::resource(env('APP_VER') . '/corporates', 'App\Http\Controllers\API\CRM\CorporateController');
});
Route::middleware('auth:api')->post(env('APP_VER') . 'corporates/query', 'App\Http\Controllers\API\CRM\CorporateController@query');
Route::middleware('auth:api')->post(env('APP_VER') . 'corporates/collaborators', 'App\Http\Controllers\API\CRM\CorporateController@collaborators');
Route::middleware('auth:api')->post(env('APP_VER') . 'corporates/address', 'App\Http\Controllers\API\CRM\CorporateController@address');

/*
|--------------------------------------------------------------------------
| Collaborators
|--------------------------------------------------------------------------
*/
Route::middleware('auth:api')->group(function () {
    Route::resource(env('APP_VER') . '/collaborators', 'App\Http\Controllers\API\CRM\CollaboratorController');
});
Route::middleware('auth:api')->post(env('APP_VER') . 'collaborators/query', 'App\Http\Controllers\API\CRM\CollaboratorController@query');

/*
|--------------------------------------------------------------------------
| Collaborator Catalogs
|--------------------------------------------------------------------------
*/
Route::middleware('auth:api')->group(function () {
    Route::resource(env('APP_VER') . '/collaboratorCatalogs', 'App\Http\Controllers\API\CRM\CollaboratorCatalogController');
});
Route::middleware('auth:api')->post(env('APP_VER') . 'collaboratorCatalogs/query', 'App\Http\Controllers\API\CRM\CollaboratorCatalogController@query');

/*
|--------------------------------------------------------------------------
| Corporate Catalogs
|--------------------------------------------------------------------------
*/
Route::middleware('auth:api')->group(function () {
    Route::resource(env('APP_VER') . '/corporateCatalogs', 'App\Http\Controllers\API\CRM\CorporateCatalogController');
});
Route::middleware('auth:api')->post(env('APP_VER') . 'corporateCatalogs/query', 'App\Http\Controllers\API\CRM\CorporateCatalogController@query');

/*
|--------------------------------------------------------------------------
| Countries
|--------------------------------------------------------------------------
*/
Route::middleware('auth:api')->group(function () {
    Route::resource(env('APP_VER') . '/countrys', 'App\Http\Controllers\API\CRM\CountryController');
});
Route::middleware('auth:api')->post(env('APP_VER') . 'countrys/query', 'App\Http\Controllers\API\CRM\CountryController@query');

/*
|--------------------------------------------------------------------------
| States
|--------------------------------------------------------------------------
*/
Route::middleware('auth:api')->group(function () {
    Route::resource(env('APP_VER') . '/states', 'App\Http\Controllers\API\CRM\StateController');
});
Route::middleware('auth:api')->post(env('APP_VER') . 'states/query', 'App\Http\Controllers\API\CRM\StateController@query');

/*
|--------------------------------------------------------------------------
| Quotes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:api')->group(function () {
    Route::resource(env('APP_VER') . '/quotes', 'App\Http\Controllers\API\CRM\QuoteController');
});
Route::middleware('auth:api')->post(env('APP_VER') . 'quotes/query', 'App\Http\Controllers\API\CRM\QuoteController@query');
Route::middleware('auth:api')->post(env('APP_VER') . 'quotes/pdf', 'App\Http\Controllers\API\CRM\QuoteController@getPDF')->name('pdf_quotes');
Route::middleware('auth:api')->post(env('APP_VER') . 'quotes/getCpuDetail/{id}', 'App\Http\Controllers\API\CRM\QuoteController@getCpuDetails');
Route::middleware('auth:api')->post(env('APP_VER') . 'quotes/getRaidDetail/{id}', 'App\Http\Controllers\API\CRM\QuoteController@getRaidDetails');
Route::middleware('auth:api')->post(env('APP_VER') . 'quotes/getServicePrice/{table}/{id}/{billing_cycle}', 'App\Http\Controllers\API\CRM\QuoteController@getServicePrice');
Route::middleware('auth:api')->post(env('APP_VER') . 'quotes/getServerPrice', 'App\Http\Controllers\API\CRM\QuoteController@getServerPrice');

/*
|--------------------------------------------------------------------------
| Quote Catalogs
|--------------------------------------------------------------------------
*/
Route::middleware('auth:api')->group(function () {
    Route::resource(env('APP_VER') . '/quoteCatalogs', 'App\Http\Controllers\API\CRM\QuoteCatalogController');
});
Route::middleware('auth:api')->post(env('APP_VER') . 'quoteCatalogs/query', 'App\Http\Controllers\API\CRM\QuoteCatalogController@query');

/*
|--------------------------------------------------------------------------
| Titles
|--------------------------------------------------------------------------
*/
Route::middleware('auth:api')->group(function () {
    Route::resource(env('APP_VER') . '/titles', 'App\Http\Controllers\API\CRM\TitleController');
});
Route::middleware('auth:api')->post(env('APP_VER') . 'titles/query', 'App\Http\Controllers\API\CRM\TitleController@query');

/*
|--------------------------------------------------------------------------
| Data Centers
|--------------------------------------------------------------------------
*/
Route::middleware('auth:api')->group(function () {
    Route::resource(env('APP_VER') . '/dataCenters', 'App\Http\Controllers\API\CRM\DataCenterController');
});
Route::middleware('auth:api')->post(env('APP_VER') . 'dataCenters/query', 'App\Http\Controllers\API\CRM\DataCenterController@query');

/*
|--------------------------------------------------------------------------
| Administration
|--------------------------------------------------------------------------
*/
Route::middleware('auth:api')->group(function () {
    Route::resource(env('APP_VER') . '/administrations', 'App\Http\Controllers\API\CRM\AdministrationController');
});
Route::middleware('auth:api')->post(env('APP_VER') . 'administrations/query', 'App\Http\Controllers\API\CRM\AdministrationController@query');

/*
|--------------------------------------------------------------------------
| Payment Cycles
|--------------------------------------------------------------------------
*/
Route::middleware('auth:api')->group(function () {
    Route::resource(env('APP_VER') . '/paymentCycles', 'App\Http\Controllers\API\CRM\PaymentCycleController');
});
Route::middleware('auth:api')->post(env('APP_VER') . 'paymentCycles/query', 'App\Http\Controllers\API\CRM\PaymentCycleController@query');

/*
|--------------------------------------------------------------------------
| Control Panels
|--------------------------------------------------------------------------
*/
Route::middleware('auth:api')->group(function () {
    Route::resource(env('APP_VER') . '/controlPanels', 'App\Http\Controllers\API\CRM\ControlPanelController');
});
Route::middleware('auth:api')->post(env('APP_VER') . 'controlPanels/query', 'App\Http\Controllers\API\CRM\ControlPanelController@query');

/*
|--------------------------------------------------------------------------
| Operative Systems
|--------------------------------------------------------------------------
*/
Route::middleware('auth:api')->group(function () {
    Route::resource(env('APP_VER') . '/operativeSystems', 'App\Http\Controllers\API\CRM\OperativeSystemController');
});
Route::middleware('auth:api')->post(env('APP_VER') . 'operativeSystems/query', 'App\Http\Controllers\API\CRM\OperativeSystemController@query');

/*
|--------------------------------------------------------------------------
| Opportunities
|--------------------------------------------------------------------------
*/
Route::middleware('auth:api')->group(function () {
    Route::resource(env('APP_VER') . '/opportunities', 'App\Http\Controllers\API\CRM\OpportunityController');
});
Route::middleware('auth:api')->post(env('APP_VER') . 'opportunities/query', 'App\Http\Controllers\API\CRM\OpportunityController@query');


/*
|--------------------------------------------------------------------------
| Addons
|--------------------------------------------------------------------------
*/
Route::middleware('auth:api')->group(function () {
    Route::resource(env('APP_VER') . '/addons', 'App\Http\Controllers\API\CRM\AddonController');
});
Route::middleware('auth:api')->post(env('APP_VER') . 'addons/query', 'App\Http\Controllers\API\CRM\AddonController@query');
Route::middleware('auth:api')->post(env('APP_VER') . 'addons/types', 'App\Http\Controllers\API\CRM\AddonController@types');
Route::middleware('auth:api')->get(env('APP_VER') . 'addons/types/{id}', 'App\Http\Controllers\API\CRM\AddonController@type');
Route::middleware('auth:api')->post(env('APP_VER') . 'addons/services', 'App\Http\Controllers\API\CRM\AddonController@services');
Route::middleware('auth:api')->get(env('APP_VER') . 'addons/services/{id}', 'App\Http\Controllers\API\CRM\AddonController@service');

/*
|------------------------w--------------------------------------------------
| Transfers
|--------------------------------------------------------------------------
*/
Route::middleware('auth:api')->group(function () {
    Route::resource(env('APP_VER') . '/transfers', 'App\Http\Controllers\API\CRM\TransferController');
});
Route::middleware('auth:api')->post(env('APP_VER') . 'transfers/query', 'App\Http\Controllers\API\CRM\TransferController@query');

/*
|--------------------------------------------------------------------------
| Public Ports
|--------------------------------------------------------------------------
*/
Route::middleware('auth:api')->group(function () {
    Route::resource(env('APP_VER') . '/publicPorts', 'App\Http\Controllers\API\CRM\PublicPortController');
});
Route::middleware('auth:api')->post(env('APP_VER') . 'publicPorts/query', 'App\Http\Controllers\API\CRM\PublicPortController@query');

/*
|--------------------------------------------------------------------------
| Type Services
|--------------------------------------------------------------------------
*/
Route::middleware('auth:api')->group(function () {
    Route::resource(env('APP_VER') . '/typeServices', 'App\Http\Controllers\API\CRM\TypeServiceController');
});
Route::middleware('auth:api')->post(env('APP_VER') . 'typeServices/query', 'App\Http\Controllers\API\CRM\TypeServiceController@query');
Route::middleware('auth:api')->post(env('APP_VER') . 'typeServices/distinct', 'App\Http\Controllers\API\CRM\TypeServiceController@distinct');

/*
|--------------------------------------------------------------------------
| Services
|--------------------------------------------------------------------------
*/
Route::middleware('auth:api')->group(function () {
    Route::resource(env('APP_VER') . '/services', 'App\Http\Controllers\API\CRM\ServiceController');
});
Route::middleware('auth:api')->post(env('APP_VER') . 'services/query', 'App\Http\Controllers\API\CRM\ServiceController@query');

/*
|--------------------------------------------------------------------------
| Cpus
|--------------------------------------------------------------------------
*/
Route::middleware('auth:api')->group(function () {
    Route::resource(env('APP_VER') . '/cpus', 'App\Http\Controllers\API\CRM\CpuController');
});
Route::middleware('auth:api')->post(env('APP_VER') . 'cpus/query', 'App\Http\Controllers\API\CRM\CpuController@query');


/*
|--------------------------------------------------------------------------
| Disks
|--------------------------------------------------------------------------
*/
Route::middleware('auth:api')->group(function () {
    Route::resource(env('APP_VER') . '/disks', 'App\Http\Controllers\API\CRM\DiskController');
});
Route::middleware('auth:api')->post(env('APP_VER') . 'disks/query', 'App\Http\Controllers\API\CRM\DiskController@query');

/*
|--------------------------------------------------------------------------
| Raids
|--------------------------------------------------------------------------
*/
Route::middleware('auth:api')->group(function () {
    Route::resource(env('APP_VER') . '/raids', 'App\Http\Controllers\API\CRM\RaidController');
});
Route::middleware('auth:api')->post(env('APP_VER') . 'raids/query', 'App\Http\Controllers\API\CRM\RaidController@query');

/*
|--------------------------------------------------------------------------
| Clouds
|--------------------------------------------------------------------------
*/
Route::middleware('auth:api')->group(function () {
    Route::resource(env('APP_VER') . '/clouds', 'App\Http\Controllers\API\CRM\CloudController');
});
Route::middleware('auth:api')->post(env('APP_VER') . 'clouds/query', 'App\Http\Controllers\API\CRM\CloudController@query');

/*
|--------------------------------------------------------------------------
| Rams
|--------------------------------------------------------------------------
*/
Route::middleware('auth:api')->group(function () {
    Route::resource(env('APP_VER') . '/rams', 'App\Http\Controllers\API\CRM\RamController');
});
Route::middleware('auth:api')->post(env('APP_VER') . 'rams/query', 'App\Http\Controllers\API\CRM\RamController@query');
//echo "sa1le";
