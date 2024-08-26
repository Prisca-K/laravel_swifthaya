<x-app-layout>
  <div class="flex flex-col h-full">
    <div class="flex-1 p-4">
      <div class="flex items-center justify-between">
        <div class="flex items-center">
          <img
            src="{{ $activeConversation->recipient->userprofile->profile_photo ?? 'default-avatar.png' }}"
            alt="Profile Photo"
            class="w-10 h-10 rounded-full">
          <div class="ml-4">
            <h2 class="text-xl font-semibold text-gray-900">
              {{
              $activeConversation->recipient->userprofile->first_name
              }} {{
              $activeConversation->recipient->userprofile->last_name
              }}
            </h2>
            <p class="text-sm text-gray-600">{{
              $activeConversation->recipient->email }}</p>
          </div>
        </div>
      </div>

      <div
        class="mt-6 h-96 overflow-y-auto bg-white shadow-sm rounded-lg p-4">
        @foreach($activeConversation->messages as $message)
        <div class="mb-4">
          <div
            class="flex {{ $message->user_id === auth()->id() ? 'justify-end' : '' }}">
            <div
              class="bg-{{ $message->user_id === auth()->id() ? 'blue-500' : 'gray-200' }} p-3 rounded-lg max-w-xs">
              <p
                class="text-{{ $message->user_id === auth()->id() ? 'white' : 'gray-800' }}">
                {{ $message->content }}</p>
              <span class="text-xs text-gray-400">{{
                $message->created_at->diffForHumans()
                }}</span>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>

    <div class="bg-white border-t p-4 flex items-center">
      <form action="{{ route('messages.store') }}"
        method="POST" class="flex-grow">
        @csrf
        <input type="hidden" name="conversation_id"
          value="{{ $activeConversation->id }}">
        <input type="text" name="message"
          class="w-full rounded-full px-4 py-2 border border-gray-300 focus:outline-none focus:ring focus:ring-blue-300"
          placeholder="Type your message here...">
      </form>
      <button type="submit"
        class="ml-4 bg-blue-500 text-white px-4 py-2 rounded-full hover:bg-blue-600 focus:outline-none">
        Send
      </button>
    </div>
  </div>
</x-app-layout>