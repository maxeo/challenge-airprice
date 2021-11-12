<?php

use App\Http\Controllers\Api\Airport\AirportController;
use App\Http\Controllers\Api\Airport\FlightController;
use App\Http\Controllers\Api\Airport\GeneralAirportController;
use App\Http\Controllers\Api\Base\AuthController;
use App\Http\Controllers\Api\Base\PermissionController;
use App\Http\Controllers\Api\Base\RoleController;
use App\Http\Controllers\Api\Base\UserController;
use App\Http\Controllers\Api\Website\NavigationController;
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

#########################################################################
#                                                                       #
#                             PUBLIC ROUTES                             #
#                                                                       #
#########################################################################

#############################################
#                   Login                   #
#############################################

Route::post('login/', [AuthController::class, 'login']);


#############################################
#                  Airport                  #
#############################################

Route::get('/airport/list', [GeneralAirportController::class, 'getAirportList']);
Route::post('/airport/check-flights', [GeneralAirportController::class, 'checkFlights']);








#########################################################################
#                                                                       #
#                           PROTECTED ROUTES                            #
#                                                                       #
#########################################################################
Route::group(['middleware' => ['auth:sanctum']], function () {

    #############################################
    #                   LOGIN                   #
    #############################################
    Route::post('fresh/', [AuthController::class, 'fresh']);


    #############################################
    #                 NAVIGATION                #
    #############################################


    Route::get('navigation/', [NavigationController::class, 'getAvailable']);


    #############################################
    #                  RESOURCE                 #
    #############################################

    # PREVENTIVI PARAMETERS #
    #########################

    Route::resource('/airport/crud/airport', AirportController::class);
    Route::resource('/airport/crud/flight', FlightController::class);


    # USER MANAGING #
    #################
    Route::resource('/manage-user', UserController::class);
    Route::resource('/manage-role', RoleController::class);
    Route::resource('/manage-permission', PermissionController::class);

});

