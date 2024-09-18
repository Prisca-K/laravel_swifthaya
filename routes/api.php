<?php

use App\Http\Controllers\API\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/login', [AuthController::class, "login"]);
Route::post('/register', [AuthController::class, "register"]);
Route::post('/logout', [AuthController::class, "logout"])->middleware('auth:sanctum');


// talents
require base_path('routes/API/talent.php');
// company
require base_path('routes/API/company.php');
// job
require base_path('routes/API/job.php');
// project
require base_path('routes/API/project.php');
// review
require base_path('routes/API/review.php');