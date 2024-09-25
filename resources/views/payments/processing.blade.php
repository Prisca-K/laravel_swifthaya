<x-app-layout>
  <div
    class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md mt-10">
    <h1 class="mb-2 text-2xl">Processsing Payment</h1>

    @if (session('success'))
    <div
      class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6"
      role="alert">
      <strong class="font-bold">{{ session('success')
        }}</strong>
    </div>
    @elseif(session('error'))
    <div
      class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6"
      role="alert">
      <strong class="font-bold">{{ session('error')
        }}</strong>
    </div>
    @endif
    
    <form id="paymentForm">
      @csrf
      {{-- <div class="mb-4">
        <label class="block text-gray-700"
          for="email">Email</label>
        <input type="email" id="email"
          class="form-input mt-1 block w-full"
          placeholder="Your email address" required>
      </div> --}}
      @if ($data)
      {{-- {{dd($amount)}} --}}
      <input id="reference"
        class="form-input mt-1 block w-full"
        name="reference" type="hidden"
        value="{{$reference}}">


      <input id="access_code"
        class="form-input mt-1 block w-full"
        name="access_code" type="hidden"
        value="{{$access_code}}">

      <div class="mb-4">
        <button type="button" onclick="payWithPaystack()"
          class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
          Pay Now
        </button>
      </div>
      @else
      <h2 class="mb-2">Transaction Failed(Check internet
        connection)</h2>
      @endif

    </form>

  </div>

  <script>
    const reference = document.getElementById('reference').value;
    function payWithPaystack() {
        const paystack = new PaystackPop();
        paystack.newTransaction({
            key: "{{env('PAYSTACK_PUBLIC_KEY')}}", // Replace with your public key
            email:"{{Auth::user()->email}}", // Replace with customer's email
            amount: {{$amount}} * 100, // Amount in kobo
            currency: "NGN", 
            onSuccess: function(transaction) {
              // Transaction was successful
              console.log("Transaction successful:", transaction);
              // alert(transaction);
              window.location.href = "{{ route('payment.callback') }}?reference=" + transaction.reference;
            },
            onLoad: function(response) {
              // Transaction is loaded
              console.log("Transaction loaded:", response);
            },
            onCancel: function() {
              // Transaction was canceled
              console.log("Transaction canceled");
              alert('Transaction was canceled.');
            },
            onError: function(error) {
              // Error occurred during transaction
              console.log("Error:", error.message);
              alert('An error occurred while processing the transaction.');
            }
        });
    }
  </script>

</x-app-layout>