<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('projects', function (Blueprint $table) {
      $table->id();
      $table->foreignId('poster_id')->constrained('users')->cascadeOnDelete();
      $table->string('title');
      $table->text('description');
      $table->json('required_skills')->nullable();
      $table->decimal('budget', 15, 2)->nullable();
      $table->integer('duration')->nullable(); // Project duration in days
      $table->timestamps();
      $table->timestamp('posted_at')->nullable(); // Project posting date
      $table->timestamp('deadline_date')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('projects');
  }
};
