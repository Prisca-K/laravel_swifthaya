<x-app-layout>
  <div class="min-h-screen bg-gray-100 p-6">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-semibold">Edit Project
      </h1>
      <a href="{{ route('project.show', $project->id)}}"
        class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">Back</a>
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
        action="{{ route('project.update', $project->id) }}"
        method="POST">
        @csrf
        @method("patch")
        <div class="mb-4">
          <label for="title"
            class="block text-sm font-medium text-gray-700">Title</label>
          <input type="text" name="title" id="title"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            value="{{$project->title }}">
        </div>

        {{-- budget--}}
        <div class="mb-4">
          <label for="budget"
            class="block text-sm font-medium text-gray-700">
            Budget
          </label>
          <select name="budget" id="budget"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <!-- Assuming companies are passed to the view -->
            <option {{($project->budget === "100.00") ? "selected" : "" }} value="100">
              $100
            </option>
            <option {{($project->budget === "200.00") ? "selected" : "" }} value="200">
              $200
            </option>
            <option {{($project->budget === "300.00") ? "selected" : "" }} value="300">
              $300
            </option>
            <option {{($project->budget === "400.00") ? "selected" : "" }} value="400">
              $400-500
            </option>
            <option {{($project->budget === "500.00") ? "selected" : "" }} value="500">
              $500
            </option>
          </select>
        </div>

        {{-- job type --}}
        <div class="mb-4">
          <label for="duration"
            class="block text-sm font-medium text-gray-700">
            Duration (in months)
          </label>
          <input type="text" name="duration" id="duration"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            value="{{$project->duration}}">
        </div>

        {{-- skills --}}
        <div class="mb-4">
          <label for="required_skills"
            class="block text-sm font-medium text-gray-700">Required
            Skills</label>
          <input type="text" name="required_skills"
            id="required_skills"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            value="{{ $project->required_skills }}">
        </div>

        {{-- description --}}
        <div class="mb-4">
          <label for="description"
            class="block text-sm font-medium text-gray-700">Description</label>
          <textarea name="description" id="description"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ $project->description }}</textarea>
        </div>

        <div class="flex justify-end">
          <button type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Update
            Project</button>
        </div>
      </form>
    </div>
  </div>
</x-app-layout>