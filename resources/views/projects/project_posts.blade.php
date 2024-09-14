<x-app-layout>

  <div class="min-h-screen bg-gray-100 p-6">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-semibold">All  Projects
      </h1>
      <a href="{{ route('project.create', Auth::user()->id) }}"
        class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Add
        New Project</a>
    </div>

    @if (session('success'))
    <div
      class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6"
      role="alert">
      <strong class="font-bold">{{ session('success')
        }}</strong>
    </div>
    @endif
    <div class="bg-white rounded-lg shadow-md p-4">
      <table class="min-w-full table-auto">
        <thead class="bg-gray-200">
          <tr>
            <th class="px-4 py-2">Title</th>
            <th class="px-4 py-2">Company</th>
            <th class="px-4 py-2">Status</th>
            <th class="px-4 py-2">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($projects as $project)
          <tr>
            <td class="border px-4 py-2">{{ $project->title
              }}</td>
            <td class="border px-4 py-2">{{
              $project->user->userprofile->first_name . " "
              . $project->user->userprofile->last_name }}
            </td>
  
            <td class="border px-4 py-2">
              @if($project->status === 'approved')
              <span class="text-green-500">Approved</span>
              @elseif($project->user->status ==='rejected')
              <span class="text-red-500">Rejected</span>
              @else
              <span class="text-yellow-500">Pending</span>
              @endif
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
  </div>

</x-app-layout>