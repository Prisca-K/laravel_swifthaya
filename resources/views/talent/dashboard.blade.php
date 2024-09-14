<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between items-center">
      <h2
        class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Talent Dashboard') }}
      </h2>
      <a href="{{Route("profile.edit")}}">
        <img class="w-12 h-12 object-cover rounded-full" src="{{Auth::user()->userprofile->getImgUrl()}}" alt="">
      </a>
    </div>

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
          href="{{Route("talent.show")}}"
          >Talent Profile
        </a>
          <a href="{{ Route("project.application_history") }}"
          class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
          Project Application history
          </a>
          <a href="{{ Route("job.application_history") }}"
          class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
          Job Application history
          </a>
          <a href="{{ Route("tracking.index") }}"
          class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
          Job / Project Tracker
          </a>
          <a href="{{ Route("conversations.index") }}"
          class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
          Messages
          </a>
        @else
       
        <a class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          href="{{Route("talent.create")}}">
          Create
          Profile
        </a>
        @endif
      <a 
        class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" 
        href="{{Route("job_search")}}">
        Find Jobs
      </a>
      <a class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-4" 
      href="{{Route("project_search")}}">
      Find projects
      </a>
      </div>
    </div>
  </div>


</x-app-layout>