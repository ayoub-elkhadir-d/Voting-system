<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JoinController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\VoteController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/',              fn() => view('welcome'));
Route::get('/register',      fn() => view('auth.register'));
Route::post('/register',     [AuthController::class, 'register']);
Route::get('/login',         [AuthController::class, 'showLogin']);
Route::post('/login',        [AuthController::class, 'login']);
Route::post('/logout',       [AuthController::class, 'logout']);
Route::get('/resetpassword', [AuthController::class, 'showReset']);
Route::post('/resetpassword',[AuthController::class, 'login_link']);
Route::get('/login-link/{token}', [AuthController::class, 'verify']);

/*
|--------------------------------------------------------------------------
| Protected Routes (requires login)
|--------------------------------------------------------------------------
*/
Route::middleware(['check.login', 'user.only'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);

    /*
    |--------------------------------------------------------------------------
    | Room Management
    |--------------------------------------------------------------------------
    */
    Route::get('/myrooms',    [RoomController::class, 'rooms']);
    Route::get('/roomcreate', fn() => view('Room.create'));
    Route::post('/createroom',[RoomController::class, 'store']);

    Route::middleware('room.owner')->group(function () {
        Route::get('/show/{room}',    [RoomController::class, 'show'])->name('room.show');
        Route::get('/update/{id}',    [RoomController::class, 'edit']);
        Route::post('/update/{id}',   [RoomController::class, 'update']);
        Route::delete('/delete/{id}', [RoomController::class, 'delete']);
    });

    /*
    |--------------------------------------------------------------------------
    | Room Join System
    |--------------------------------------------------------------------------
    */
    Route::get('/rooms/join',          [JoinController::class, 'index']);
    Route::post('/rooms/join',         [JoinController::class, 'join'])->middleware(['room.started', 'no.owner.join']);
    Route::get('/rooms/join/{code}',   [JoinController::class, 'join'])->middleware('no.owner.join');
    Route::post('/rooms/confirm-join', [JoinController::class, 'confirm'])->middleware('no.owner.join');
    Route::get('/rooms/{room}/waiting',[JoinController::class, 'waiting'])->middleware('no.owner.join');
    Route::post('/rooms/{room}/left',  [JoinController::class, 'leave']);

    /*
    |--------------------------------------------------------------------------
    | Room Live Control
    |--------------------------------------------------------------------------
    */
    Route::get('/rooms/{room_id}/start', [RoomController::class, 'start']);

    Route::middleware('room.owner')->group(function () {
        Route::post('/rooms/{room}/start', [RoomController::class, 'broadcastRoom']);
    });

    /*
    |--------------------------------------------------------------------------
    | Topics Management
    |--------------------------------------------------------------------------
    */
    Route::post('/rooms/{room}/topic',                   [TopicController::class, 'store']);
    Route::get('/rooms/{room}/gettopics',                [TopicController::class, 'all']);
    Route::get('/rooms/{room}/topics/{topic}/edit',      [TopicController::class, 'edit']);
    Route::post('/rooms/{room}/topics/{topic}',          [TopicController::class, 'update']);
    Route::delete('/rooms/{room}/topics/{topic}',        [TopicController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | Voting System
    |--------------------------------------------------------------------------
    */
    Route::post('/rooms/vote/submit', [VoteController::class, 'submit']);
    Route::get('/rooms/{room}/vote',  [VoteController::class, 'show'])->middleware('accepted.member');

    Route::middleware('room.owner')->group(function () {
        Route::get('/rooms/{room}/admin',                  [AdminController::class,  'show']);
        Route::post('/rooms/{room}/topic/{topic}/start',   [TopicController::class,  'start']);
        Route::post('/rooms/{room}/topic/{topic}/stop',    [TopicController::class,  'stop']);
        Route::post('/rooms/{room}/topic/{topic}/restart', [TopicController::class,  'restart']);
        Route::get('/rooms/{room}/topic/{topic}/votes',    [TopicController::class,  'votes']);
        Route::delete('/rooms/{room}/members/{member}',    [RoomController::class,   'removeUser']);
        Route::post('/rooms/{room}/members/{member}/approve', [RoomController::class, 'approveUser']);
    });

});

/*
|--------------------------------------------------------------------------
| Super Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['check.login', 'superadmin'])->prefix('superadmin')->group(function () {
    Route::get('/',                          [SuperAdminController::class, 'index']);
    Route::post('/users/{user}/ban',         [SuperAdminController::class, 'banUser']);
    Route::post('/users/{user}/unban',       [SuperAdminController::class, 'unbanUser']);
    Route::delete('/users/{user}',           [SuperAdminController::class, 'deleteUser']);
    Route::post('/users/{user}/promote',     [SuperAdminController::class, 'promoteUser']);
    Route::post('/users/{user}/demote',      [SuperAdminController::class, 'demoteUser']);
    Route::delete('/rooms/{room}',           [SuperAdminController::class, 'deleteRoom']);
});
