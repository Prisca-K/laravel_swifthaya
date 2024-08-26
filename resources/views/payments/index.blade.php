<x-app-layout>
  <div
    class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md mt-10">
    <h2 class="text-2xl font-bold mb-6">Make a Test Payment
    </h2>


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

    <!-- Payment Form -->
    <form id="paymentForm" method="post" action="{{Route("payment.index")}}">
      @csrf
      {{-- <div class="mb-4">
        <label class="block text-gray-700"
          for="email">Email</label>
        <input type="email" id="email"
          class="form-input mt-1 block w-full"
          placeholder="Your email address" required>
      </div> --}}
      <div class="mb-4">
        <label class="block text-gray-700"
          for="amount">Amount(Naira)</label>
        <input type="number" id="amount"
          class="form-input mt-1 block w-full"
          placeholder="Amount to pay" name="amount" required>
      </div>

      <div class="mb-4">
        <button type="submit"
          class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
          Pay Now
        </button>
      </div>
    </form>
  </div>

 
</x-app-layout>