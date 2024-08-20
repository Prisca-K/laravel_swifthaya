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
            {{($application->swifthayajob) ? "Job
            Information" : "Project Information"}}
          </h4>
          <div class="mt-3 flex items-center">
            <img class="h-16 w-16 rounded-full object-cover"
              src="{{ ($application->swifthayajob) ? $application->swifthayajob->user->userprofile->getImgUrl() : $application->project->user->userprofile->getImgUrl() }}"
              alt="Applicant Photo">
            <div class="ml-4">
              <div
                class="text-lg font-medium text-gray-900">
                {{
                ($application->swifthayajob) ?
                $application->swifthayajob->title :
                $application->project->title
                }}
              </div>
              <div class="text-sm text-gray-500">{{
                ($application->swifthayajob) ?
                $application->swifthayajob->user->email :
                $application->project->user->email}}</div>
            </div>
          </div>
        </div>

      <!-- Cover Letter -->
      <div class="mb-6">
        <h4 class="text-lg font-semibold text-gray-900">
          {{($application->swifthayajob) ? "Job
          description" : "Project description"}}
        </h4>
        <p class="mt-3 text-gray-700 leading-relaxed">
          {{ ($application->swifthayajob) ?
          $application->swifthayajob->description :
          $application->project->description}}
        </p>
      </div>

      <!-- Attachment Section -->
      <div class="mb-8">
        <h3
          class="text-xl font-semibold text-gray-800 mb-4">
          Required skills</h3>
        <p class="text-gray-600 leading-relaxed">
          {{ ($application->swifthayajob)
          ?$application->swifthayajob->required_skills :
          $application->project->required_skills }}
        </p>
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
      <a href="{{ ($application->swifthayajob) ? route('talent.job.apply.history',Auth::user()->id) : route('talent.project.apply.history', Auth::user()->id) }}"
        class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        Back to Applications
      </a>
    </div>
  </div>
  </div>
  </div>

</x-app-layout>