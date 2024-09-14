<x-app-layout>
  <div class="container mx-auto py-12">
    <h1
      class="text-3xl font-bold text-gray-900 text-center mb-8">
      Your Job Applications History</h1>

    <div class="bg-white shadow rounded-lg p-6">
      <table class="min-w-full divide-y divide-gray-200">
        <thead>
          <tr>
            <th
              class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Swifthayajob Title</th>
            <th
              class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Company</th>
            <th
              class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Applied On
            </th>
            <th
              class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Status</th>
            <th
              class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Actions</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @forelse($applications as $application)
          <tr>
            <td class="px-6 py-4 whitespace-nowrap">
              <div
                class="text-sm font-medium text-gray-900">
                {{ $application->swifthayajob->title }}
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm text-gray-500">{{
                $application->swifthayajob->user->userprofile->companyprofile->company_name
                }}
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm text-gray-500">{{
                $application->applied_at
                }}
              </div>
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
              <a href="{{ route('applications.job_details', $application->id) }}"
                class="text-blue-600 hover:text-blue-900">View</a>
            </td>
          </tr>
          @empty 
          <tr><td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm font-medium text-gray-900">
              You haven't applied to any Job
              </div>
            </td>
          </tr>
          @endforelse
          {{-- @endif --}}
        </tbody>
      </table>

      <!-- Pagination -->
      <div class="mt-4">
        {{-- {{ $applications->links() }} --}}
      </div>
    </div>
  </div>

</x-app-layout>