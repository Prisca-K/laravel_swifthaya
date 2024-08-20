<x-app-layout>
  {{-- <div class="flex h-screen bg-gray-100">
    <!-- Conversations List -->
    <div class="w-1/4 bg-white border-r overflow-y-auto">
      <div class="p-4">
        <h2 class="text-xl font-semibold mb-4">Conversations
        </h2>
        <ul class="space-y-4">
          <!-- Single Conversation -->
          <li
            class="flex items-center space-x-3 p-2 hover:bg-gray-200 cursor-pointer">
            <img src="/path/to/profile.jpg" alt="Profile"
              class="w-12 h-12 rounded-full">
            <div>
              <h3 class="text-md font-semibold">John Doe
              </h3>
              <p class="text-sm text-gray-600 truncate">Last
                message preview goes here...</p>
            </div>
          </li>
          <!-- Repeat for each conversation -->
        </ul>
      </div>
    </div>

    <!-- Chat Window -->
    <div class="flex-1 flex flex-col bg-white">
      <!-- Chat Header -->
      <div class="px-6 py-4 border-b">
        <div class="flex items-center space-x-4">
          <img src="/path/to/active-profile.jpg"
            alt="Profile" class="w-12 h-12 rounded-full">
          <div>
            <h3 class="text-lg font-semibold">John Doe</h3>
            <p class="text-sm text-gray-500">Online</p>
          </div>
        </div>
      </div>

      <!-- Messages -->
      <div class="flex-1 p-6 overflow-y-auto space-y-4">
        <!-- Sender Message -->
        <div class="flex items-start space-x-3">
          <img src="/path/to/sender-profile.jpg"
            alt="Profile" class="w-10 h-10 rounded-full">
          <div class="bg-blue-100 p-3 rounded-lg">
            <p class="text-sm text-gray-800">Hey, how are
              you doing?</p>
            <span class="text-xs text-gray-500">10:30
              AM</span>
          </div>
        </div>
        <!-- Receiver Message -->
        <div class="flex items-start space-x-3 justify-end">
          <div class="bg-gray-100 p-3 rounded-lg">
            <p class="text-sm text-gray-800">I’m good,
              thanks! How about you?</p>
            <span class="text-xs text-gray-500">10:32
              AM</span>
          </div>
          <img src="/path/to/receiver-profile.jpg"
            alt="Profile" class="w-10 h-10 rounded-full">
        </div>
        <!-- Repeat for each message -->
      </div>

      <!-- Message Input -->
      <div class="border-t px-4 py-4 bg-gray-50">
        <form class="flex items-center space-x-4">
          <input type="text"
            class="flex-1 px-4 py-2 border rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Type a message...">
          <button type="submit"
            class="px-4 py-2 bg-blue-500 text-white rounded-full hover:bg-blue-600">Send</button>
        </form>
      </div>
    </div>
  </div> --}}

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
          <a href="{{ route('messages.show',[$conversation->id,$conversation->user->id]) }}"
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
          <a href="{{ route('messages.show',[$conversation->id,$conversation->recipient->id]) }}"
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
                    <form method="POST" action="{{ route('conversation.store', $candidate->id) }} " class="block px-4 py-2 text-gray-800 hover:bg-gray-100">
                      @csrf
                      <button type="submit" class="w-full">
                        {{ $candidate->userprofile->first_name }} {{ $candidate->userprofile->last_name }}
                      </button>
                    </form>
                @endforeach
              @endif
              @if ($checkProjectCandidates)
              @foreach ($projectCandidates as $candidate)
                    <form method="POST" action="{{ route('conversation.store', $candidate->id) }} " class="block px-4 py-2 text-gray-800 hover:bg-gray-100">
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
        Candidates have not applied to any job/project
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
    <!-- Input Message -->
    {{-- <div class="border-t border-gray-200 p-4">
      <form
        action="{{ route('messages.store',$recipient->id) }}"
        method="POST">
        @csrf
        <div class="flex items-center">
          <input type="hidden" name="conversation_id"
            value="{{$activeConversation->id}}">
          <input type="text" name="message"
            placeholder="Type a message..."
            class="flex-grow bg-gray-100 rounded-full p-3 mr-3 focus:outline-none">
          <button type="submit"
            class="bg-blue-500 text-white px-4 py-2 rounded-full hover:bg-blue-600 transition-colors duration-200">
            Send
          </button>
        </div>
      </form>
    </div> --}}

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
  {{-- <div class="flex h-screen">
    <!-- Conversations List -->
    <div class="w-1/3 border-r border-gray-200 bg-gray-50">
      <div class="p-4">
        <h2 class="text-xl font-semibold text-gray-800">
          Conversations</h2>
      </div>
      <ul>
        <li>
          <a href="#"
            class="block p-4 border-b border-gray-200 hover:bg-gray-100 transition-colors duration-200">
            <div class="flex items-center">
              <img src="https://via.placeholder.com/40"
                alt="John Doe"
                class="w-10 h-10 rounded-full mr-3">
              <div>
                <p class="text-gray-900 font-semibold">John
                  Doe</p>
                <p class="text-sm text-gray-500">Last
                  message from John...</p>
              </div>
            </div>
          </a>
        </li>
        <li>
          <a href="#"
            class="block p-4 border-b border-gray-200 hover:bg-gray-100 transition-colors duration-200">
            <div class="flex items-center">
              <img src="https://via.placeholder.com/40"
                alt="Jane Smith"
                class="w-10 h-10 rounded-full mr-3">
              <div>
                <p class="text-gray-900 font-semibold">Jane
                  Smith</p>
                <p class="text-sm text-gray-500">Last
                  message from Jane...</p>
              </div>
            </div>
          </a>
        </li>
      </ul>
    </div>

    <!-- Chat Window -->
    <div class="w-2/3 flex flex-col">
      <!-- Assuming John Doe's conversation is active -->
      <div class="flex-grow p-6 bg-white overflow-auto">
        <div class="flex items-center mb-4">
          <img src="https://via.placeholder.com/40"
            alt="John Doe"
            class="w-10 h-10 rounded-full mr-3">
          <h3 class="text-xl font-semibold text-gray-800">
            John Doe</h3>
        </div>
        <div id="chat-window" class="space-y-4">
          <div class="flex justify-end">
            <div
              class="bg-blue-500 text-white rounded-lg p-3 max-w-xs">
              <p>Hello John, how are you?</p>
              <span class="text-xs text-gray-300">2 hours
                ago</span>
            </div>
          </div>
          <div class="flex">
            <div
              class="bg-gray-200 text-gray-900 rounded-lg p-3 max-w-xs">
              <p>Hi! I'm doing great, thanks. How about you?
              </p>
              <span class="text-xs text-gray-500">1 hour
                ago</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Input Message -->
      <div class="border-t border-gray-200 p-4">
        <form action="#" method="POST">
          @csrf
          <div class="flex items-center">
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
  </div> --}}



  <script>
    document.getElementById('dropdownButton').addEventListener('click', function() {
        const dropdownMenu = document.getElementById('dropdownMenu');
        dropdownMenu.classList.toggle('hidden');
    });
</script>
</x-app-layout>