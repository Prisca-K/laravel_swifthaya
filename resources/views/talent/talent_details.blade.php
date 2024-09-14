<x-app-layout>
  <x-slot name="header">
    <h2
      class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Talent Details') }}
    </h2>
  </x-slot>


  <div class="container mx-auto py-12">
    <!-- Profile Header -->
    <div class="bg-white shadow rounded-lg p-8">
      <div class="flex items-center">
        <div class="w-24 h-24 rounded-full overflow-hidden">
          @if($talent_profile->userprofile->getImgUrl())
          <img
            src="{{ $talent_profile->userprofile->getImgUrl()}}"
            alt="Profile Picture"
            class="w-full h-full object-cover">
          @else
          <img src="https://via.placeholder.com/150"
            alt="Profile Picture"
            class="w-full h-full object-cover">
          @endif
        </div>
        <div class="ml-6">
          <h1 class="text-3xl font-bold text-gray-900">{{
            $talent_profile->userprofile->first_name }} {{
            $talent_profile->userprofile->last_name }}</h1>
          <p class="text-xl text-gray-600 mt-2">{{
            ucfirst($talent_profile->userprofile->user->user_type) }}</p>
          <p class="text-gray-500 mt-4">Location: {{
             $talent_profile->userprofile->location ?? 'Not specified' }}
          </p>
        </div>
        <div class="ml-auto">
          <a
            href="{{Route("job.offer_job", $talent_profile->id)}}"
            class="bg-blue-600 text-white px-6 py-2 rounded-lg text-lg hover:bg-blue-500 transition">
            Hire Me
        </a>
        </div>
      </div>
    </div>

    <!-- Profile Details -->
    <div class="mt-12">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Skills Section -->
        <div class="bg-white shadow rounded-lg p-8">
          <h2 class="text-2xl font-bold text-gray-900 mb-4">
            Skills</h2>
          <ul
            class="list-disc list-inside text-gray-700 space-y-2">
            <li>{{  $talent_profile->skills }}</li>
          </ul>
        </div>

        <!-- Experience Section -->
        <div class="bg-white shadow rounded-lg p-8">
          <h2 class="text-2xl font-bold text-gray-900 mb-4">
            Experience</h2>
          <ul
            class="list-disc list-inside text-gray-700 space-y-2">
            <li>{{ $talent_profile->experience}} years</li>
          </ul>
        </div>

        <!-- Education Section -->
        <div class="bg-white shadow rounded-lg p-8">
          <h2 class="text-2xl font-bold text-gray-900 mb-4">
            Education</h2>
          <ul
            class="list-disc list-inside text-gray-700 space-y-2">
            <li>{{  $talent_profile->education }}</li>
          </ul>
        </div>

        <!-- Portfolio Section -->
        <div class="bg-white shadow rounded-lg p-8">
          <h2 class="text-2xl font-bold text-gray-900 mb-4">
            Portfolio</h2>
          <ul
            class="list-disc list-inside text-gray-700 space-y-2">
            <li><a href="{{$talent_profile->portfolio }}" target="_blank"
                class="text-blue-600 hover:underline">{{$talent_profile->portfolio  }}</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>