<x-app-layout>
  <div class="min-h-screen bg-gray-100 p-6">
    <div class="bg-white rounded-lg shadow-md p-4">
      <h2 class="text-2xl font-semibold mb-4">Edit {{
        $profile->userprofile->first_name . " " .
        $profile->userprofile->last_name }}'s
        Profile</h2>


      @if ($errors->any())
      <div
        class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6"
        role="alert">
        <strong class="font-bold">Whoops!</strong> There
        were
        some problems with your input.<br><br>
        <ul class="mt-3 list-disc list-inside">
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif
      <form
        action="{{ route('admin.talents.update', $profile->id) }}"
        method="POST">
        @csrf
        <div class="mb-4">
          <label class="block text-gray-700">Skills</label>
          <input type="text" name="skills"
            value="{{ $profile->skills }}"
            class="w-full px-4 py-2 border rounded-lg">
        </div>
        <div class="mb-4">
          <label
            class="block text-gray-700">Experience</label>
          <textarea name="experience"
            class="w-full px-4 py-2 border rounded-lg">{{ $profile->experience }}</textarea>
        </div>
        <div class="mb-4">
          <label
            class="block text-gray-700">Education</label>
          <textarea name="education"
            class="w-full px-4 py-2 border rounded-lg">{{ $profile->education }}</textarea>
        </div>
        <div class="mb-4">
          <label
            class="block text-gray-700">Portfolio</label>
          <textarea name="portfolio"
            class="w-full px-4 py-2 border rounded-lg">{{ $profile->portfolio }}</textarea>
        </div>
        <div class="mb-4">
          <label class="block text-gray-700">Status</label>
          <select name="status"
            class="w-full px-4 py-2 border rounded-lg">
            <option value="pending" {{ $profile->status ==
              'pending' ? 'selected' : '' }}>Pending
            </option>
            <option value="approved" {{ $profile->status ==
              'approved' ? 'selected' : '' }}>Approved
            </option>
            <option value="rejected" {{ $profile->status ==
              'rejected' ? 'selected' : '' }}>Rejected
            </option>
          </select>
        </div>
        <div class="flex items-center justify-between">
          <button type="submit"
            class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Update</button>
          <a href="{{ route('admin.talents') }}"
            class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</x-app-layout>