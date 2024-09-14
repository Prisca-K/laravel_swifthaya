<?php


use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IndividualController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//   return view('welcome');
// })->name("welcome");

// Route::get("/dashboard", [DashboardController::class, "index"])->middleware(['auth', 'verified'])->name('dashboard');


// // individual

// Route::get("/individual/dashboard", [IndividualController::class, "index"])->middleware(['auth', 'verified', "can:individual"])->name('individual.dashboard');

// Route::middleware(['auth'])->group(function () {
//   // display form
//   Route::get('/payment', [PaymentController::class, 'init'])->name('payment.init');

//   Route::post('/payment_form', [PaymentController::class, 'index'])->name('payment.index');

//   // Callback route after payment
//   Route::get('/payment/callback', [PaymentController::class, 'handleCallback'])->name('payment.callback');

//   // Webhook route for payment notifications
//   Route::post('/payment/webhook', [PaymentController::class, 'handleWebhook'])->name('payment.webhook');
// });

/* messsages */
// Route::middleware(['auth'])->group(function () {
//   Route::get('/conversations', [MessageController::class, 'index'])->name('conversations.index');
//   Route::post('/conversations/{recipient}', [MessageController::class, 'store_conversation'])->name('conversations.store');

//   Route::get('To/{recipient}', [MessageController::class, 'show'])->name('messages.show');
//   Route::post('/messages/{recipient}', [MessageController::class, 'store'])->name('messages.store');
// });




// Route::middleware('auth')->group(function () {
//   Route::get('/profile', [UserController::class, 'edit'])->name('profile.edit');

//   Route::post('/profile', [UserController::class, 'profile_img'])->name('profile.addimg');

//   Route::patch('/profile', [UserController::class, 'update'])->name('user.update');

//   // Route::patch('/company-profile/{user}', [UserController::class, 'companyProfile'])->name('user.companyProfile');

//   Route::delete('/profile', [UserController::class, 'destroy'])->name('profile.destroy');
// });



// Route::middleware('auth')->group(function () {
//   Route::get('reviews/create/{revieweeId}', [ReviewController::class, 'create'])->name('reviews.create');
//   Route::post('reviews', [ReviewController::class, 'store'])->name('reviews.store');
//   Route::get('reviews/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
//   Route::put('reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
//   Route::delete('reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
// });


// // talents
// require base_path('routes/talent.php');

// // company
// require base_path('routes/company.php');

// // jobs
// require base_path('routes/job.php');

// // project
// require base_path('routes/project.php');

// // application
// require base_path('routes/application.php');

// // admin
// require base_path('routes/admin.php');


// require __DIR__ . '/auth.php';
