<x-app-layout>

  <div class="min-h-screen bg-gray-100 p-6">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-semibold">All Jobs </h1>
      <a href="{{ route('job.create', Auth::user()->id) }}"
        class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Add
        New Job</a>
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
            <th class="px-4 py-2">Staus</th>
            <th class="px-4 py-2">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($jobs as $job)
          <tr>
            <td class="border px-4 py-2">{{ $job->title }}
            </td>
            <td class="border px-4 py-2">{{
              ($job->user->userprofile->companyprofile) ?
              $job->user->userprofile->companyprofile->company_name
              : "No company profile yet"}}</td>

            <td class="border px-4 py-2">
              @if($job->status === 'approved')
              <span class="text-green-500">Approved</span>
              @elseif($job->user->status ==='rejected')
              <span class="text-red-500">Rejected</span>
              @else
              <span class="text-yellow-500">Pending</span>
              @endif
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
  </div>
</x-app-layout>