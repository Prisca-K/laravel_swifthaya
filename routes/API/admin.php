<?php

use App\Http\Controllers\API\V1\Admin\ApplicationController;
use App\Http\Controllers\API\V1\Admin\CompanyProfileController;
use App\Http\Controllers\API\V1\Admin\MessageController;
use App\Http\Controllers\API\V1\Admin\PaymentController;
use App\Http\Controllers\API\V1\Admin\ProjectController;
use App\Http\Controllers\API\V1\Admin\ReviewController;
use App\Http\Controllers\API\V1\Admin\SwifthayajobController;
use App\Http\Controllers\API\V1\Admin\TalentProfileController;
use App\Http\Controllers\API\V1\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(['auth:sanctum', 'can:admin'])->group(function () {

  // User Management Routes
  Route::prefix('users')->group(function () {
    // List all users
    Route::get('/', [UserController::class, 'index']);

    // Create a new user
    Route::post('/', [UserController::class, 'store']);

    // Update user information 
    Route::patch('/{user}', [UserController::class, 'update']);

    // Delete a user
    Route::delete('/{user}', [UserController::class, 'destroy']);

    // Approve user registration 
    Route::patch('/{user}/approve', [UserController::class, 'approve']);

    // Reject user registration 
    Route::patch('/{user}/reject', [UserController::class, 'reject']);
  });

  // Review Management Routes
  Route::prefix('reviews')->group(function () {
    // List all reviews
    Route::get('/', [ReviewController::class, 'index']);

    // Create a new review
    Route::post('/', [ReviewController::class, 'store']);

    // View a specific review
    Route::get('/{review}', [ReviewController::class, 'show']);

    // Update review information 
    Route::patch('/{review}', [ReviewController::class, 'update']);

    // Delete a review
    Route::delete('/{review}', [ReviewController::class, 'destroy']);

    // Approve a review (Use PATCH for status update)
    Route::patch('/{review}/approve', [ReviewController::class, 'approve']);

    // Reject a review (Use PATCH for status update)
    Route::patch('/{review}/reject', [ReviewController::class, 'reject']);
  });

  // Job Management Routes
  Route::prefix('jobs')->group(function () {
    // List all jobs
    Route::get('/', [SwifthayajobController::class, 'index']);

    // Create a new job
    Route::post('/', [SwifthayajobController::class, 'store']);

    // View a specific job
    Route::get('/{job}', [SwifthayajobController::class, 'show']);

    // Update a job 
    Route::patch('/{job}', [SwifthayajobController::class, 'update']);

    // Delete a job
    Route::delete('/{job}', [SwifthayajobController::class, 'destroy']);

    // Approve a job listing 
    Route::patch('/{job}/approve', [SwifthayajobController::class, 'approve']);

    // Reject a job listing 
    Route::patch('/{job}/reject', [SwifthayajobController::class, 'reject']);
  });

  // Project Management Routes
  Route::prefix('projects')->group(function () {
    // List all projects
    Route::get('/', [ProjectController::class, 'index']);

    // Create a new project
    Route::post('/', [ProjectController::class, 'store']);

    // View a specific project
    Route::get('/{project}', [ProjectController::class, 'show']);

    // Update project information 
    Route::patch('/{project}', [ProjectController::class, 'update']);

    // Delete a project
    Route::delete('/{project}', [ProjectController::class, 'destroy']);

    // Approve a project 
    Route::patch('/{project}/approve', [ProjectController::class, 'approve']);

    // Reject a project 
    Route::patch('/{project}/reject', [ProjectController::class, 'reject']);
  });

  // Talent Profile Management Routes
  Route::prefix('talents')->group(function () {
    // List all talent profiles
    Route::get('/', [TalentProfileController::class, 'index']);

    // Create a talent profile
    Route::post('/{user}', [TalentProfileController::class, 'store']);

    // View a specific talent profile
    Route::get('/{talent}', [TalentProfileController::class, 'show']);

    // Update talent profile information 
    Route::patch('/{talent}', [TalentProfileController::class, 'update']);

    // Delete a talent profile
    Route::delete('/{talent}', [TalentProfileController::class, 'delete']);

    // Approve a talent profile 
    Route::patch('/{talent}/approve', [TalentProfileController::class, 'approve']);

    // Reject a talent profile 
    Route::patch('/{talent}/reject', [TalentProfileController::class, 'reject']);
  });

  // Company Profile Management Routes
  Route::prefix('companies')->group(function () {
    // List all company profiles
    Route::get('/', [CompanyProfileController::class, 'index']);

    // Create a company profile
    Route::post('/{user}', [CompanyProfileController::class, 'store']);

    // View a specific company profile
    Route::get('/{company}', [CompanyProfileController::class, 'show']);

    // Update company profile information 
    Route::patch('/{company}', [CompanyProfileController::class, 'update']);

    // Delete a company profile
    Route::delete('/{company}', [CompanyProfileController::class, 'delete']);

    // Approve a company profile 
    Route::patch('/{company}/approve', [CompanyProfileController::class, 'approve']);

    // Reject a company profile 
    Route::patch('/{company}/reject', [CompanyProfileController::class, 'reject']);
  });

  // Application Management Routes
  Route::prefix('applications')->group(function () {
    // List all applications
    Route::get('/', [ApplicationController::class, 'index']);

    // List job applications made by talents
    Route::get('/jobs', [ApplicationController::class, 'jobApplications']);

    // List project applications made by talents
    Route::get('/projects', [ApplicationController::class, 'projectApplications']);

    // Apply for a job
    Route::post('/jobs/{job}', [ApplicationController::class, 'applyForJob']);

    // Apply for a project
    Route::post('/projects/{project}', [ApplicationController::class, 'applyForProject']);

    // Delete an application
    Route::delete('/{application}', [ApplicationController::class, 'destroy']);
  });

  // Message Management Routes
  // Get all conversations
  Route::get('/conversations', [MessageController::class, 'conversations']);
  // Get all messages
  Route::get('/messages', [MessageController::class, 'messages']);
  // Delete a conversation
  Route::delete('/messages/{message}', [MessageController::class, 'destroyMessage']);
  // Delete a message
  Route::delete('/conversation/{conversation}', [MessageController::class, 'destroyConversation']);

  // Payment Management Routes
  Route::get('/payments', [PaymentController::class, 'index']);
  Route::get('/payments/{payment}', [PaymentController::class, 'show']);
  Route::delete('/payments/{payment}', [PaymentController::class, 'destroy']);
});
