<x-app-layout>
  <x-slot name="header">
    <h2
      class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Company Dashboard') }}
    </h2>
  </x-slot>


  <div class="py-12">
    <h2 style="font-size:1.5rem;text-align:center">{{ucfirst($job->title)}}</h2>
    
    <div
      style="max-width:80%; background-color:rgba(128, 128, 128, 0.27);display:flex;flex-wrap:wrap"
      class=" mx-auto p-6 items-center justify-center gap-4 flex-col">
      <div style="min-width: 15rem"
        class="bg-white shadow-sm sm:rounded-lg flex items-center justify-center flex-col p-6">
        <div class="p-6">
         
          <p>Description: {{$job->description}}</p>
          <p>Required Skills: {{$job->required_skills}}</p>
          <p>Salary Range: {{$job->salary_range}}</p>
          <p>Job Type: {{$job->job_type}}</p>
          <p>Deadline: {{$job->deadline_date}}</p>
        </div>


        <div class="w-full buttons flex gap-4">
          <a class="flex justify-center items-center"
          href="{{Route("job.applicants", $job->id)}}"
          style="border: 2px solid gray; padding:5px;
          height:3rem; border-radius:5px; margin-right:
          1rem">Application history
          </a>
          <a class=" w-3/4 flex justify-center items-center"
            href="{{Route("job.edit",[$job->id])}}"
            style="border: 2px solid gray; padding:5px;
            height:3rem; border-radius:5px;">Edit Job
          </a>

          <form
            class=" w-3/4 flex justify-center items-center"
            method="post"
            action="{{Route("job.destroy", [$job->id])}}">
            @csrf
            @method("delete")
            <button
              class="flezx w-full justify-center items-center"
              href="" style="border: 2px solid gray; padding:5px;
          height:3rem; border-radius:5px;">Delete Job
            </button>
          </form>
        </div>
      </div>

      <a class="w-3/4 flex justify-center items-center"
        href="{{Route("jobs", [$job->company_id])}}"
        style="border: 2px solid gray; padding:5px;
        height:3rem; border-radius:5px;">All Jobs
      </a>
    </div>
</x-app-layout>e