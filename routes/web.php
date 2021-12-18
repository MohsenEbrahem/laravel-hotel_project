<?php
use App\Http\Controllers\bookingController;
use App\Http\Controllers\roomController;
use App\Http\Controllers\guestController;
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
    return ('welcome');
});
Route::get('/bookingRoom', [bookingController::class, 'orderAnAvailableRoom']);

Route::get('rooms/search/{roomNumber}',[roomController::class, 'checkIfThisRoomReservedNowOrNO']);
Route::get('guests/search/{guestNumber}',[guestController::class, 'checkIfThisGuestInhotelNow']);
Route::get('guests/searching/{name}',[guestController::class, 'searchingForGuestByName']);