<x-app-layout>
  <div class="min-h-screen bg-gray-100 p-6">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-semibold">View Payment</h1>
      <a href="{{ route('admin.payments') }}"
        class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">Back</a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-4">
      <div class="mb-4">
        <label
          class="block text-sm font-medium text-gray-700">User</label>
        <div class="mt-1">{{ $payment->user->userprofile->first_name . " " . $payment->user->userprofile->last_name }}</div>
      </div>

      <div class="mb-4">
        <label
          class="block text-sm font-medium text-gray-700">Payer Type</label>
        <div class="mt-1">{{ucfirst( $payment->payer_type) }}</div>
      </div>
      <div class="mb-4">
        <label
          class="block text-sm font-medium text-gray-700">Amount</label>
        <div class="mt-1">₦{{ $payment->amount }}</div>
      </div>

      <div class="mb-4">
        <label
          class="block text-sm font-medium text-gray-700">Status</label>
        <div class="mt-1">{{ $payment->payment_status }}</div>
      </div>

      <div class="flex justify-end">
        <form
          action="{{ route('admin.payments.destroy', $payment->id) }}"
          method="POST">
          @csrf
          @method('DELETE')
          <button type="submit"
            class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">Delete
            Payment</button>
        </form>
      </div>
    </div>
  </div>
</x-app-layout>