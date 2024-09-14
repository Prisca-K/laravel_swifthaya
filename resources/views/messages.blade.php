<x-app-layout>
  <div class="flex h-screen">
    <!-- Conversations List -->
    <div class="w-1/3 border-r border-gray-200 bg-gray-50">
      <div class="p-4">
        <h2 class="text-xl font-semibold text-gray-800">
          Conversations</h2>
      </div>
      <ul>
        @forelse($conversations as $conversation)
        <li>
          @if ($conversation->recipient->id ===
          Auth::user()->id)
          <a href="{{ route('messages.show',[$conversation->user->id, $conversation->user->userprofile->first_name . $conversation->user->userprofile->last_name]) }}"
            class="block p-4 border-b border-gray-200 hover:bg-gray-100 transition-colors duration-200">
            <div class="flex items-center">
              <img
                src="{{ $conversation->user->userprofile->getImgUrl() }}"
                alt="{{ $conversation->user->userprofile->first_name. " " .$conversation->user->userprofile->last_name }}"
                class=" object-cover w-20 h-20 rounded-full mr-3">
              <div>
                <p class="text-gray-900 font-semibold">{{
                  $conversation->user->userprofile->first_name. " " .$conversation->user->userprofile->last_name
                  }}</p>
                <p class="text-sm text-gray-500">{{
                  $conversation->last_message }} Hey ther
                  i'm coming over</p>
              </div>
            </div>
          </a>
          @else
          <a href="{{ route('messages.show',[$conversation->recipient->id, $conversation->recipient->userprofile->first_name . $conversation->recipient->userprofile->last_name]) }}"
            class="block p-4 border-b border-gray-200 hover:bg-gray-100 transition-colors duration-200">
            <div class="flex items-center">
              <img
                src="{{ $conversation->recipient->userprofile->getImgUrl() }}"
                alt="{{ $conversation->recipient->userprofile->last_name }}"
                class=" object-cover w-20 h-20 rounded-full mr-3">
              <div>
                <p class="text-gray-900 font-semibold">{{
                  $conversation->recipient->userprofile->last_name
                  }}</p>
                <p class="text-sm text-gray-500">{{
                  $conversation->last_message }} Hey ther
                  i'm coming over</p>
              </div>
            </div>
          </a>
          @endif
        </li>
        @empty
        <p class="text-2xl text-center mt-10">No
          Conversations yet</p>
        @endforelse
      </ul>
      @if ($canMessage)
      @if ($checkCandidates)      
      <div class="w-full max-w-sm mx-auto mt-3">
        <div class="relative">
          <button id="dropdownButton" class="w-full bg-blue-500 text-white font-bold py-2 px-4 rounded inline-flex items-center">
            <span class="mr-2">Select a Candidate to start new conversation</span>
          </button>
          <div id="dropdownMenu" class="absolute hidden bg-white shadow-lg rounded w-full mt-1">
              @if ($checkJobCandidates)
                @foreach ($jobCandidates as $candidate)
                    <form method="POST" action="{{ route('conversations.store', $candidate->id) }} " class="block px-4 py-2 text-gray-800 hover:bg-gray-100">
                      @csrf
                      <button type="submit" class="w-full">
                        {{ $candidate->userprofile->first_name }} {{ $candidate->userprofile->last_name }}
                      </button>
                    </form>
                @endforeach
              @endif
              @if ($checkProjectCandidates)
              @foreach ($projectCandidates as $candidate)
                    <form method="POST" action="{{ route('conversations.store', $candidate->id) }} " class="block px-4 py-2 text-gray-800 hover:bg-gray-100">
                      @csrf
                      <button type="submit" class="w-full">
                        {{ $candidate->userprofile->first_name }} {{ $candidate->userprofile->last_name }}
                      </button>
                    </form>
                @endforeach
              @endif
            </div>
        </div>
      </div>
      @else
      <p class="text-center mt-3">
        @if (!$conversations)
        Candidates have not applied to any job/project
        @endif
      </p>
      @endif
    
    
    
      @if (session()->has('error'))
      <p class="text-center mt-3">
          {{ session('error') }}
      </p>
      @endif
      @else
      {{-- dissmisable --}}
        <div x-data="{ show: true }" x-show="show" x-transition class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative m-4" role="alert">
          <strong class="font-bold">Hello 👋</strong>
          <span class="block sm:inline">When your
            application is accepted the employer's message will
            appear here</span>
          <button @click="show = false" class="absolute top-0 bottom-0 right-0 px-4 py-3">
              <svg class="fill-current h-6 w-6 text-blue-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                  <title>Close</title>
                  <path d="M14.348 5.652a.5.5 0 00-.707 0L10 9.293 6.354 5.646a.5.5 0 10-.707.707l3.646 3.647-3.646 3.646a.5.5 0 00.707.707L10 10.707l3.646 3.646a.5.5 0 00.707-.707l-3.646-3.646 3.646-3.647a.5.5 0 000-.707z"/>
              </svg>
          </button>
      </div>
      @if (session()->has('error'))
      <p class="text-center mt-3">
          {{ session('error') }}
      </p>
      @endif
      @endif
    </div>

    <!-- Chat Window -->

    <div class="w-2/3 flex flex-col">
      @if($activeConversation)
      @if ($conversation->recipient->id ===
      Auth::user()->id)
      <div class="relative flex-grow p-6 bg-white overflow-auto">
        <div class="flex items-center mb-4">
          <img
            src="{{ $activeConversation->user->userprofile->getImgUrl() }}"
            alt="{{ $activeConversation->user->userprofile->last_name }}"
            class=" object-cover w-10 h-10 rounded-full mr-3">
          <h3 class="text-xl font-semibold text-gray-800">{{
            $activeConversation->user->userprofile->first_name. " " .$activeConversation->user->userprofile->last_name
            }}</h3>
        </div>
        {{-- chat window --}}
        <div id="chat-window" class="space-y-4">

          @foreach($activeConversation->LatestMessages as $message)
          <div
            class="flex {{ $message->sender_id == auth()->id() ? 'justify-end' : '' }}">
            <div
              class="{{ $message->sender_id == auth()->id() ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-900' }} rounded-lg p-3 max-w-xs">
              <p>{{ $message->content }}</p>
              <span class="text-xs text-gray-500"> {{
                $message->created_at->diffForHumans()
                }}</span>
            </div>
          </div>
          @endforeach
        </div>
        {{-- input --}}
        <div class="w-4/5 absolute bottom-10 border-t border-gray-200 p-4">
          <form
            action="{{ route('messages.store', $recipient->id) }}"
            method="POST">
            @csrf
            <div class="flex items-center">
              <input type="hidden" name="conversation_id"
                value="{{ $activeConversation->id }}">
              <input type="text" name="message"
                placeholder="Type a message..."
                class="flex-grow bg-gray-100 rounded-full p-3 mr-3 focus:outline-none">
              <button type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded-full hover:bg-blue-600 transition-colors duration-200">
                Send
              </button>
            </div>
          </form>
        </div>
      </div>
      @else
      <div class="relative flex-grow p-6 bg-white overflow-auto overflow-x-hidden">
        <div class="flex items-center mb-4">
          <img
            src="{{ $activeConversation->recipient->userprofile->getImgUrl() }}"
            alt="{{ $activeConversation->recipient->userprofile->last_name }}"
            class=" object-cover w-10 h-10 rounded-full mr-3">
          <h3 class="text-xl font-semibold text-gray-800">{{
            $activeConversation->recipient->userprofile->last_name
            }}</h3>
        </div>
        {{-- chat window --}}
        <div id="chat-window" class="space-y-4">

          @foreach($activeConversation->LatestMessages as $message)
          <div
            class="flex {{ $message->sender_id == auth()->id() ? 'justify-end' : '' }}">
            <div
              class="{{ $message->sender_id == auth()->id() ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-900' }} rounded-lg p-3 max-w-xs">
              <p>{{ $message->content }}</p>
              <span class="text-xs text-gray-500"> {{
                $message->created_at->diffForHumans()
                }}</span>
            </div>
          </div>
          @endforeach
        </div>
        <div class="w-4/5 absolute bottom-10 border-t border-gray-200 p-4">
          <form
            action="{{ route('messages.store', $recipient->id) }}"
            method="POST">
            @csrf
            <div class="flex items-center">
              <input type="hidden" name="conversation_id"
                value="{{ $activeConversation->id }}">
              <input type="text" name="message"
                placeholder="Type a message..."
                class="flex-grow bg-gray-100 rounded-full p-3 mr-3 focus:outline-none">
              <button type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded-full hover:bg-blue-600 transition-colors duration-200">
                Send
              </button>
            </div>
          </form>
        </div>
      </div>
      {{-- input --}}

    @endif


    @else
    <div
      class="flex-grow flex items-center justify-center bg-white">
      <p class="text-gray-500">Select a conversation to
        start chatting.</p>
    </div>
    @endif


    {{-- new conversation --}}

  </div>
  </div>




  <script>
    document.getElementById('dropdownButton').addEventListener('click', function() {
        const dropdownMenu = document.getElementById('dropdownMenu');
        dropdownMenu.classList.toggle('hidden');
    });
</script>
</x-app-layout>