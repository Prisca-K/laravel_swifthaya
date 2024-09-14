<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between">
      <h2
        class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Company Dashboard') }}
      </h2>
      <a href="{{ route("jobs", [$job->company_id]) }}"
        class="bg-green-800 text-white px-4 py-2 rounded hover:bg-green-600">All Jobs</a>
    </div>
  </x-slot>


   <div class="min-h-screen bg-gray-100 p-6">
    <div class="bg-white rounded-lg shadow-md p-4">
      <h2 class="text-2xl font-semibold mb-4">Job
        Details</h2>
      <div>
        <p><strong>Name:</strong> {{ $job->title }}

        <p><strong>Skills:</strong> {{ $job->required_skills }}
        </p>
        <p><strong>Experience:</strong> 
        {{(intval( $job->experience) > 1) ?  $job->experience . " " . "years" : $job->experience . " " . "year"}}
        </p>
        <p><strong>Salary Range:</strong> ${{
          $job->salary_range }}</p>
        <p><strong>Location:</strong> {{
          $job->location }}</p>
        <p><strong>Job Type:</strong> {{
          ucfirst($job->job_type) }}</p>
        <p><strong>Description:</strong> {{
          ucfirst($job->description) }}</p>
      </div>
      <div class="mt-4">
        <a href="{{ route('company.dashboard', Auth::user()->id) }}"
          class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Back</a>
        <a href="{{ route('job.edit', $job->id) }}"
          class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Edit</a>
        <a href="{{Route("job.applicants", $job->id)}}"
          class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Application history</a>
        <form
          action="{{ route('job.destroy', $job->id) }}"
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
