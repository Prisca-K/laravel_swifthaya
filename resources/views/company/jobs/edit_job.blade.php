<x-app-layout>

  <div class="min-h-screen bg-gray-100 p-6">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-semibold">Edit Job</h1>
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
      <form
        action="{{ route('job.update', $job->id) }}"
        method="POST">
        @csrf
        @method("patch")
        <div class="mb-4">
          <label for="title"
            class="block text-sm font-medium text-gray-700">Title</label>
          <input type="text" name="title" id="title"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            value="{{ $job->title}}">
        </div>


        {{-- salary range --}}
        <div class="mb-4">
          <label for="salary_range"
            class="block text-sm font-medium text-gray-700">Salary
            Range</label>
          <select name="salary_range" id="salary_range"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <!-- Assuming companies are passed to the view -->
            <option {{($job->salary_range === "10-20") ?
              "selected" : ""}} value="10-20">
              $10-20
            </option>
            <option {{($job->salary_range === "20-30") ?
              "selected" : ""}} value="20-30">
              $20-30
            </option>
            <option {{($job->salary_range === "30-40") ?
              "selected" : ""}} value="30-40">
              $30-40
            </option>
            <option {{($job->salary_range === "40-50") ?
              "selected" : ""}} value="40-50">
              $40-50
            </option>
            <option {{($job->salary_range === "50-above") ?
              "selected" : ""}} value="50-above">
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
            <option {{($job->job_type === "full-time") ?
              "selected" : ""}} value="full-time">
              Full-time
            </option>
            <option {{($job->job_type === "part-time") ?
              "selected" : ""}} value="part-time">
              Part-time
            </option>
            <option {{($job->job_type === "contract") ?
              "selected" : ""}} value="contract">
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
            value="{{ $job->required_skills }}">
        </div>

        {{-- description --}}
        <div class="mb-4">
          <label for="description"
            class="block text-sm font-medium text-gray-700">Description</label>
          <textarea name="description" id="description"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ $job->description }}</textarea>
        </div>
        {{-- location --}}

        <div class="mb-4">
          <label for="location"
            class="block text-sm font-medium text-gray-700">Location</label>
          <input type="text" name="location" id="location"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            value="{{ $job->location }}">
        </div>

        <div class="flex justify-end">
          <button type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Update
            Job</button>
        </div>
      </form>
    </div>
  </div>

</x-app-layout>