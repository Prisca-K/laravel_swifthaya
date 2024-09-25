<?php

use App\Http\Controllers\API\V1\MessageController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', "can:company"])->group(function () {
  // Get all conversations for the authenticated user
  Route::get("/conversations", [MessageController::class, "conversations"]);

  // Get all messages for the authenticated user
  Route::get("/messages", [MessageController::class, "messages"]);


  // Send a message to a recipient
  Route::post("/messages/{recipient}", [MessageController::class, "store_conversation_and_message"]);
});

