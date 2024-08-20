<x-app-layout>
  <x-slot name="header">
    <h2
      class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Company Dashboard') }}
    </h2>
  </x-slot>


  <div class="py-12">
    <h2
      style="font-size:1.5rem; text-align:center;margin-bottom:2rem">
      My Jobs
    </h2>
    <div
      style="max-width:80%; background-color:rgba(128, 128, 128, 0.27);display:flex;flex-wrap:wrap"
      class="mx-auto p-6 items-center justify-center gap-4 ">
      @if ($jobs)
      @forelse ($jobs as $job)
      <div style="min-width: 15rem"
        class="bg-white shadow-sm sm:rounded-lg flex items-center justify-center flex-col p-6">
        <div class="p-6">
          <h3 style="font-size:1.2rem;">{{$job->title}}</h3>
          <p>Description: {{$job->description}}</p>
          <p>Required Skills: {{$job->required_skills}}</p>
          <p>Salary Range: {{$job->salary_range}}</p>
          <p>Job Type: {{$job->job_type}}</p>
          <p>Deadline: {{$job->deadline_date}}</p>
        </div>
        <div class="w-full buttons flex gap-4">
        <a class=" w-3/4 flex justify-center items-center"
          href="{{Route("job.show", $job->id)}}"
          style="border: 2px solid gray; padding:5px;
          height:3rem; border-radius:5px;">View Job
        </a>
        
        </div>
      </div>

      @empty
      <p style="font-size:1.2rem;">No Jobs Created Yet</p>
      @endforelse
      <a class=" w-3/4 flex justify-center items-center"
        href="{{Route("job.create", [$job->company_id])}}"
        style="border: 2px solid gray; padding:5px;
        height:3rem; border-radius:5px;">Post Job
      </a>
      @endif

    </div>
  </div>
</x-app-layout>