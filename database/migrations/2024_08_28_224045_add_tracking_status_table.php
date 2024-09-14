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
    Schema::table('projects', function (Blueprint $table) {
      $table->enum('tracking_status', ['pending', 'started', 'in_progress', 'completed'])->default('pending');
      $table->timestamp("start_date")->nullable()->after("tracking_status");
      $table->timestamp("completed_date")->nullable()->after("start_date");
    });
    Schema::table('swifthayajobs', function (Blueprint $table) {
      $table->enum('tracking_status', ['pending', 'started', 'in_progress', 'completed'])->default('pending');
      $table->timestamp("start_date")->nullable()->after("status");
      $table->timestamp("completed_date")->nullable()->after("start_date");
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('projects', function (Blueprint $table) {
      $table->dropColumn('tracking_status');
    });
    Schema::table('swifthayajobs', function (Blueprint $table) {
      $table->dropColumn('tracking_status');
    });
  }
};
