<x-app-layout>
  <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 py-10">
    <div
      class="bg-white shadow-md rounded-lg overflow-hidden">
      <!-- Header -->
      <div
        class="bg-gradient-to-r from-blue-500 to-indigo-600 px-4 py-5 sm:px-6">
        <h3
          class="text-lg leading-6 font-medium text-white">
          Application Details
        </h3>
      </div>

      <!-- Content -->
      <div class="px-4 py-5 sm:p-6">
        <!-- Applicant Information -->
        <div class="mb-6">
          <h4 class="text-lg font-semibold text-gray-900">
            Applicant Information</h4>
          <div class="mt-3 flex items-center">
            <img class="h-16 w-16 rounded-full object-cover"
              src="{{                     $application->user->userprofile->getImgUrl() }}"
              alt="Applicant Photo">
            <div class="ml-4">
              <div
                class="text-lg font-medium text-gray-900">
                {{
                $application->user->userprofile->first_name
                }} {{
                $application->user->userprofile->last_name
                }}
              </div>
              <div class="text-sm text-gray-500">{{
                $application->user->email }}</div>
            </div>
          </div>
        </div>

        <!-- Cover Letter -->
        <div class="mb-6">
          <h4 class="text-lg font-semibold text-gray-900">
            Cover Letter</h4>
          <p class="mt-3 text-gray-700 leading-relaxed">
            {{ $application->cover_letter }}
          </p>
        </div>

        <!-- Attachment Section -->
        <div class="mb-8">
          <h3
            class="text-xl font-semibold text-gray-800 mb-4">
            Attachment</h3>
          @if($application->attachments)
          <a href="{{ asset('storage/' . $application->attachments) }}"
            target="_blank"
            class="text-blue-500 hover:underline">
            View Attachment
          </a>
          @else
          <p class="text-gray-600">No attachment available.
          </p>
          @endif
        </div>

        <!-- Status -->
        <div class="mb-6">
          <h4 class="text-lg font-semibold text-gray-900">
            Application Status</h4>
          <p class="mt-3 text-sm font-medium text-gray-900">
            <span
              class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                  {{ $application->status == 'Accepted' ? 'bg-green-100 text-green-800' : ($application->status == 'Rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
              {{ $application->status }}
            </span>
          </p>
        </div>

        <!-- Actions -->
        <div class="flex space-x-4">
          @if ($application->status === "Pending" || "Accepted")
          <a href="{{ route('messages.index', $application->user->id) }}"
            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            {{($application->status === "Accepted") ?
            "Interview" : "Message"}}
          </a>
          @endif
          @if ($application->status !== "Accepted")
          <form
            action="{{ route('applicants.accept', $application->id) }}"
            method="POST">
            @csrf
            @method('PATCH')
            <button type="submit"
              class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
              Accept
            </button>
          </form>
          @endif

          <form
            action="{{ route('applicants.reject', $application->id) }}"
            method="POST">
            @csrf
            @method('PATCH')
            <button type="submit"
              class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
              Reject
            </button>
          </form>

          <a href="{{ ($application->swifthayajob) ? route('job.applicants', [$application->swifthayajob->id]) : route('project.applicants', [$application->project->id]) }}"
            class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Back to Applications
          </a>
        </div>
      </div>
    </div>
  </div>

</x-app-layout>