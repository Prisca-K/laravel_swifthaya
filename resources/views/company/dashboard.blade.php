<x-app-layout>
  <x-slot name="header">
    <h2
      class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Company Dashboard') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div
        class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex justify-between items-center">
        <div class="p-6 text-gray-900 dark:text-gray-100">
          {{ __("You're logged in!") }}
        </div>
        @if ($user_profile->companyprofile)
        <div class="buttons flex gap-3">
          <a class="flex justify-center items-center"
            href="{{Route("job.create",$user->id)}}"
            style="border: 2px solid gray; padding:5px;
            height:3rem; border-radius:5px;">Post Job
          </a>
          <a class="flex justify-center items-center"
            href="{{Route("project.create",$user->id)}}"
            style="border: 2px solid gray; padding:5px;
            height:3rem; border-radius:5px;">Post Project
          </a>
          <a href="{{ Route("messages.index") }}"
          class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
          Messages
          </a>
          @if ($jobs)
          <a class="flex justify-center items-center"
            href="{{Route("jobs",$user->id)}}"
            style="border: 2px solid gray; padding:5px;
            height:3rem; border-radius:5px; margin-right:
            1rem">My Jobs
          </a>
          
          @endif
        </div>
        @else
        <a class="flex justify-center items-center"
          href="{{Route("company.create",
          $user_profile->id)}}"
          style="border: 2px solid gray; padding:5px;
          height:3rem; border-radius:5px; margin-right:
          2rem">Create
          Profile
        </a>
        @endif
        <a class="flex justify-center items-center"
          href="{{Route("profile.edit",
          $user->id)}}"
          style="border: 2px solid gray; padding:5px;
          height:3rem; border-radius:5px; margin-right:
          2rem">Profile
        </a>
        <a class="flex justify-center items-center" 
        href="{{Route("find_talents")}}"
        style="border: 2px solid gray; padding:5px;
        height:3rem; border-radius:5px; margin-right:
        2rem">Find Talents
        </a>
      </div>
    </div>

  </div>
  @if ($jobs)

  <h2
  style="font-size:1.5rem; text-align:center;margin-bottom:1rem">
  My Jobs
  </h2>
  <div
    style="max-width:80%; background-color:rgba(128, 128, 128, 0.27);display:flex;flex-wrap:wrap"
    class=" mx-auto p-6 items-center justify-center gap-4">
    @forelse ($jobs as $job)
    <div style="min-width: 20rem; max-width: 20rem"
      class="bg-white shadow-sm sm:rounded-lg flex items-center justify-center flex-col p-6">
      <div class="p-6 text-wrap">
        <h3 style="font-size:1.2rem;">{{$job->title}}</h3>
        <p>Description: {{$job->description}}</p>
        <p>Required Skills: {{$job->required_skills}}</p>
        <p>Salary Range: {{"$" . $job->salary_range}}</p>
        <p>Job Type: {{$job->job_type}}</p>
        <p>Deadline: {{$job->deadline_date}}</p>
      </div>

        <a class=" w-3/4 flex justify-center items-center"
          href="{{Route("job.show", $job->id)}}"
          style="border: 2px solid gray; padding:5px;
          height:3rem; border-radius:5px;">View Job
        </a>    
    </div>
    @empty
    <p>No Jobs Posted Yet</p>
    @endforelse
  </div>
  @endif
  @if ($projects)
  <h2
  style="font-size:1.5rem; text-align:center;margin-top:1rem">
  My Projects
  </h2>
  <div class="py-12">
    <div
      style="max-width:80%; background-color:rgba(128, 128,
      128, 0.27); display:flex; flex-wrap:wrap"
      class=" mx-auto p-6 items-center justify-center gap-4">
      @forelse ($projects as $project)
      <div style="min-width: 20rem; max-width: 20rem"
        class="bg-white shadow-sm sm:rounded-lg flex items-center justify-center flex-col p-6">
        <div class="p-6 text-wrap">
          <h3 style="font-size:1.2rem;">{{$project->title}}
          </h3>
          <p>Description: {{$project->description}}</p>
          <p>Required Skills: {{$project->required_skills}}
          </p>
          <p>Budget: {{"$" . $project->budget}}</p>
          <p>Duration: {{$project->duration}} months</p>
          <p>Deadline: {{$project->deadline_date}}</p>
        </div>

        <a class=" w-3/4 flex justify-center items-center"
        href="{{Route("project.show", $project->id)}}"
        style="border: 2px solid gray; padding:5px;
        height:3rem; border-radius:5px;">View Project
      </a>
      </div>
      @empty
      <p>No Projects Posted Yet</p>
     @endforelse
    </div>
  </div>
  @endif
</x-app-layout>