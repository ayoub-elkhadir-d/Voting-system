<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TopicController;
use App\Models\Room;
use App\Models\Topic;
use App\Models\choix;
Route::get('/', function () {
    return view('welcome');
});



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

Route::get('/rooms/{room_id}/start', [RoomController::class, 'start']);



Route::post('/rooms/{room}/topic', [TopicController::class, 'store']);

Route::get('/update/topic/{id}/room/{room_id}', function ($id, $room_id) {
    $data    = Topic::find($id);
    $choixes = choix::where('topic_id', $id)->where('room_id', $room_id)->get();
    $topics = Topic::where('room_id', $room_id)->get();
    return view('Topic/update', ['data' => $data, 'choixes' => $choixes,'topics'=>$topics]);
});
Route::post('/update/topic/{id}/room/{room_id}', [TopicController::class, 'update']);

Route::get('/rooms/{room}/gettopics',[TopicController::class, 'get_all_topics']);

    
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard']);
    Route::get('/myrooms',[RoomController::class , 'rooms']);
    Route::delete('/delete/{id}',[RoomController::class , 'delete']);

    Route::get('/update/{id}',function($id){
        $data = Room::find($id);
        return view('Room/update',['data'=>$data]);
    });
Route::get('/show/{room}', [RoomController::class, 'show'])->name('room.show');
    Route::post('/update/{id}',[RoomController::class ,'update']);
    Route::get('/roomcreate', function(){
     return view("Room.create");
});
    Route::post('/createroom', [RoomController::class , 'store']);
});
