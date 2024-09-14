<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
  public function index()
  {
    $payments = Payment::with('user')->paginate(10);
    return view('admin.payments.index', compact('payments'));
  }

  public function show(Payment $payment)
  {
    return view('admin.payments.show', compact('payment'));
  }

  public function destroy(Payment $payment)
  {
    $payment->delete();
    return redirect()->route('admin.payments')->with('success', 'Payment deleted successfully.');
  }
}
