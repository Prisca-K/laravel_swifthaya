<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between items-center">
      <h2
        class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Company Dashboard') }}
      </h2>
      <a href="{{Route("profile.edit")}}">
        <img class="w-12 h-12 object-top object-cover rounded-full" src="{{Auth::user()->userprofile->getImgUrl()}}" alt="">
      </a>
    </div>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div
        class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex items-center justify-evenly">
        <div class="p-6 text-gray-900 dark:text-gray-100">
          {{ __("You're logged in!") }}
        </div>
        @if ($user_profile->companyprofile)
          <a class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            href="{{Route("job.create")}}"
            >Post Job
          </a>
          <a class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            href="{{Route("project.create")}}"
            >Post Project
          </a>
          <a href="{{ Route("conversations.index") }}"
          class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
          Messages
          </a>
          <a class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            href="{{Route("jobs")}}">
          My Jobs
          </a>
          
        @else
        <a class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          href="{{Route("company.create")}}">
        Create Profile
        </a>
        @endif

        <a class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" 
        href="{{Route("talent_search")}}">
        Find Talents
        </a>
      </div>
    </div>

  </div>
  @if ($jobs)
  <h2
    style="font-size:1.5rem; text-align:center;margin-top:1rem">
    My Jobs
  </h2>
  <div class="bg-white rounded-lg shadow-md p-4 mx-12 overflow-x-scroll">
    <table class="min-w-full table-auto">
      <thead class="bg-gray-200">
        <tr>
          <th class="px-4 py-2">Title</th>
          <th class="px-4 py-2">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($jobs as $job)
        <tr>
          <td class="border px-4 py-2">
          {{ $job->title }}
          </td>

          <td class="border px-4 py-2">
            <a href="{{ route('job.show', $job->id) }}"
              class="text-blue-600 hover:text-blue-900 mr-3">View Job
            </a>
          </td>
        </tr>
        @empty
        <tr>
          <td class="text-2xl">
            No Job created Yet
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>

    <div class="mt-6">
      {{-- {{ $jobs->links() }} --}}
    </div>
  </div>
  @endif
  @if ($projects)
  <h2
    style="font-size:1.5rem; text-align:center;margin-top:1rem">
    My Projects
  </h2>
  <div class="bg-white rounded-lg shadow-md p-4 mb-10 mx-12 overflow-x-scroll">
    <table class="min-w-full table-auto">
      <thead class="bg-gray-200">
        <tr>
          <th class="px-4 py-2">Title</th>
          <th class="px-4 py-2">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($projects as $project)
        <tr>
          <td class="border px-4 py-2">{{ $project->title
            }}
          </td>

          <td class="border px-4 py-2">
            <a href="{{ route('project.show', $project->id) }}"
              class="text-green-600 hover:text-green-900 mr-3">View project
            </a>
          </td>
        </tr>
        @empty
        <tr>
          <td><p class="text-2xl">No Projects Posted</p></td>
        </tr>
        
        @endforelse
      </tbody>
    </table>

    <div class="mt-6">
      {{-- {{ $projects->links() }} --}}
    </div>
  </div>
  @endif
</x-app-layout>