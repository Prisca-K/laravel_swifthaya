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
        <div class="p-6 text-gray-900 dark:text-gray-100">
          {{ __("You're logged in!") }}
        </div>
        @if ($talent_profile)
        <a class="flex justify-center items-center"
          href="{{Route("talent.show", [$user_profile->id])}}"
          style="border: 2px solid gray; padding:5px; height:3rem; border-radius:5px; margin-right: 2rem">View Profile
        </a>
        @else
       
        <a class="flex justify-center items-center"
          href="{{Route("talent.create", $user_profile->id)}}"
          style="border: 2px solid gray; padding:5px; height:3rem; border-radius:5px; margin-right: 2rem">Create
          Profile
        </a>
        @endif
        <a class="flex justify-center items-center" 
        href="{{Route("profile.edit", $user_profile->id)}}"
        style="border: 2px solid gray; padding:5px;
        height:3rem; border-radius:5px; margin-right:
        2rem">Profile
      </a>
      <a class="flex justify-center items-center" 
      href="{{Route("find_jobs")}}"
      style="border: 2px solid gray; padding:5px;
      height:3rem; border-radius:5px; margin-right:
      2rem">Find Jobs
      </a>
      <a class="flex justify-center items-center" 
      href="{{Route("find_projects")}}"
      style="border: 2px solid gray; padding:5px;
      height:3rem; border-radius:5px; margin-right:
      2rem">Find projects
      </a>
      </div>
    </div>
  </div>


</x-app-layout>