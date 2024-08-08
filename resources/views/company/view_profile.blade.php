<x-app-layout>
  <x-slot name="header">
    <h2
      class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Company Dashboard') }}
    </h2>
    <h3>{{$user_profile->first_name}}</h3>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div
        class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex justify-between items-center">
      </div>
    </div>
  </div>
  <div style="margin-left: 2rem" class="profile">
    <h2>Company Profile</h2>
    <h2>{{$user_profile->first_name . " " .
      $user_profile->last_name}}</h2>
    <p>Company Name: {{$company_profile->company_name}}</p>
    <p>Industry: {{$company_profile->industry}}</p>
    <p>Company Size: {{$company_profile->company_size}}</p>
    <p>Founded Year: {{$company_profile->founded_year}}</p>
    @if ($company_profile)
    <div class="flex w-10 mt-3">
      <a class="flex justify-center items-center"
        href="{{Route("company.edit",[$user_profile->id,
        $company_profile->id])}}"
        style="border: 2px solid gray; padding:5px;
        height:3rem; width:fit-content; border-radius:5px;
        margin-right:
        2rem">Edit
        Profile
      </a>
      <form method="post" action="{{Route("company.delete",[$user_profile->id,
        $company_profile->id])}}">
        @csrf
        @method("delete")
        <button class="flex justify-center items-center"
          style="border: 2px solid gray; padding:5px;
        height:3rem; border-radius:5px; margin-right:
        2rem">Delete
          Profile
        </button>

      </form>
    </div>
    @endif
  </div>

</x-app-layout>