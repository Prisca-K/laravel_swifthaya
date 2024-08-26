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
      $table->string('status')->default('pending');
    });

    Schema::table('talent_profiles', function (Blueprint $table) {
      $table->string('status')->default('pending');
    });

    Schema::table('company_profiles', function (Blueprint $table) {
      $table->string('status')->default('pending');
    });
    Schema::table('swifthayajobs', function (Blueprint $table) {
      $table->string('status')->default('pending');
    });
    Schema::table('projects', function (Blueprint $table) {
      $table->string('status')->default('pending');
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
