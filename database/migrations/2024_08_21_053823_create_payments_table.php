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
    Schema::create('payments', function (Blueprint $table) {

      $table->id();
      $table->foreignId('user_id')->constrained()->cascadeOnDelete();
      $table->string('payment_reference')->unique();
      $table->enum('payer_type', ['talent', 'individual', 'company', 'admin']);
      $table->foreignId('swifthayajob_id')->nullable()->constrained('swifthayajobs')->cascadeOnDelete();
      $table->foreignId('project_id')->nullable()->constrained('projects')->cascadeOnDelete();
      $table->enum('payment_status', ['pending', 'completed', 'failed']);
      $table->decimal('amount', 15, 2);
      $table->decimal('platform_fee', 15, 2);
      $table->decimal('net_amount', 15, 2);
      $table->string('currency')->default('NGN');
      $table->string('payment_method')->default('Paystack');
      $table->timestamp('payment_date')->useCurrent();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('payments');
  }
};
