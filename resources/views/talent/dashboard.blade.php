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
        <a class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          href="{{Route("talent.show", [$user_profile->id])}}"
          >View Profile
        </a>
          <a href="{{ Route("talent.project.apply.history", Auth::user()->id) }}"
          class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
          Project Application history
          </a>
          <a href="{{ Route("talent.job.apply.history", Auth::user()->id) }}"
          class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
          Job Application history
          </a>
          <a href="{{ Route("messages.index") }}"
          class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
          Messages
          </a>
        @else
       
        <a class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          href="{{Route("talent.create", $user_profile->id)}}">
          Create
          Profile
        </a>
        @endif
        <a class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" 
        href="{{Route("profile.edit", $user_profile->id)}}">
        Profile
      </a>
      <a 
        class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" 
        href="{{Route("find_jobs")}}">
        Find Jobs
      </a>
      <a class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-4" 
      href="{{Route("find_projects")}}">
      Find projects
      </a>
      </div>
    </div>
  </div>


</x-app-layout>