<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TopicController;
use App\Events\roomstart;
use App\Models\Room;
use App\Models\Topic;
use App\Models\choix;
use App\Http\Controllers\VoteController;

Route::get('/', fn() => view('welcome'));

Route::get('/register', fn() => view('auth.register'));
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/resetpassword', [AuthController::class, 'showReset']);
Route::post('/resetpassword', [AuthController::class, 'login_link']);
Route::get('/login-link/{token}', [AuthController::class, 'verify']);

// Join room — same controller method handles both code form and direct link
Route::get('/rooms/join', [RoomController::class, 'get_join']);
Route::post('/rooms/join', [RoomController::class, 'join']);
Route::get('/rooms/join/{code}', [RoomController::class, 'join']);
Route::post('/rooms/confirm-join', [RoomController::class, 'join_confirm']);

Route::post('/rooms/vote/submit', [VoteController::class, 'submit']);
Route::get('/rooms/{room}/vote', [VoteController::class, 'show']);

Route::get('/rooms/{room_id}/start', [RoomController::class, 'start']);
Route::post('/rooms/{room}/start', function (Room $room) {
    broadcast(new roomstart($room->id));
});

Route::post('/rooms/{room_id}/left', [RoomController::class, 'left_room']);

Route::post('/rooms/{room}/topic', [TopicController::class, 'store']);
Route::get('/rooms/{room}/gettopics', [TopicController::class, 'get_all_topics']);

Route::get('/update/topic/{id}/room/{room_id}', function ($id, $room_id) {
    return view('Topic/update', [
        'data'    => Topic::find($id),
        'choixes' => choix::where('topic_id', $id)->where('room_id', $room_id)->get(),
        'topics'  => Topic::where('room_id', $room_id)->get(),
    ]);
});
Route::post('/update/topic/{id}/room/{room_id}', [TopicController::class, 'update']);

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard']);
    Route::get('/myrooms', [RoomController::class, 'rooms']);
    Route::delete('/delete/{id}', [RoomController::class, 'delete']);
    Route::get('/update/{id}', fn($id) => view('Room/update', ['data' => Room::find($id)]));
    Route::get('/show/{room}', [RoomController::class, 'show'])->name('room.show');
    Route::post('/update/{id}', [RoomController::class, 'update']);
    Route::get('/roomcreate', fn() => view('Room.create'));
    Route::post('/createroom', [RoomController::class, 'store']);
});
