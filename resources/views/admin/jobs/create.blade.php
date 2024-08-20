<x-app-layout>

  <div class="min-h-screen bg-gray-100 p-6">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-semibold">Add New Job</h1>
      <a href="{{ route('admin.jobs') }}"
        class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Back</a>
    </div>

    @if ($errors->any())
    <div
      class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6"
      role="alert">
      <strong class="font-bold">Whoops!</strong> There were
      some problems with your input.<br><br>
      <ul class="mt-3 list-disc list-inside">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <div class="bg-white rounded-lg shadow-md p-4">
      <form action="{{ route('admin.jobs.store') }}"
        method="POST">
        @csrf
        <div class="mb-4">
          <label for="title"
            class="block text-sm font-medium text-gray-700">Title</label>
          <input type="text" name="title" id="title"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            value="{{ old('title') }}">
        </div>
        {{-- company Id --}}
        {{-- <div class="mb-4">
          <label for="company_id"
            class="block text-sm font-medium text-gray-700">Company</label>
          <select name="company_id" id="company_id"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <!-- Assuming companies are passed to the view -->
            @foreach($users as $user)
            <option value="{{ $user->id }}">
              {{ $user->userprofile->first_name . " " .
              $user->userprofile->last_name }}
            </option>
            @endforeach
          </select>
        </div> --}}

        {{-- salary range --}}
        <div class="mb-4">
          <label for="salary_range"
            class="block text-sm font-medium text-gray-700">Salary
            Range</label>
          <select name="salary_range" id="salary_range"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <!-- Assuming companies are passed to the view -->
            <option value="10-20">
              $10-20
            </option>
            <option value="20-30">
              $20-30
            </option>
            <option value="30-40">
              $30-40
            </option>
            <option value="40-50">
              $40-50
            </option>
            <option value="50-above">
              $50-above
            </option>
          </select>
        </div>

        {{-- job type --}}
        <div class="mb-4">
          <label for="job_type"
            class="block text-sm font-medium text-gray-700">Job
            Type</label>
          <select name="job_type" id="job_type"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="full-time">
              Full-time
            </option>
            <option value="part-time">
              Part-time
            </option>
            <option value="contract">
              Contract
            </option>
          </select>
        </div>

        {{-- skills --}}
        <div class="mb-4">
          <label for="required_skills"
            class="block text-sm font-medium text-gray-700">Required
            Skills</label>
          <input type="text" name="required_skills"
            id="required_skills"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            value="{{ old('required_skills') }}">
        </div>

        {{-- description --}}
        <div class="mb-4">
          <label for="description"
            class="block text-sm font-medium text-gray-700">Description</label>
          <textarea name="description" id="description"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
        </div>
        {{-- location --}}

        <div class="mb-4">
          <label for="location"
            class="block text-sm font-medium text-gray-700">Location</label>
          <input type="text" name="location" id="location"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            value="{{ old('location') }}">
        </div>

        <div class="flex justify-end">
          <button type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Create
            Job</button>
        </div>
      </form>
    </div>
  </div>

</x-app-layout>