<x-app-layout>
  <div class="min-h-screen bg-gray-100 p-6">
    <div class="bg-white rounded-lg shadow-md p-4">
      <h2 class="text-2xl font-semibold mb-4">Create New
        Talent Profile</h2>

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
        action="{{ route('admin.talents.store', $user_profile->id) }}"
        method="POST">
        @csrf
        <div class="mb-4">
          <label class="block text-gray-700">Skills</label>
          <input type="text" name="skills"
            value="{{ old('skills') }}"
            class="w-full px-4 py-2 border rounded-lg">
          @error('skills') <span
            class="text-red-500 text-sm">{{ $message
            }}</span> @enderror
        </div>
        <div class="mb-4">
          <label
            class="block text-gray-700">Experience</label>
          <textarea name="experience"
            class="w-full px-4 py-2 border rounded-lg">{{ old('experience') }}</textarea>
          @error('experience') <span
            class="text-red-500 text-sm">{{ $message
            }}</span> @enderror
        </div>
        <div class="mb-4">
          <label
            class="block text-gray-700">Education</label>
          <textarea name="education"
            class="w-full px-4 py-2 border rounded-lg">{{ old('education') }}</textarea>
          @error('education') <span
            class="text-red-500 text-sm">{{ $message
            }}</span> @enderror
        </div>
        <div class="mb-4">
          <label
            class="block text-gray-700">Portfolio</label>
          <textarea name="portfolio"
            class="w-full px-4 py-2 border rounded-lg">{{ old('portfolio') }}</textarea>
          @error('portfolio') <span
            class="text-red-500 text-sm">{{ $message
            }}</span> @enderror
        </div>
        <div class="flex items-center justify-between">
          <button type="submit"
            class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Create</button>
          <a href="{{ route('admin.talents') }}"
            class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</x-app-layout>