<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\VoteController;
use App\Events\roomstart;
use App\Models\Room;
use App\Models\Topic;
use App\Models\choix;

/*
|--------------------------------------------------------------------------
| Public Routes (Authentication)
|--------------------------------------------------------------------------
| Registration, login, password reset, etc.
*/
Route::get('/', fn() => view('welcome'));

Route::get('/register', fn() => view('auth.register'));
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/resetpassword', [AuthController::class, 'showReset']);
Route::post('/resetpassword', [AuthController::class, 'login_link']);
Route::get('/login-link/{token}', [AuthController::class, 'verify']);


/*
|--------------------------------------------------------------------------
| Protected Routes (Requires Authentication)
|--------------------------------------------------------------------------
| All routes inside here require user to be logged in
*/
Route::middleware('check.login')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [AuthController::class, 'dashboard']);

    /*
    |--------------------------------------------------------------------------
    | Room Management
    |--------------------------------------------------------------------------
    | Create, update, delete, and view rooms
    */
    Route::get('/myrooms', [RoomController::class, 'rooms']);
    Route::get('/roomcreate', fn() => view('Room.create'));
    Route::post('/createroom', [RoomController::class, 'store']);

Route::middleware('room.owner')->group(function () {
    Route::get('/show/{room}', [RoomController::class, 'show'])
        ->name('room.show');
        

    Route::get('/update/{id}', fn($id) =>
        view('Room/update', ['data' => Room::find($id)])
    );

    Route::post('/update/{id}', [RoomController::class, 'update']);
    Route::delete('/delete/{id}', [RoomController::class, 'delete']);
});
    /*
    |--------------------------------------------------------------------------
    | Room Join System
    |--------------------------------------------------------------------------
    | Join rooms using code or confirmation
    */

     Route::get('/rooms/join', [RoomController::class, 'get_join']);
     Route::post('/rooms/join', [RoomController::class, 'join'])->middleware('room.started');
     Route::get('/rooms/join/{code}', [RoomController::class, 'join']);

     Route::post('/rooms/confirm-join', [RoomController::class, 'join_confirm']);
         
    Route::get('/rooms/{room}/waiting', [RoomController::class, 'waiting']);
  

    /*
    |--------------------------------------------------------------------------
    | Room Live Control
    |--------------------------------------------------------------------------
    | Start room session or leave room
    */
    
    Route::post('/rooms/{room_id}/left', [RoomController::class, 'left_room']);

Route::middleware('room.owner')->group(function () {

    Route::post('/rooms/{room}/start', function (Room $room) {
        broadcast(new roomstart($room->id));
        return redirect("/rooms/{$room->id}/admin");
    });

});
    Route::get('/rooms/{room_id}/start', [RoomController::class, 'start']);

    /*
    |--------------------------------------------------------------------------
    | Topics Management
    |--------------------------------------------------------------------------
    | Create, update, and fetch topics in a room
    */
    Route::post('/rooms/{room}/topic', [TopicController::class, 'store']);
    Route::get('/rooms/{room}/gettopics', [TopicController::class, 'get_all_topics']);

    Route::get('/update/topic/{id}/room/{room_id}', function ($id, $room_id) {
        return view('Topic/update', [
            'data'    => Topic::find($id),
            'choixes' => choix::where('topic_id', $id)
                              ->where('room_id', $room_id)
                              ->get(),
            'topics'  => Topic::where('room_id', $room_id)->get(),
        ]);
    });

    Route::post('/update/topic/{id}/room/{room_id}', [TopicController::class, 'update']);

    /*
    |--------------------------------------------------------------------------
    | Voting System
    |--------------------------------------------------------------------------
    | Submit votes, manage topics voting, and view results
    */
    Route::post('/rooms/vote/submit', [VoteController::class, 'submit']);
    Route::get('/rooms/{room}/vote', [VoteController::class, 'show'])->middleware('accepted.member');
  

Route::middleware('room.owner')->group(function () {
    Route::post('/rooms/{room}/topic/{topic}/stop', [VoteController::class, 'stopTopic']);
    Route::post('/rooms/{room}/topic/{topic}/start', [VoteController::class, 'startTopic']);
    Route::get('/rooms/{room}/topic/{topic}/votes', [VoteController::class, 'topicVotes']);
 Route::get('/rooms/{room}/admin', [VoteController::class, 'adminShow']);
Route::post('/rooms/{room}/topic/{topic}/restart', [TopicController::class, 'restart']);
 Route::delete('/rooms/{room}/remove-user/{id}', [RoomController::class, 'removeUser']);

 Route::post('/rooms/{room}/approve/{member}', [RoomController::class, 'approveUser']);
Route::post('/rooms/{room}/remove/{member}', [RoomController::class, 'removeUser']);
});

});