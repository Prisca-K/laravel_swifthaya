<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between items-center">
      <h2
        class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Individual Dashboard') }}
      </h2>
      <a href="{{Route("profile.edit")}}">
        <img class="w-12 h-12 object-cover rounded-full" src="{{Auth::user()->userprofile->getImgUrl()}}" alt="">
      </a>
    </div>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div
        class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div
          class="p-6 text-gray-900 dark:text-gray-100 flex justify-evenly items-center">
          <p>{{ __("You're logged in!") }}</p>
          <a class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            href="{{Route("project.create")}}">
            Post Project
          </a>

          <a href="{{ Route("conversations.index") }}"
            class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Messages
          </a>
          <a class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            href="{{Route("talent_search")}}">
            Find Talents
          </a>
        </div>

      </div>
    </div>
  </div>
  @if ($projects)
  <h2
    style="font-size:1.5rem; text-align:center;margin-top:1rem">
    My Projects
  </h2>
  <div class="py-12">
    <div style="max-width:80%; background-color:rgba(128, 128,
      128, 0.27); display:flex; flex-wrap:wrap"
      class=" mx-auto p-6 items-center justify-center gap-4">
      @forelse ($projects as $project)
      <div style="min-width: 20rem; max-width: 20rem"
        class="bg-white shadow-sm sm:rounded-lg flex items-center justify-center flex-col p-6">
        <div class="p-6 text-wrap">
          <h3 style="font-size:1.2rem;">{{$project->title}}
          </h3>
          <p>Description: {{$project->description}}</p>
          <p>Required Skills: {{$project->required_skills}}
          </p>
          <p>Budget: {{$project->budget}}</p>
          <p>Duration: {{$project->duration}}</p>
          <p>Deadline: {{$project->deadline_date}}</p>
        </div>

        <a class="flex justify-center items-center px-20"
          href="{{Route("project.show", $project->id)}}"
          style="border: 2px solid gray;
          height:3rem; border-radius:5px;">View Project
        </a>
      </div>
      @empty
      <p>No Projects Posted Yet</p>
      @endforelse
    </div>
  </div>
  @endif
</x-app-layout>