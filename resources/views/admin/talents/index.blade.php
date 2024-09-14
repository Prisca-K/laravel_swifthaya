<x-app-layout>
  <div class="min-h-screen bg-gray-100">
    <div class="flex-1 p-6">
      <!-- Table of Talent Profiles -->
      @if (session('success'))
      <div
        class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6"
        role="alert">
        <strong class="font-bold">{{ session('success')
          }}</strong>
      </div>
      @endif

      <div class="bg-white rounded-lg shadow-md p-4">
        <div class="flex justify-between items-center mb-6">
          <h1 class="text-3xl font-semibold">
            Talent Management
          </h1>
          <a href="{{ route('admin.users.create') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Add
            New Talent Profile</a>
        </div>



        <table class="min-w-full table-auto">
          <thead class="bg-gray-200">
            <tr>
              <th class="px-4 py-2">Name</th>
              <th class="px-4 py-2">Skills</th>
              <th class="px-4 py-2">Status</th>
              <th class="px-4 py-2">Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($talent_profiles as $profile)
            <tr>
              <td class="border px-4 py-2">{{
                $profile->userprofile->first_name . " " .
                $profile->userprofile->last_name }}
              </td>
              <td class="border ps-8 py-2">
                <ul class="flex gap-10">
                  @foreach (json_decode($profile->skills) as $skill)
                  <li class="list-disc">{{ $skill }}</li>
                  @endforeach
                </ul>
              </td>
              <td class="border px-4 py-2">
                @if($profile->status == 'approved')
                <span class="text-green-500">Approved</span>
                @elseif($profile->status == 'rejected')
                <span class="text-red-500">Rejected</span>
                @else
                <span class="text-yellow-500">Pending</span>
                @endif
              </td>
              <td class="border px-4 py-2">
                @if($profile->status == 'pending')
                <a href="{{ route('admin.talents.approve', $profile->id) }}"
                  class="text-green-600 hover:text-green-900 mr-2">Approve</a>
                <a href="{{ route('admin.talents.reject', $profile->id) }}"
                  class="text-red-600 hover:text-red-900 mr-4">Reject</a>
                @endif
                <a href="{{ route('admin.talents.edit', $profile->id) }}"
                  class="text-blue-600 hover:text-blue-900 mr-2">
                  Edit
                </a>


                <button x-data=""
                  x-on:click.prevent="$dispatch('open-modal', 'confirm-userprofile-deletion')">
                  {{ __('Delete Account') }}
                </button>

                <x-modal name="confirm-userprofile-deletion"
                  focusable>
                  <form method="post"
                    action="{{ route('admin.talents.destroy', $profile->id) }}"
                    class="p-6">
                    @csrf
                    @method('delete')

                    <h2
                      class="text-lg font-medium text-gray-900 dark:text-gray-100">
                      Are you sure you want to delete
                      {{
                      $profile->userprofile->first_name . "
                      " .
                      $profile->userprofile->last_name }}'s
                      account
                    </h2>

                    <p
                      class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                      {{ __("Once the profile is deleted,
                      the user's account and all of its
                      resources and data will be permanently
                      deleted.") }}
                    </p>


                    <div class="mt-6 flex justify-end">
                      {{-- <x-secondary-button
                        x-on:click="$dispatch('close')">
                        {{ __('Cancel') }}
                      </x-secondary-button> --}}
                      <a class="" href="{{Route("admin.talents")}}">Cancel</a>

                      <x-danger-button type="submit"
                        class="ms-3">
                        {{ __('Delete Account') }}
                      </x-danger-button>
                    </div>
                  </form>
                </x-modal>

              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</x-app-layout>