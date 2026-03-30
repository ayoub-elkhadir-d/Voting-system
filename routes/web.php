<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\AuthController;
use App\Models\Room;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/roomcreate', function(){
     return view("Room.create");
});
Route::post('/createroom', [RoomController::class , 'store']);

Route::get('/register',function (){
    return view('auth.register');
});

Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/resetpassword', [AuthController::class, 'showReset']);
Route::post('/resetpassword', [AuthController::class, 'login_link']);


Route::get('/login-link/{token}', [AuthController::class, 'verify']);

Route::get('/myrooms',[RoomController::class , 'rooms']);
Route::delete('/delete/{id}',[RoomController::class , 'delete']);
Route::get('/update/{id}',function($id){
    $data = Room::find($id);
    return view('Room/update',['data'=>$data]);
});
Route::get('/show/{id}',[RoomController::class ,'show']);
Route::post('/update/{id}',[RoomController::class ,'update']);
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard']);
});
