<x-app-layout>
  <div class="min-h-screen bg-gray-100 p-6">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-semibold">Application
        Tracking</h1>
    </div>

    @if (session('success'))
    <div
      class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6"
      role="alert">
      <strong class="font-bold">{{ session('success')
        }}</strong>
    </div>
    @endif
    {{-- Job--}}
    <div class="bg-white rounded-lg shadow-md p-4 mb-20">
      <h2 class="text-2xl font-semibold pb-4">Jobs
      </h2>
      <table class="min-w-full table-auto">
        <thead class="bg-gray-200">
          <tr>
            <th class="px-4 py-2">Job</th>
            <th class="px-4 py-2">Candidate</th>
            <th class="px-4 py-2">Status</th>
            <th class="px-4 py-2">Applied At</th>
            <th class="px-4 py-2">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($jobApplications as $application)
          <tr>
            <td class="border px-4 py-2">{{
              $application->swifthayajob->title }}</td>
            <td class="border px-4 py-2">
              {{$application->user->userprofile->first_name
              . " " .
              $application->user->userprofile->last_name}}
              {{-- @if ($application->userprofile)
              {{$application->userprofile->last_name }}
              @endif --}}
            </td>

            <td class="p-4 border">
              {{$application->created_at->diffForHumans()}}
            </td>

            <td class="border px-4 py-2">{{
              $application->status }}</td>
            <td class="border px-4 py-2">
              <a href="{{ route('admin.applications.edit', $application->id) }}"
                class="text-blue-600 hover:text-blue-900">Edit</a>
              <form
                action="{{ route('admin.applications.destroy', $application->id) }}"
                method="POST" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit"
                  class="text-red-600 hover:text-red-900 ml-4">Delete</button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>

      <div class="mt-6">
        {{ $jobApplications->links() }}
      </div>
    </div>


    {{-- Project --}}
    <div class="bg-white rounded-lg shadow-md p-4">
      <h2 class="text-2xl font-semibold pb-4">Projects
      </h2>
      <table class="min-w-full table-auto">
        <thead class="bg-gray-200">
          <tr>
            <th class="px-4 py-2">Project</th>
            <th class="px-4 py-2">Candidate</th>
            <th class="px-4 py-2">Status</th>
            <th class="px-4 py-2">Applied At</th>
            <th class="px-4 py-2">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($projectApplications as $application)
          <tr>
            <td class="border px-4 py-2">{{
              $application->project->title }}</td>
            <td class="border px-4 py-2">
              {{$application->user->userprofile->first_name
              . " " .
              $application->user->userprofile->last_name}}
              {{-- @if ($application->userprofile)
              {{$application->userprofile->last_name }}
              @endif --}}
            </td>

            <td class="p-4 border">
              {{$application->created_at->diffForHumans()}}
            </td>

            <td class="border px-4 py-2">{{
              $application->status }}</td>
            <td class="border px-4 py-2">
              <a href="{{ route('admin.applications.edit', $application->id) }}"
                class="text-blue-600 hover:text-blue-900">Edit</a>
              <form
                action="{{ route('admin.applications.destroy', $application->id) }}"
                method="POST" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit"
                  class="text-red-600 hover:text-red-900 ml-4">Delete</button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>

      <div class="mt-6">
        {{ $jobApplications->links() }}
      </div>
    </div>
  </div>
</x-app-layout>