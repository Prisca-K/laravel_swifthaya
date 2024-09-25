<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{


  public function init()
  {
    // dd(request()->amount);
    $SECRET_KEY = env("PAYSTACK_SECRET_KEY");
    $url = "https://api.paystack.co/transaction/initialize";
    $amount = request()->amount;
    $fields = [
      'email' => Auth::user()->email,
      'callback_url' => route('payment.callback'),
      'amount' => $amount
    ];

    $fields_string = http_build_query($fields);

    //open connection
    $ch = curl_init();
    //set the url, number of POST vars, POST data
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Authorization: Bearer $SECRET_KEY",
      "Cache-Control: no-cache",
    ));

    //So that curl_exec returns the contents of the cURL; rather than echoing it
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //execute post
    $result = json_decode(curl_exec($ch), true);
    // dd($result->data->access_code);

    if ($result && $result['status']) {
      return response()->json([
        'status' => true,
        'message' => 'Payment initialized successfully',
        'data' => [
          'authorization_url' => $result['data']['authorization_url'],
          'access_code' => $result['data']['access_code'],
          'reference' => $result['data']['reference'],
        ],
      ], 200);
    } else {
      return response()->json(['status' => false, 'message' => 'Payment initialization failed'], 500);
    }
  }
  public function handleCallback()
  {
    // dd(request()->reference);
    $reference = request('reference');
    $SECRET_KEY = env("PAYSTACK_SECRET_KEY");
    if (!$reference) {
      return redirect()->route('payment.callback')->with('error', 'Payment reference not found.');
      // dd("Payment reference not found");
    }

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.paystack.co/transaction/verify/$reference",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "Authorization: Bearer $SECRET_KEY",
        "Cache-Control: no-cache",
      ),
    ));

    $response = json_decode(curl_exec($curl), true);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      return response()->json('Error', "cURL Error #:" . $err);
    }

    if (!$response['status'] || $response['data']['status'] !== 'success') {
      return response()->json(['status' => false, 'message' => 'Payment failed. please try agian'], 400);
    }

    // Calculate the net amount (after fees) and platform fee
    $grossAmount = $response['data']['amount'] / 100; // Convert back to Naira
    $platformFee = $grossAmount * 0.1; // Example: 10% platform fee
    $netAmount = $grossAmount - $platformFee;

    // Store payment record in the database
    // dd(Auth::user()->user_type);
    $payment = Payment::create([
      'user_id' => Auth::user()->id,
      'payer_type' => Auth::user()->user_type,
      'swifthaya_id' => 7, // If applicable
      // 'project_id'  //  
      'net_amount' => $netAmount,
      'amount' => $grossAmount,
      'currency' => $response['data']['currency'],
      'platform_fee' => $platformFee,
      'payment_status' => 'completed',
      'payment_method' => 'Paystack',
      'payment_reference' => $reference,
    ]);
    // dd($payment);
    // Redirect with success message including the platform fee details
    return [
      'status' => true,
      'message' => 'Payment verified successfully',
      'data' => new PaymentResource($payment)
    ];
  }


  public function transactionHistory()
  {
    $payments = Payment::where('user_id', Auth::id())->get();

    return response()->json([
      'status' => true,
      'message' => 'Transaction history retrieved successfully',
      'data' => $payments,
    ], 200);
  }

  public function refundPayment(Request $request)
  {
    $request->validate([
      'payment_reference' => 'required|string|exists:payments,payment_reference',
    ]);

    $SECRET_KEY = env("PAYSTACK_SECRET_KEY");
    $payment = Payment::where('payment_reference', $request->payment_reference)->first();

    $curl = curl_init();
    curl_setopt_array($curl, [
      CURLOPT_URL => "https://api.paystack.co/refund",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_POST => true,
      CURLOPT_POSTFIELDS => json_encode(['transaction' => $payment->payment_reference]),
      CURLOPT_HTTPHEADER => [
        "Authorization: Bearer $SECRET_KEY",
        "Content-Type: application/json",
      ],
    ]);

    $response = json_decode(curl_exec($curl), true);
    curl_close($curl);

    if ($response['status']) {
      $payment->update(['payment_status' => 'refunded']);
      return response()->json(['status' => true, 'message' => 'Payment refunded successfully'], 200);
    } else {
      return response()->json(['status' => false, 'message' => 'Refund failed'], 400);
    }
  }

  public function handleWebhook(Request $request)
  {
    $event = $request->event;

    switch ($event) {
      case 'charge.success':
        $reference = $request->data['reference'];
        $payment = Payment::where('payment_reference', $reference)->first();

        if ($payment) {
          $payment->update(['payment_status' => 'completed']);
        }
        break;

      case 'charge.failed':
        $reference = $request->data['reference'];
        $payment = Payment::where('payment_reference', $reference)->first();

        if ($payment) {
          $payment->update(['payment_status' => 'failed']);
        }
        break;

        // Add cases for other events like refunds, disputes, etc.
    }

    return response()->json(['status' => true], 200);
  }
}
