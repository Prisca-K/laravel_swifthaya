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
    Schema::create('applications', function (Blueprint $table) {
      $table->id();
      $table->foreignId('applicant_id')->constrained('users')->cascadeOnDelete();
      $table->foreignId('swifthayajob_id')->nullable()->constrained('swifthayajobs')->cascadeOnDelete();
      $table->foreignId('project_id')->nullable()->constrained('projects')->cascadeOnDelete();
      $table->text('cover_letter')->nullable();
      $table->string('attachments')->nullable();
      $table->enum('status', ['Pending', 'Accepted', 'Rejected'])->default('Pending');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('applications');
  }
};
