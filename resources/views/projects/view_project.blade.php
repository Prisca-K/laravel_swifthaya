<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between">
      <h2
        class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Individual Dashboard') }}
      </h2>
      <a href="{{ route("projects", [$project->poster_id]) }}"
        class="bg-green-800 text-white px-4 py-2 rounded hover:bg-green-600">All Projects</a>
    </div>
  </x-slot>


   <div class="min-h-screen bg-gray-100 p-6">
    <div class="bg-white rounded-lg shadow-md p-4">
      <h2 class="text-2xl font-semibold mb-4">Project
        Details</h2>
      <div>
        <p><strong>Name:</strong> {{ $project->title }}

        <p><strong>Skills:</strong> {{ $project->required_skills }}
        </p>
        <p><strong>Duration:</strong> 
        {{(intval( $project->duration) > 1) ?  $project->duration . " " . "months" : $project->duration . " " . "month"}}
        </p>
        <p><strong>Budget:</strong> ${{
          $project->budget }}</p>
        <p><strong>Description:</strong> {{
          $project->description }}</p>
        <p><strong>Deadline Date</strong> {{
          ucfirst($project->deadline_date) }}</p>
      </div>
      <div class="mt-4">
        <a href="{{ route('company.dashboard', Auth::user()->id) }}"
          class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Back</a>
        <a href="{{ route('project.edit', $project->id) }}"
          class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Edit</a>
        <a href="{{Route("project.applicants", $project->id)}}"
          class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Application history</a>
        <form
          action="{{ route('project.destroy', $project->id) }}"
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
