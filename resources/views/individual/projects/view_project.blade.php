<x-app-layout>
  <x-slot name="header">
    <h2
      class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('individual Dashboard') }}
    </h2>
  </x-slot>


  <div class="py-12">
    <h2
      style="font-size:1.5rem; text-align:center;margin-bottom:2rem">
      My Project
    </h2>
    <div
      style="max-width:80%; background-color:rgba(128, 128, 128, 0.27);display:flex;flex-wrap:wrap"
      class=" mx-auto p-6 items-center justify-center gap-4 flex-col">
      <div style="min-width: 15rem"
        class="bg-white shadow-sm sm:rounded-lg flex items-center justify-center flex-col p-6">
        <div class="p-6">
          <h3 style="font-size:1.2rem;">{{$project->title}}</h3>
          <p>Description: {{$project->description}}</p>
          <p>Required Skills: {{$project->required_skills}}</p>
          <p>Budget: {{$project->budget}}</p>
          <p>Duration: {{$project->duration}}</p>
          <p>Deadline: {{$project->deadline_date}}</p>
        </div>


        <div class="w-full buttons flex gap-4">
          <a class=" w-3/4 flex justify-center items-center"
            href="{{Route("project.edit", $project->id)}}"
            style="border: 2px solid gray; padding:5px;
            height:3rem; border-radius:5px;">Edit Project
          </a>

          <form
            class=" w-3/4 flex justify-center items-center"
            method="post"
            action="{{Route("project.destroy", $project->id)}}">
            @csrf
            @method("delete")
            <button
              class="flex w-full justify-center items-center"
              href="" style="border: 2px solid gray; padding:5px;
          height:3rem; border-radius:5px;">Delete Project
            </button>
          </form>
        </div>
      </div>
      <a class="w-3/4 flex justify-center items-center"
        href="{{Route("projects",Auth::id())}}"
        style="border: 2px solid gray; padding:5px;
      height:3rem; border-radius:5px;">All Projects
      </a>
    </div>
  </div>
</x-app-layout>