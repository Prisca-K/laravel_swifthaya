<x-app-layout>
  <h1
    class="text-center text-3xl font-medium text-gray-600 mt-10">
    Tracking History
  </h1>
  <div
    class="bg-white rounded-lg shadow-md p-4 mt-12 mx-5 overflow-x-scroll">
    <table class="min-w-full table-auto">
      <thead class="bg-gray-200">
        <tr>
          <th class="px-4 py-2">Title</th>
          <th class="px-4 py-2">Company</th>
          <th class="px-4 py-2">Tracking status</th>
          <th class="px-4 py-2">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($appliedjobs as $job)
        <tr>
          <td class="border px-4 py-2">{{
            $job->swifthayajob->title
            }}
          </td>

          <td class="border px-4 py-2">{{
            $job->swifthayajob->user->userprofile->companyprofile->company_name
            }}
          </td>

          <td class="border px-4 py-2 flex items-center justify-center">
            <p class="w-32 bg-green-300 text-green-800 text-center border rounded-full">
              {{ $job->swifthayajob->tracking_status }}
            </p>

          </td>

          <td class="border px-4 py-2">
            <a href="{{Route("review.create")}}"
              class="text-green-600 hover:text-green-900 mr-3">
              Review
            </a>
          </td>
        </tr>
        @empty
        <tr>
          <td>
            <p class="text-2xl">No Appliedjob Posted</p>
          </td>
        </tr>

        @endforelse
      </tbody>
    </table>

    <div class="mt-6">
      {{-- {{ $appliedjob->links() }} --}}
    </div>
  </div>
</x-app-layout>