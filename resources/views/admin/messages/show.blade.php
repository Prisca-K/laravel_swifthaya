<x-app-layout>
  <div class="min-h-screen bg-gray-100 p-6">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-semibold">View Message</h1>
      <a href="{{ route('admin.messages') }}"
        class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">Back</a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-4">
      <div class="mb-4">
        <label
          class="block text-sm font-medium text-gray-700">Sender</label>
        <div class="mt-1">{{ $message->sender->userprofile->first_name . " " . $message->sender->userprofile->last_name}}</div>
      </div>

      <div class="mb-4">
        <label
          class="block text-sm font-medium text-gray-700">Receiver</label>
        <div class="mt-1">{{ $message->receiver->userprofile->first_name . " " . $message->receiver->userprofile->last_name }}
        </div>
      </div>

      <div class="mb-4">
        <label
          class="block text-sm font-medium text-gray-700">Message</label>
        <div class="mt-1">{{ $message->content }}</div>
      </div>

      <div class="flex justify-end">
        <form
          action="{{ route('admin.messages.destroy', $message->id) }}"
          method="POST">
          @csrf
          @method('DELETE')
          <button type="submit"
            class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">Delete
            Message</button>
        </form>
      </div>
    </div>
  </div>
</x-app-layout>