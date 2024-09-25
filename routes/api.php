<?php

use App\Http\Controllers\API\V1\Admin\SwifthayajobController;
use App\Http\Controllers\API\V1\Admin\TalentProfileController;
use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\MessageController;
use App\Http\Controllers\API\V1\PaymentController;
use App\Http\Controllers\API\V1\ReviewController;
use App\Http\Controllers\API\V1\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Authentication and Registeration routes
Route::post('/login', [AuthController::class, "login"])->middleware('guest');
Route::post('/register', [AuthController::class, "register"])->middleware('guest');

Route::middleware(['auth:sanctum'])->group(function () {

  Route::post('/logout', [AuthController::class, "logout"]);

  // User and Userprofile
  Route::get('/profile', [UserController::class, "show"]);
  Route::post('/profile_image', [UserController::class, "profile_img"]);
  Route::delete('/profile/delete', [UserController::class, "destroy"]);


  // payments
  Route::get('/initialize-payment', [PaymentController::class, 'init'])->name('payment.init');

  Route::post('/payment/refund', [PaymentController::class, 'refundPayment']);
});

Route::post('/payment/webhook', [PaymentController::class, 'handleWebhook']);


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
// application
require base_path('routes/API/application.php');
// message
require base_path('routes/API/message.php');

// admin
require base_path('routes/API/admin.php');
