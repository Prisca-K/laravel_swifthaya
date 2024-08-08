<x-app-layout>
  <x-slot name="header">
    <h2
      class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Talent Dashboard') }}
    </h2>
    <h3>{{$user_profile->first_name}}</h3>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div
        class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex justify-between items-center">
      </div>
    </div>
  </div>
  <div style="margin-left: 2rem" class="profile">
    <h2>{{$user_profile->first_name . " " .
      $user_profile->last_name}}</h2>
    <p>Skills: {{$talent_profile->skills}}</p>
    <p>Education: {{$talent_profile->education}}</p>
    <p>Portfolio: {{$talent_profile->portfolio}}</p>
    @if ($talent_profile)
    <div class="flex w-10 mt-3">
      <a class="flex justify-center items-center"
        href="{{Route("talent.edit",[$talent_profile->id])}}"
        style="border: 2px solid gray; padding:5px;
        height:3rem; width:fit-content; border-radius:5px;
        margin-right:
        2rem">Edit
        Profile
      </a>
      <form method="post" action="{{Route("talent.delete",[$talent_profile->id])}}">
        @csrf
        @method("delete")
        <button class="flex justify-center items-center"
          style="border: 2px solid gray; padding:5px;
        height:3rem; border-radius:5px; margin-right:
        2rem">Delete
          Profile
        </button>

      </form>
    </div>
    @endif
  </div>

</x-app-layout>