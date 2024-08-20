<x-app-layout>
  <div class="min-h-screen bg-gray-100 p-6">
    <div class="bg-white rounded-lg shadow-md p-4">
      <h2 class="text-2xl font-semibold mb-4">Company
        Profile Details</h2>
      <div>
        <p><strong>Company Name:</strong> {{
          $profile->company_name }}</p>
        <p><strong>Email:</strong> {{ $profile->user->email
          }}</p>
        <p><strong>Industry:</strong> {{ $profile->industry
          }}</p>
        <p><strong>Location:</strong> {{ $profile->location
          }}</p>
        <p><strong>Website:</strong> {{ $profile->website }}
        </p>
        <p><strong>Status:</strong> {{
          ucfirst($profile->status) }}</p>
      </div>
      <div class="mt-4">
        <a href="{{ route('admin.company_management.index') }}"
          class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Back</a>
        <a href="{{ route('admin.company_management.edit', $profile->id) }}"
          class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Edit</a>
        <form
          action="{{ route('admin.company_management.delete', $profile->id) }}"
          method="POST" class="inline">
          @csrf
          @method('DELETE')
          <button type="submit"
            class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600"
            onclick="return confirm('Are you sure you want to delete this profile?');">Delete</button>
        </form>
      </div>
    </div>
  </div>
</x-app-layout>