<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\NewUserController;
use App\Http\Controllers\Admin\TransportController;
use App\Http\Controllers\Admin\GetAllCustomersController;
use App\Http\Controllers\Admin\GetAllExecutorController;
use App\Http\Controllers\Admin\TenderController;
use App\Http\Controllers\Admin\JobsController;
use App\Http\Controllers\Admin\RatingsController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\InviteController;
use App\Http\Controllers\Admin\ChatController;
use App\Http\Controllers\Admin\TwoUsersChatController;
use App\Http\Controllers\Admin\InfoSteachController;

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

Route::get('nouserAuth' , function (){
    return response()->json([
        'status'=>false,
        'message' => [
            'message' => 'no autorization user'
        ],
    ],422);
})->name('nouserAuth');

Route::prefix('admin')->group(function () {
    Route::middleware(['NoAuthUser'])->group(function () {
        Route::get('/login',[AdminLoginController::class,'login'])->name('login');
        Route::post('/logined',[AdminLoginController::class,'logined'])->name('logined');
    });


    Route::middleware(['AuthUser'])->group(function () {
        Route::get('HomePage', [AdminLoginController::class,'HomePage'])->name('HomePage');
        Route::get('logoutAdmin', [AdminLoginController::class,'logoutAdmin'])->name('logoutAdmin');


        Route::get('settingView', [AdminLoginController::class, 'settingView'])->name('settingView');
        Route::post('updatePassword', [AdminLoginController::class, 'updatePassword'])->name('updatePassword');


        Route::get('GetNewCustomers', [NewUserController::class, 'GetNewCustomers'])->name('GetNewCustomers');
        Route::get('OnePageGetNewCustomers/user_id={id}', [NewUserController::class, 'OnePageGetNewCustomers'])->name('OnePageGetNewCustomers');
        Route::get('GetNewExecutor', [NewUserController::class, 'GetNewExecutor'])->name('GetNewExecutor');

        Route::get('succsesuser/user_id={id}', [NewUserController::class, 'succsesuser'])->name('succsesuser');
        Route::get('addBlackList/user_id={id}', [NewUserController::class, 'addBlackList'])->name('addBlackList');
        Route::get('deleteBlackList/user_id={id}', [NewUserController::class, 'deleteBlackList'])->name('deleteBlackList');
        Route::post('updateUserProfile', [NewUserController::class, 'updateUserProfile'])->name('updateUserProfile');


        Route::get('SinglePageTransport/transport_id={id}', [TransportController::class, 'SinglePageTransport'])->name('SinglePageTransport');
        Route::post('deletephoto', [TransportController::class, 'deletephoto'])->name('deletephoto');
        Route::post('deleteadditional', [TransportController::class, 'deleteadditional'])->name('deleteadditional');
        Route::post('UpdateTransport', [TransportController::class, 'UpdateTransport'])->name('UpdateTransport');

        Route::get('deleteSubCategory/transport_id={id}', [TransportController::class, 'deleteSubCategory'])->name('deleteSubCategory');

        Route::get('GetAllCustomers', [GetAllCustomersController::class, 'GetAllCustomers'])->name('GetAllCustomers');
        Route::post('searchCustomers', [GetAllCustomersController::class, 'searchCustomers'])->name('searchCustomers');

        Route::get('GetAllExecutor', [GetAllExecutorController::class, 'GetAllExecutor'])->name('GetAllExecutor');
        Route::post('searchExucator', [GetAllExecutorController::class, 'searchExucator'])->name('searchExucator');
        Route::post('serachVinCode', [GetAllExecutorController::class, 'serachVinCode'])->name('serachVinCode');

        Route::get('UsersStat', [GetAllExecutorController::class, 'UsersStat'])->name('UsersStat');

        Route::get('getBlackListUsers', [GetAllExecutorController::class, 'getBlackListUsers'])->name('getBlackListUsers');

        Route::get('activeTariffPlyus/user_id={id}', [NewUserController::class, 'activeTariffPlyus'])->name('activeTariffPlyus');
        Route::get('deactiveTariffPlyus/user_id={id}', [NewUserController::class, 'deactiveTariffPlyus'])->name('deactiveTariffPlyus');

        Route::get('getNewTender',[TenderController::class, 'getNewTender'])->name('getNewTender');
        Route::get('SinglePageTariff/tender_id={id}',[TenderController::class, 'SinglePageTariff'])->name('SinglePageTariff');
        Route::get('SuccsesSinglePageTariff/tender_id={id}',[TenderController::class, 'SuccsesSinglePageTariff'])->name('SuccsesSinglePageTariff');
        Route::post('UpdateTender',[TenderController::class, 'UpdateTender'])->name('UpdateTender');

        Route::get('activeTenders', [TenderController::class,'activeTenders'])->name('activeTenders');
        Route::get('DeActiveTender', [TenderController::class,'DeActiveTender'])->name('DeActiveTender');
        Route::get('tendersChat/tender_id={id}/user_id={user_id}', [TenderController::class, 'tendersChat'])->name('tendersChat');
        Route::get('tenderChatSinglePage/tender_id={id}/user_id={user_id}', [TenderController::class, 'tenderChatSinglePage'])->name('tenderChatSinglePage');

        Route::get('activeJobs', [JobsController::class, 'activeJobs'])->name('activeJobs');
        Route::get('deactiveJobde',[JobsController::class, 'deactiveJobde'])->name('deactiveJobde');
        Route::post('FiltredeactiveJobde', [JobsController::class, 'FiltredeactiveJobde'])->name('FiltredeactiveJobde');
        Route::get('downloadExele', [JobsController::class, 'downloadExele'])->name('downloadExele');


        Route::get('getRaiting' ,[RatingsController::class, 'getRaiting'])->name('getRaiting');
        Route::get('singlePageRaiting/raiting_id={id}', [RatingsController::class, 'singlePageRaiting'])->name('singlePageRaiting');
        Route::post('updatereview', [RatingsController::class, 'updatereview'])->name('updatereview');


        Route::get('getcategory', [CategoryController::class, 'getcategory'])->name('getcategory');
        Route::get('SinglePageCategory/category_id={id}', [CategoryController::class, 'SinglePageCategory'])->name('SinglePageCategory');
        Route::get('SinglePageSubCategory/sub_category_id={id}', [CategoryController::class, 'SinglePageSubCategory'])->name('SinglePageSubCategory');
        Route::post('UpdateCategory', [CategoryController::class ,'UpdateCategory'])->name('UpdateCategory');
        Route::post('UpdateSubCategory', [CategoryController::class ,'UpdateSubCategory'])->name('UpdateSubCategory');



        Route::get('DangerInvite', [InviteController::class, 'DangerInvite'])->name('DangerInvite');


        Route::get('ChatBlade', [ChatController::class, 'ChatBlade'])->name('ChatBlade');
        Route::post('getRoomId', [ChatController::class, 'getRoomId'])->name('getRoomId');
        Route::post('createMessage', [ChatController::class, 'createMessage']);


        Route::post('SearchLeftUsers', [ChatController::class, 'SearchLeftUsers'])->name('SearchLeftUsers');


        Route::get('usersChat/user_id={id}', [TwoUsersChatController::class, 'usersChat'])->name('usersChat');

        Route::get('UsersRoomIdChat/room_id={id}', [TwoUsersChatController::class, 'UsersRoomIdChat'])->name('UsersRoomIdChat');

        Route::post('AdminSendMessage', [ChatController::class, 'AdminSendMessage'])->name('AdminSendMessage');

        Route::get('InfoOnas', [InfoSteachController::class , 'InfoOnas'])->name('InfoOnas');
        Route::post('UpdateInfo', [InfoSteachController::class, 'UpdateInfo'])->name('UpdateInfo');

    });

});
