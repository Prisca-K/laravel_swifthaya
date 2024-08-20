<x-app-layout>
  <div class="container mx-auto py-12">
    <h1
      class="text-3xl font-bold text-gray-900 text-center mb-8">
      Manage Applications for {{ ($isjob) ? $job->title : $project->title }}</h1>
    <div class="bg-white shadow rounded-lg p-6">
      <table class="min-w-full divide-y divide-gray-200">
        <thead>
          <tr>
            <th
              class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Applicant</th>
            <th
              class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Cover Letter</th>
            <th
              class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Submitted On</th>
            <th
              class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Status</th>
            <th
              class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Actions</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @foreach($applications as $application)
          <tr>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="flex items-center">
                <div class="flex-shrink-0 h-10 w-10">
                  <img style="object-fit: cover"
                    class="h-10 w-10 rounded-full"
                    src="{{ $application->user->userprofile->getImgUrl() }}"
                    alt="Profile Photo">
                </div>
                <div class="ml-4">
                  <div
                    class="text-sm font-medium text-gray-900">
                    {{
                    $application->user->userprofile->first_name
                    . " " .
                    $application->user->userprofile->last_name
                    }}
                  </div>
                  <div class="text-sm text-gray-500">
                    {{ $application->user->email }}
                  </div>
                </div>
              </div>
            </td>

            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm text-gray-500">{{
                Str::limit($application->cover_letter, 50)
                }}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm text-gray-500">{{
                $application->created_at->format('M d, Y')
                }}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span
                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                  {{ $application->status == 'Accepted' ? 'bg-green-100 text-green-800' : ($application->status == 'Rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                {{ $application->status }}
              </span>
            </td>

            <td
              class="px-6 py-4 whitespace-nowrap text-sm font-medium">
              <a href="{{ route('applicants.show', $application->id) }}"
                class="px-2 border-2 rounded-full bg-indigo-100 text-indigo-600 hover:text-indigo-900 mr-1">
                View
              </a>
              @if ($application->status === "Accepted")
              <a href="{{-- {{ route('applicants.show', $application->id) }} --}}"
                class="px-2 border-2 rounded-full bg-green-100 text-green-600 hover:text-green-900 mr-1">
                Interview
              </a>
              @else
              <form
                action="{{ route('applicants.accept', $application->id) }}"
                method="POST" class="inline-block">
                @csrf
                @method('PATCH')
                <button type="submit"
                  class=" px-2 border-2 rounded-full bg-green-100 text-green-600 hover:text-green-900 mr-1">
                  Accept
                </button>
              </form>
              @endif
              <form
                action="{{ route('applicants.reject', $application->id) }}"
                method="POST" class="inline-block">
                @csrf
                @method('PATCH')
                <button type="submit"
                  class="px-2 border-2 rounded-full bg-red-100 text-red-600 hover:text-red-900">
                  Reject
                </button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <!-- Pagination -->
      <div class="mt-4">
        {{-- {{ $applications->links() }} --}}
      </div>
    </div>
  </div>
</x-app-layout>