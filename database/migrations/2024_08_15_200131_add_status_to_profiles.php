<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up()
  {
    Schema::table('users', function (Blueprint $table) {
      $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('created_at');
    });

    Schema::table('talent_profiles', function (Blueprint $table) {
      $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('created_at');
    });

    Schema::table('company_profiles', function (Blueprint $table) {
      $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('created_at');
    });
    Schema::table('swifthayajobs', function (Blueprint $table) {
      $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('created_at');
    });
    Schema::table('projects', function (Blueprint $table) {
      $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('created_at');
    });
  }

  public function down()
  {
    Schema::table('users', function (Blueprint $table) {
      $table->dropColumn('status');
    });

    Schema::table('talent_profiles', function (Blueprint $table) {
      $table->dropColumn('status');
    });

    Schema::table('company_profiles', function (Blueprint $table) {
      $table->dropColumn('status');
    });
    Schema::table('swifthayajobs', function (Blueprint $table) {
      $table->dropColumn('status');
    });
    Schema::table('projects', function (Blueprint $table) {
      $table->dropColumn('status');
    });
  }
};
