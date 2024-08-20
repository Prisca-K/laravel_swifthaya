<x-app-layout>
  <div class="min-h-screen bg-gray-100 p-6">
    <div class="bg-white rounded-lg shadow-md p-4">
      <h2 class="text-2xl font-semibold mb-4">Create New
        Company Profile</h2>

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
        action="{{ route('admin.companies.store', $user_profile->id) }}"
        method="POST">
        @csrf
        <div class="mb-4">
          <label class="block text-gray-700">Company
            Name</label>
          <input type="text" name="company_name"
            value="{{ old('company_name') }}"
            class="w-full px-4 py-2 border rounded-lg">
          @error('company_name') <span
            class="text-red-500 text-sm">{{ $message
            }}</span> @enderror
        </div>
        <div class="mb-4">
          <label
            class="block text-gray-700">Industry</label>
          <input type="text" name="industry"
            value="{{ old('industry') }}"
            class="w-full px-4 py-2 border rounded-lg">
          @error('industry') <span
            class="text-red-500 text-sm">{{ $message
            }}</span> @enderror
        </div>
        <div class="mb-4">
          <label
            class="block text-gray-700">Company Size</label>
          <input type="number" name="company_size"
            value="{{ old('company_size') }}"
            class="w-full px-4 py-2 border rounded-lg">
          @error('company_size') <span
            class="text-red-500 text-sm">{{ $message
            }}</span> @enderror
        </div>
        <div class="mb-4">
          <label
            class="block text-gray-700">Founded Year</label>
          <input type="number" name="founded_year"
            value="{{ old('founded_year') }}"
            class="w-full px-4 py-2 border rounded-lg">
          @error('founded_year') <span
            class="text-red-500 text-sm">{{ $message
            }}</span> @enderror
        </div>
        <div class="mb-4">
          <label
            class="block text-gray-700">Location</label>
          <input type="text" name="location"
            value="{{ old('location') }}"
            class="w-full px-4 py-2 border rounded-lg">
          @error('location') <span
            class="text-red-500 text-sm">{{ $message
            }}</span> @enderror
        </div>
        <div class="mb-4">
          <label class="block text-gray-700">Website</label>
          <input type="text" name="website"
            value="{{ old('website') }}"
            class="w-full px-4 py-2 border rounded-lg">
          @error('website') <span
            class="text-red-500 text-sm">{{ $message
            }}</span> @enderror
        </div>
        <div class="flex items-center justify-between">
          <button type="submit"
            class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Create</button>
          <a href="{{ route('admin.companies') }}"
            class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</x-app-layout>