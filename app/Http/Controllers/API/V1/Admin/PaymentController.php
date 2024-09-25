<?php

namespace App\Http\Controllers\API\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
  // Retrieve paginated list of payments
  public function index()
  {
    try {
      $payments = Payment::paginate(10);
      return PaymentResource::collection($payments);  // Returning a collection of PaymentResource
    } catch (Exception $e) {
      // Handle failure
      return response()->json([
        'message' => 'Failed to retrieve payments',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  // Retrieve a specific payment by ID
  public function show(Payment $payment)
  {
    try {
      return new PaymentResource($payment);  // Return a single payment resource
    } catch (Exception $e) {
      // Handle failure
      return response()->json([
        'message' => 'Failed to retrieve payment',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  // Delete a payment by ID
  public function destroy(Payment $payment)
  {
    DB::beginTransaction(); //start transaction
    try {
      $payment->delete();  // Delete payment record
      DB::commit(); //commit transaction
      return response()->json(['message' => 'Payment deleted successfully'], 204);  // 204 No Content for successful deletion
    } catch (Exception $e) {
      // Handle failure
      DB::rollBack(); // Rollback in case of failure
      return response()->json([
        'message' => 'Failed to delete payment',
        'error' => $e->getMessage()
      ], 500);
    }
  }
}
