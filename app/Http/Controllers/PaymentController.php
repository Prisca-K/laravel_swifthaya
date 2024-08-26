<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{

  public function init()
  {
    return view("payments.index");
  }

  public function index()
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
    $result = json_decode(curl_exec($ch));
    // dd($result->data->access_code);
    $data = false;
    $access_code = false;
    $reference = false;
    if ($result) {
      $data = true;
      $reference = $result->data->reference;
      $access_code = $result->data->access_code;
      // dd($result);
    }
    return view("payments.processing", compact("access_code", "reference", "data", "amount"));
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
      return redirect()->route('payment.init')->with('error', "cURL Error #:" . $err);
      // dd("cURL Error #:" );
    }

    // $paymentDetails = $paymentDetails->json();
    // dd($response['data']['amount']);

    if ($response['status'] && $response['data']['status'] == 'success') {
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
        'platform_fee' => $platformFee,
        'currency' => $response['data']['currency'],
        'payment_status' => 'completed',
        'payment_method' => 'Paystack',
        'payment_reference' => $reference,
      ]);
      // dd($payment);
      // Redirect with success message including the platform fee details
      return redirect()->route('payment.init')->with('success', 'Payment successful. Platform fee: ₦' . number_format($platformFee, 2));
    } else {
      return redirect()->route('payment.init')->with('error', 'Payment failed. Please try again.');
    }












    // if (!$reference) {
    //   // return redirect()->route('payment.index')->with('error', 'Payment reference not found.');
    //   dd("Payment reference not found");
    // }

    // // Verify payment with Paystack's test secret key
    // $paymentDetails = Http::withHeaders([
    //   'Authorization' => 'Bearer ' . env('PAYSTACK_SECRET_KEY'),
    // ])->get('https://api.paystack.co/transaction/verify/' . $reference);

    // $paymentDetails = $paymentDetails->json();
    // dd($paymentDetails["data"]["status"]);

    // if ($paymentDetails['status'] && $paymentDetails['data']['status'] == 'success') {
    //   // Calculate the net amount (after fees) and platform fee
    //   $grossAmount = $paymentDetails['data']['amount'] / 100; // Convert back to Naira
    //   $platformFee = $grossAmount * 0.1; // Example: 10% platform fee
    //   $netAmount = $grossAmount - $platformFee;

    //   // Store payment record in the database
    //   dd($reference);
    //   $payment = Payment::create([
    //     'user_id' => Auth::user()->id,
    //     'payer_type' => Auth::user()->user_type,
    //     'job_id' => 7, // If applicable
    //     // 'project_id' => session('project_id'), // If applicable
    //     'net_amount' => $netAmount,
    //     'amount' => $grossAmount,
    //     'platform_fee' => $platformFee,
    //     'currency' => $paymentDetails['data']['currency'],
    //     'payment_status' => 'completed',
    //     'payment_method' => 'Paystack',
    //     'payment_reference' => $reference,
    //   ]);
    //   dd($payment);
    //   // Redirect with success message including the platform fee details
    //   return redirect()->route('payment.index')->with('success', 'Payment successful. Platform fee: ₦' . number_format($platformFee, 2));
    // } else {
    //   return redirect()->route('payment.index')->with('error', 'Payment failed. Please try again.');
    // }
  }

  public function handleWebhook() {}
}
