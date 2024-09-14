<x-app-layout>
  <div class="min-h-screen bg-gray-100 p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-semibold">Payment Management</h1>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
            <strong class="font-bold">{{ session('success') }}</strong>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md p-4">
        <table class="min-w-full table-auto">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2">User</th>
                    <th class="px-4 py-2">Amount</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $payment)
                    <tr>
                        <td class="border px-4 py-2">{{ $payment->user->userprofile->first_name . " " . $payment->user->userprofile->last_name }}</td>
                        <td class="border px-4 py-2">₦{{ $payment->amount }}</td>
                        <td class="border px-4 py-2">{{ $payment->payment_status }}</td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('admin.payments.show', $payment->id) }}" class="text-blue-600 hover:text-blue-900">View</a>
                            <form action="{{ route('admin.payments.destroy', $payment->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 ml-4">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-6">
            {{ $payments->links() }}
        </div>
    </div>
</div>d
</x-app-layout>