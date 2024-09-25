<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use Exception;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{

  public function init(Request $request)
  {
    DB::beginTransaction();  // Start the transaction

    try {
      $SECRET_KEY = env("PAYSTACK_SECRET_KEY");
      $url = "https://api.paystack.co/transaction/initialize";

      // Ensure amount is multiplied to kobo (if applicable)
      $amount = $request->amount * 100;  // Convert to kobo

      $fields = [
        'email' => Auth::user()->email,
        'amount' => $amount
      ];

      $fields_string = http_build_query($fields);

      // Open connection using cURL
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Authorization: Bearer $SECRET_KEY",
        "Cache-Control: no-cache",
      ));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // Get response

      // Execute post and get the result
      $result = json_decode(curl_exec($ch), true);

      if ($result && $result['status']) {
        // Store the payment in the database with a 'pending' status
        Payment::create([
          'user_id' => Auth::user()->id,
          'payment_reference' => $result['data']['reference'],
          'payer_type' => Auth::user()->user_type,
          'net_amount' => 0.00,
          'amount' => $amount / 100,
          'currency' => "NGN",
          'platform_fee' => 0.00,
          'payment_status' => 'pending',
          'payment_method' => 'Paystack',
        ]);

        DB::commit();  // Commit the transaction if successful

        // Return response to the client
        return response()->json([
          'status' => true,
          'authorization_url' => $result['data']['authorization_url'],
          'reference' => $result['data']['reference'],
        ], 200);
      } else {
        throw new \Exception('Payment initialization failed');  // Custom error handling
      }
    } catch (\Exception $e) {
      DB::rollBack();  // Rollback the transaction if something fails
      Log::error('Payment Initialization Error: ' . $e->getMessage());

      return response()->json(['status' => false, 'message' => 'Payment initialization failed'], 500);
    }
  }


  public function transactionHistory()
  {
    try {
      $payments = Payment::where('user_id', Auth::id())->get();

      return response()->json([
        'status' => true,
        'message' => 'Transaction history retrieved successfully',
        'data' => $payments,
      ], 200);
    } catch (Exception $e) {
      DB::rollBack(); // Rollback in case of failure
      return response()->json(['message' => 'Failed to retrieve Payment history', 'error' => $e->getMessage()], 500);
    }
  }

  public function refundPayment(Request $request)
  {
    // Begin database transaction
    DB::beginTransaction();

    try {

      // make sure the request returns valid data
      $validated = $request->validate([
        "reference" => "required",
        "amount" => "integer"
      ]);

      // Get the payment reference from the request
      $paymentReference = $validated["reference"];
      // return $paymentReference;
      // Retrieve the payment from the database
      $payment = Payment::where('payment_reference', $paymentReference)->first();
      if (!$payment) {
        return response()->json([
          "message" => "Payment does not exist"
        ]);
      }
      // Ensure that the payment status is completed before issuing a refund
      // if full refund
      if ($payment->payment_status === 'fully-refunded') {
        throw new \Exception("Nothing to refund: Payment has already been fully refunded.");
      }

      if ($payment->payment_status !== 'completed' && $payment->payment_status !== 'refunded') {
        throw new \Exception("Payment cannot be refunded because it is not completed.");
      }

      if ($request->has("amount")) {
        $amount = $validated["amount"] * 100;
      } else $amount = $payment->amount * 100;

      // Prepare Paystack Refund API call
      $SECRET_KEY = env('PAYSTACK_SECRET_KEY');
      $url = "https://api.paystack.co/refund";

      // Paystack Refund parameters
      $fields = [
        'transaction' => $paymentReference,  // The reference of the transaction to refund
        'amount' => $amount
      ];

      // Open connection using cURL
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Authorization: Bearer $SECRET_KEY",
        "Cache-Control: no-cache",
      ));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      // Execute cURL request
      $response = json_decode(curl_exec($ch), true);
      curl_close($ch);
      Log::info('Refund request initiated:', ['response' => $response]);

      // Check if the refund was successful
      if ($response && $response['status']) {
        // Update the payment record in the database
        $payment->update([
          'payment_status' => 'refunded',
        ]);

        DB::commit(); // Commit transaction

        return response()->json([
          'status' => true,
          'message' => 'Refund successful',
          'refund_reference' => $response["data"]["transaction"]["reference"],
        ], 200);
      } else {
        throw new \Exception('Refund failed: ' . $response['message']);
      }
    } catch (\Exception $e) {
      DB::rollBack(); // Rollback the transaction if something fails
      Log::error('Refund Error: ' . $e->getMessage());

      return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
    }
  }


  public function handleWebhook(Request $request)
  {
    DB::beginTransaction();  // Start the transaction

    try {
      // Log the incoming request
      Log::info('Webhook received:', $request->all());

      // Ensure this is a POST request with the Paystack signature
      if ((strtoupper($_SERVER['REQUEST_METHOD']) != 'POST') || !array_key_exists('HTTP_X_PAYSTACK_SIGNATURE', $_SERVER)) {
        throw new \Exception('Invalid request');
      }

      // Retrieve the raw request body (the payload)
      $input = @file_get_contents("php://input");

      // Define your Paystack secret key
      $SECRET_KEY = env('PAYSTACK_SECRET_KEY');

      // Validate the signature to ensure the event is from Paystack
      if ($_SERVER['HTTP_X_PAYSTACK_SIGNATURE'] !== hash_hmac('sha512', $input, $SECRET_KEY)) {
        throw new \Exception('Invalid signature');
      }

      // Acknowledge the webhook (return 200 OK immediately)
      http_response_code(200);

      // Parse the JSON event payload as an object
      $event = json_decode($input);

      // Handle the event (e.g., charge.success)
      if ($event->event === 'charge.success') {
        $reference = $event->data->reference;
        $payment = Payment::where('payment_reference', $reference)->first();

        if ($payment) {
          // Update the payment status
          // Calculate the net amount (after fees) and platform fee
          $grossAmount = $event->data->amount / 100; // Convert back to Naira
          $platformFee = $grossAmount * 0.1; // Example: 10% platform fee
          $netAmount = $grossAmount - $platformFee;

          // Store payment record in the database
          $payment->update([
            'net_amount' => $netAmount,
            'amount' => $grossAmount,
            'platform_fee' => $platformFee,
            'currency' => $event->data->currency,
            'payment_status' => 'completed',  // Update the status to completed
            'payment_method' => 'Paystack',
          ]);
        }
      }

      DB::commit();  // Commit the transaction if successful
    } catch (\Exception $e) {
      DB::rollBack();  // Rollback the transaction if something fails
      Log::error('Webhook handling error: ' . $e->getMessage());

      return response()->json(['error' => $e->getMessage()], 400);
    }

    // Exit after processing the event
    exit();
  }

  public function markExpiredPayments()
  {
    $expiredPayments = Payment::where('payment_status', 'pending')
      ->where('created_at', '<', now()->subHours(1))  // Set the expiration time, e.g., 24 hours
      ->get();

    foreach ($expiredPayments as $payment) {
      $payment->update([
        'payment_status' => 'expired',
      ]);
    }

    Log::info("Expired payments marked as expired: " . $expiredPayments->count());
  }
}
