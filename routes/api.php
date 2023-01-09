<?php

use App\Http\Controllers\Admin\VehicleController;
use App\Http\Controllers\Common\ResourceController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\InqueryController as AdminInqueryController;
use App\Http\Controllers\Admin\NewsLetterController;
use App\Http\Controllers\Admin\ShippingDocController;
use App\Http\Controllers\Customer\ShippingDocController as CustomerShippingDocController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Customer\Auth\AuthController;
use App\Http\Controllers\Customer\FinanceController;
use App\Http\Controllers\Customer\Auth\InqueryController;
use App\Http\Controllers\Customer\Auth\NewsLetterController as AuthNewsLetterController;
use App\Http\Controllers\Guest\ContentController as GuestContentController;
use App\Http\Controllers\Guest\InqueryController as GuestInqueryController;
use App\Http\Controllers\Guest\VehicleController as GuestVehicleController;
use App\Http\Resources\Admin\ShippingDocResource;
use Illuminate\Support\Facades\Route;


Route::get('test',function(){

    return "this route is working";
});
//=====Common Routes==================================================================//
Route::middleware(['auth:sanctum'])->get('/auth/checkLogin', function () {
    return response()->json(['data' => auth()->user()], 200);

});
Route::prefix('resources')->group(function () {
    Route::get('/maker',[ResourceController::class,'getMakerList']);
    Route::get('/model/{make_id}',[ResourceController::class,'getModelList']);
    Route::get('/status',[ResourceController::class,'getStatusList']);
    Route::get('/body-type',[ResourceController::class,'getbodyTypeList']);
    Route::get('/transmission',[ResourceController::class,'getTransmissionList']);
    Route::get('/streeings',[ResourceController::class,'getStreeingsList']);
    Route::get('/door-types',[ResourceController::class,'getDoorTypesList']);
    Route::get('/drive-types',[ResourceController::class,'getDriveTypesList']);
    Route::get('/fuel-types',[ResourceController::class,'getFuelTypesList']);
    Route::get('/exterior-colors',[ResourceController::class,'getExteriorColorsList']);
    Route::get('/features',[ResourceController::class,'getFeaturesList']);
    Route::get('/countries',[ResourceController::class,'getCountriesList']);
    Route::get('/forts/{country}',[ResourceController::class,'getFortList']);

    Route::get('/roles',[ResourceController::class,'getRoleList']);
    Route::get('/contents',[ContentController::class, 'getContentNames']);
    Route::get('/engine-types',[ResourceController::class, 'getEngineList']);
    Route::get('/gears',[ResourceController::class, 'getGearsList']);
    Route::get('/newsLetters',[ResourceController::class, 'getNewsLettersList']);
    Route::get('/odometers',[ResourceController::class, 'getOdometersList']);
    Route::get('/chassis',[ResourceController::class, 'getChassisList']);
    Route::get('/lot_numbers',[ResourceController::class, 'getLotNumbersList']);
    Route::get('/customers',[ResourceController::class, 'getCustomers']);


});

//======Staff Routes==================================================================//
Route::post('/staff/auth/register', [\App\Http\Controllers\Admin\Auth\AuthController::class, 'createStaff']);
Route::post('/staff/auth/login', [\App\Http\Controllers\Admin\Auth\AuthController::class, 'login']);
Route::post('/staff/auth/logout', [\App\Http\Controllers\Admin\Auth\AuthController::class, 'logout']);

//email verification
//Route::get('/staff/email/verify/{id}/{hash}', [\App\Http\Controllers\Admin\Auth\AuthController::class, 'verifyEmail'])->name('verification.verify');
//Route::post('/staff/email/verification-notification', [\App\Http\Controllers\Admin\Auth\AuthController::class, 'resendVerification'])->middleware(['auth:sanctum','abilities:jwt-staff', 'throttle:6,1'])->name('verification.send');

Route::middleware(['auth:sanctum', 'abilities:jwt-staff'])->prefix('staff')->group(function () {
    Route::get('/user', [\App\Http\Controllers\Admin\Auth\AuthController::class, 'getCurrentUser']);

    // vehicle
    Route::post('/vehicle/maker/quickAdd', [VehicleController::class, 'storeMaker'])->name('vehicle.maker.store');
    Route::post('/vehicle/model/quickAdd', [VehicleController::class, 'storeModel'])->name('vehicle.model.store');
    Route::post('/vehicle/body-type/quickAdd', [VehicleController::class, 'storeBodyType'])->name('vehicle.bodyType.store');
    Route::post('/vehicle/transmission/quickAdd', [VehicleController::class, 'storeTransmission'])->name('vehicle.transmission.store');
    Route::post('/vehicle/streeings/quickAdd', [VehicleController::class, 'storeStreeings'])->name('vehicle.streeings.store');
    Route::post('/vehicle/door-types/quickAdd', [VehicleController::class, 'storeDoorTypes'])->name('vehicle.doorTypes.store');
    Route::post('/vehicle/drive-types/quickAdd', [VehicleController::class, 'storeDriveTypes'])->name('vehicle.driveTypes.store');
    Route::post('/vehicle/fuel-types/quickAdd', [VehicleController::class, 'storeFuelTypes'])->name('vehicle.storeFuelTypes.store');
    Route::post('/vehicle/exterior-colors/quickAdd', [VehicleController::class, 'storeExteriorColors'])->name('vehicle.storeExteriorColors.store');
    Route::post('/vehicle/features/quickAdd', [VehicleController::class, 'storeFeatures'])->name('vehicle.storeFeatures.store');

    Route::post('/vehicle/engine/quickAdd', [VehicleController::class, 'storeEngine'])->name('vehicle.storeEngine.store');
    Route::post('/vehicle/gear/quickAdd', [VehicleController::class, 'storeGear'])->name('vehicle.storeGear.store');
    Route::post('/vehicle/fort/quickAdd', [VehicleController::class, 'storeFort'])->name('vehicle.storeFort.store');
    Route::post('/vehicle/vehicleUpdate/{id}', [VehicleController::class, 'vehicleUpdate'])->name('vehicle.vehicleUpdate.update');
    Route::post('/vehicle/odometer/quickAdd', [VehicleController::class, 'storeOdometer'])->name('vehicle.storeOdometer.store');
    Route::post('/vehicle/country/quickAdd', [VehicleController::class, 'storeCountry'])->name('vehicle.storeCountry.store');

    Route::resources(['vehicle' => VehicleController::class]);


    //contenet
    Route::get('/content/country/{id}',[ContentController::class, 'getByCountry']);
    Route::resources(['content' => ContentController::class]);

    //staffusers
    Route::resources(['staffuser' => StaffController::class]);

    //customer
    Route::get('/customer/change-status/{id}',[CustomerController::class, 'changeStatus']);
    Route::resources(['customer' => CustomerController::class]);


    //inquery
    Route::post('/inquery/sendReply',[AdminInqueryController::class, 'sendReply']);
    Route::resources(['inquery' => AdminInqueryController::class]);

    //news letters
    Route::post('/news-letter/send',[NewsLetterController::class, 'sendNewsLetter']);

    Route::resources(['news-letter' => NewsLetterController::class]);

    //shipping
    Route::post('/shipping/update/{id}',[ShippingDocController::class, 'update']);

    Route::resources(['shipping' => ShippingDocController::class]);

    Route::post('/payment/update/{id}',[PaymentController::class, 'update']);

    Route::resources(['payment' => PaymentController::class]);



});
//=====Customer Routes==================================================================//
Route::post('/customer/auth/register', [AuthController::class, 'createCustomer']);
Route::post('/customer/auth/login', [AuthController::class, 'login']);
Route::post('/customer/auth/logout', [AuthController::class, 'logout']);

Route::get('/customer/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])->name('verification.verify');
Route::post('/customer/email/verification-notification', [AuthController::class, 'resendVerification'])->middleware(['auth:sanctum', 'abilities:jwt-client', 'throttle:6,1'])->name('verification.send');

Route::middleware(['auth:sanctum', 'abilities:jwt-client'])->get('/customer/user', [AuthController::class, 'getCurrentUser']);

Route::middleware(['auth:sanctum', 'abilities:jwt-client'])->prefix('customer')->group(function () {

    Route::resources(['inquery' => InqueryController::class]);

    Route::post('/newsLetter/subscribe',[AuthNewsLetterController::class, 'subscribeForNewsLetter']);

    Route::resources(['newsLetter' => AuthNewsLetterController::class]);


    Route::resources(['shipping-doc' => CustomerShippingDocController::class]);


    Route::get('/stock',[FinanceController::class, 'getStockList']);
    Route::get('/transaction',[FinanceController::class, 'getTransactionList']);
    Route::get('/ledger',[FinanceController::class, 'getLedgerList']);


});




//================ Guest routes=====================
Route::prefix('guest')->group(function () {


    Route::get('/content/country/{name}',[GuestContentController::class, 'getByCountryName']);

    Route::resources(['inquery' => GuestInqueryController::class]);
    Route::resources(['vehicle' => GuestVehicleController::class]);
    Route::resources(['content' => GuestContentController::class]);

});

