<x-app-layout>
  <x-slot name="header">
    <h2
      class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Talent Dashboard') }}
    </h2>
  </x-slot>

  <div class="container mx-auto py-8">
    <div class="flex flex-col md:flex-row justify-between">
      <!-- Search Filters -->
      <div class="w-full md:w-1/4 mb-6 md:mb-0">
        <div class="bg-white shadow-lg rounded-lg p-6">
          <h2 class="text-xl font-semibold mb-4">Search
            Filters</h2>
          <form action="{{ route('job_search') }}"
            method="GET" class="space-y-4">
            <!-- Skill Filter -->
            <div>
              <label for="keyword"
                class="block text-sm font-medium text-gray-700">Keyword</label>
              <input type="text" name="keyword" id="keyword"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                placeholder="e.g. JavaScript, PHP"
                value="{{ request('keyword') }}">
            </div>
            {{-- title --}}
            <div>
              <label for="title"
                class="block text-sm font-medium text-gray-700">Title</label>
              <input type="text" name="title" id="title"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                placeholder="e.g. Web developer"
                value="{{ request('title') }}">
            </div>

            {{-- skills --}}
            <div>
              <label for="skills"
                class="block text-sm font-medium text-gray-700">Required_skills
              </label>

              <select name="required_skills"
                id="required_skills"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option value="">Select Required Skills
                </option>
                <option value="laravel" {{
                  request('required_skills')=='laravel'
                  ? 'selected' : '' }}>Laravel</option>
                <option value="php" {{
                  request('required_skills')=='php'
                  ? 'selected' : '' }}>Php</option>
                <option value="figma" {{
                  request('required_skills')=='figma'
                  ? 'selected' : '' }}>Figma</option>
                <option value="seo" {{
                  request('required_skills')=='seo'
                  ? 'selected' : '' }}>Seo</option>
                <option value="photoshop" {{
                  request('required_skills')=='photoshop'
                  ? 'selected' : '' }}>Photoshop</option>
              </select>
            </div>

            {{-- location --}}
            <div>
              <label for="location"
                class="block text-sm font-medium text-gray-700">Location
              </label>

              <select name="location" id="location"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option value="">Select Location
                </option>
                <option value="nigeria" {{
                  request('location')=='nigeria'
                  ? 'selected' : '' }}>Nigeria</option>
                <option value="europe" {{
                  request('location')=='europe' ? 'selected'
                  : '' }}>Europe</option>
                <option value="us" {{
                  request('location')=='us' ? 'selected'
                  : '' }}>Us</option>
                <option value="germany" {{
                  request('location')=='germany'
                  ? 'selected' : '' }}>Germany</option>
              </select>
            </div>


            <!-- Experience Filter -->
            <div>
              <label for="experience"
                class="block text-sm font-medium text-gray-700">Job
                Type
              </label>

              <select name="job_type" id="job_type"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option value="">Select Job Type
                </option>
                <option value="full-time" {{
                  request('job_type')=='full-time'
                  ? 'selected' : '' }}>Full-time</option>
                <option value="part-time" {{
                  request('job_type')=='part-time'
                  ? 'selected' : '' }}>Part-time</option>
                <option value="contract" {{
                  request('job_type')=='Contract '
                  ? 'selected' : '' }}>Contract </option>
              </select>
            </div>

            <button type="submit"
              class="w-full bg-indigo-600 text-white py-2 rounded-md hover:bg-indigo-700">Search</button>
          </form>
        </div>
      </div>

      <!-- Talent Results -->
      <div class="w-full md:w-3/4">
        <div class="bg-white shadow-lg rounded-lg p-6">
          <h2 class="text-xl font-semibold mb-4">Job
            Results</h2>
         
          <div
            class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse($jobs as $job)
            <a href="{{Route("job.details",$job->id)}}"
              class="p-4 border rounded-lg bg-gray-50">
              <h3 class="text-lg font-semibold">
                {{$job->title}}</h3>
              <p class="text-gray-700">
                {{$job->location
                }}</p>
              <p class="text-gray-700">
                {{$job->description}}</p>
              <p class="text-gray-700">
                {{ "$" . $job->salary_range }}</p>
              <p class="text-gray-700">
                {{$job->job_type }}</p>
              <div class="mt-2 flex flex-wrap">
                {{-- @foreach($talent->skills as $skill)
                --}}
                <span
                  class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-medium mr-2 mb-2">
                  {{$job->required_skills}}</span>
                {{-- @endforeach --}}
              </div>
            </a>
            @empty
            <p class="text-gray-700">No talents found matching
              your criteria.</p>
            @endforelse
          </div>

          <!-- Pagination -->
          <div class="mt-6">
            {{ $jobs->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>


</x-app-layout>