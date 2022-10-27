<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterApiController;
use App\Http\Controllers\Api\LoginApiController;
use App\Http\Controllers\Api\RoleId2MyProfileApiController;
use App\Http\Controllers\Api\UserUpdatePasswordController;
use App\Http\Controllers\Api\RoleId3MyProfileUpdateController;
use App\Http\Controllers\Api\GetParametrsForProjectController;
use App\Http\Controllers\Api\OnlineRoleId3Controller;
use App\Http\Controllers\Api\SearchUserController;
use App\Http\Controllers\Api\CreateOrderTendersRoleId2Controller;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\ActiveJobController;
use App\Http\Controllers\Api\TenderMessagesController;
use App\Http\Controllers\Api\OrderTransactionController;
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

Route::get('getCategory', [GetParametrsForProjectController::class, 'getCategory']);
Route::get('getRegion', [GetParametrsForProjectController::class, 'getRegion']);




Route::post('newPhoneRegister', [RegisterApiController::class, 'newPhoneRegister']);
Route::post('dublnewPhoneRegister', [RegisterApiController::class, 'dublnewPhoneRegister']);
Route::post('register', [RegisterApiController::class, 'register']);
Route::post('comparecode',[RegisterApiController::class, 'comparecode']);

Route::post('userlogin', [LoginApiController::class, 'userlogin']);
Route::post('userlogout', [LoginApiController::class, 'userlogout']);


Route::post('sendcodeforgotpassword' , [LoginApiController::class , 'sendcodeforgotpassword']);
Route::post('comparecoderesetpassword' , [LoginApiController::class , 'comparecoderesetpassword']);
Route::post('updatePasswordResetPassword' , [LoginApiController::class , 'updatePasswordResetPassword']);

//
//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//
//
//
//
//});

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('RoleId2MyProfile', [RoleId2MyProfileApiController::class, 'RoleId2MyProfile']);
    Route::post('updateRoleId2MyProfile',[RoleId2MyProfileApiController::class, 'updateRoleId2MyProfile']);
    Route::post('UpdateRoleId2Phone',[RoleId2MyProfileApiController::class, 'UpdateRoleId2Phone']);
    Route::post('SendCallNewNumberRoleid2',[RoleId2MyProfileApiController::class, 'SendCallNewNumberRoleid2']);
    Route::post('CompareCodeNewNumber',[RoleId2MyProfileApiController::class, 'CompareCodeNewNumber']);
    Route::post('RoleId2Updateavatar',[RoleId2MyProfileApiController::class, 'RoleId2Updateavatar']);
    Route::post('RoleId2UpdateEmail',[RoleId2MyProfileApiController::class, 'RoleId2UpdateEmail']);

    Route::post('RoleId3UpdateProfilePhoto', [RoleId3MyProfileUpdateController::class, 'RoleId3UpdateProfilePhoto']);
    Route::post('updateTexPassportPhoto ', [RoleId3MyProfileUpdateController::class, 'updateTexPassportPhoto']);

    Route::post('userUpdatePassword', [UserUpdatePasswordController::class, 'userUpdatePassword']);

    Route::post('StartOnline', [OnlineRoleId3Controller::class , 'StartOnline']);
    Route::post('isOnlineUser', [OnlineRoleId3Controller::class , 'isOnlineUser']);


    Route::post('SearchCategoryName', [SearchUserController::class, 'SearchCategoryName']);
    Route::post('FilterUsers', [SearchUserController::class, 'FilterUsers']);

    Route::post('OnePageRoleId3' , [SearchUserController::class, 'OnePageRoleId3']);

    Route::post('CreateTender', [CreateOrderTendersRoleId2Controller::class, 'CreateTender']);
    Route::get('getMytender', [CreateOrderTendersRoleId2Controller::class, 'getMytender']);
    Route::post('deleteTender', [CreateOrderTendersRoleId2Controller::class, 'deleteTender']);
    Route::post('DeleteTenderPhoto', [CreateOrderTendersRoleId2Controller::class, 'DeleteTenderPhoto']);
    Route::post('UpdateTender', [CreateOrderTendersRoleId2Controller::class, 'UpdateTender']);
    Route::get('getAllTenderForRoleId3', [CreateOrderTendersRoleId2Controller::class, 'getAllTenderForRoleId3']);

    Route::post('CreateNotification', [NotificationController::class, 'CreateNotification']);
    Route::get('getMyNotoficationRoleId2', [NotificationController::class, 'getMyNotoficationRoleId2']);
    Route::post('AddRoleId3Reviews', [NotificationController::class, 'AddRoleId3Reviews']);
    Route::post('singlePageEstimates', [NotificationController::class, 'singlePageEstimates']);


    Route::post('createMessage', [MessageController::class, 'createMessage']);
    Route::post('ChatUser', [MessageController::class, 'ChatUser']);
    Route::post('OnePageMessage', [MessageController::class, 'OnePageMessage']);

    Route::post('getRoleId3Invite', [MessageController::class, 'getRoleId3Invite']);
    Route::post('addNewInvite', [MessageController::class, 'addNewInvite']);

    Route::post('SuccsesInvite', [MessageController::class, 'SuccsesInvite']);
    Route::post('deleteInvite', [MessageController::class, 'deleteInvite']);


    Route::post('StartJob', [ActiveJobController::class, 'StartJob']);
    Route::post('endJob', [ActiveJobController::class, 'endJob']);


    Route::post('StartChat', [TenderMessagesController::class, 'StartChat']);
    Route::post('getTendersChat', [TenderMessagesController::class, 'getTendersChat']);
    Route::post('createNewMessageTender', [TenderMessagesController::class, 'createNewMessageTender']);
    Route::post('singlePageChatTender', [TenderMessagesController::class, 'singlePageChatTender']);


    Route::post('OrderTranzaction', [OrderTransactionController::class, 'OrderTranzaction']);






});
