<x-app-layout>

  @section('content')
  <div class="min-h-screen bg-gray-100 p-6">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-semibold">User Management
      </h1>
      <a href="{{ route('admin.users.create') }}"
        class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Add
        New User</a>
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
            <th class="px-4 py-2">Name</th>
            <th class="px-4 py-2">Email</th>
            <th class="px-4 py-2">Type</th>
            <th class="px-4 py-2">Status</th>
            <th class="px-4 py-2">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($users as $user)
          <tr>
            <td class="border px-4 py-2">
              {{ $user->userprofile->first_name . " " .
              $user->userprofile->last_name }}
            </td>
            <td class="border px-4 py-2">{{ $user->email }}
            </td>
            <td class="border px-4 py-2">{{ $user->user_type }}
            </td>

            <td class="border px-4 py-2">
              @if($user->status == 'approved')
              <span class="text-green-500">Approved</span>
              @elseif($user->status == 'rejected')
              <span class="text-red-500">Rejected</span>
              @else
              <span class="text-yellow-500">Pending</span>
              @endif
            </td>

            <td class="border px-4 py-2">
              @if($user->status == 'pending')
              <a href="{{ route('admin.users.approve', $user->id) }}"
                class="text-green-600 hover:text-green-900 mr-2">Approve</a>
              <a href="{{ route('admin.users.reject', $user->id) }}"
                class="text-red-600 hover:text-red-900 mr-8">Reject</a>
              @endif
              <a href="{{ route('admin.users.edit', $user->id) }}"
                class="text-blue-600 hover:text-blue-900">Edit</a>
              <form
                action="{{ route('admin.users.destroy', $user->id) }}"
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
        {{ $users->links() }}
      </div>
    </div>
  </div>

</x-app-layout>