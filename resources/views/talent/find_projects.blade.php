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
          <form action="{{ route('project_search') }}"
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
              <label for="required_skills"
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
                <option value="react" {{
                  request('required_skills')=='react'
                  ? 'selected' : '' }}>React</option>
                <option value="html" {{
                  request('required_skills')=='html'
                  ? 'selected' : '' }}>Html</option>
              </select>
            </div>

            {{-- budget --}}
            <div>
              <label for="budget"
                class="block text-sm font-medium text-gray-700">Budget</label>
              <input type="text" name="budget" id="budget"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                placeholder="e.g. $100"
                value="{{ request('budget') }}">
            </div>

            {{-- duration --}}
            <div>
              <label for="duration"
                class="block text-sm font-medium text-gray-700">Duration(in months)</label>
              <input type="text" name="duration"
                id="duration"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                placeholder="2"
                value="{{ request('duration') }}">
            </div>

            <button type="submit"
              class="w-full bg-indigo-600 text-white py-2 rounded-md hover:bg-indigo-700">Search</button>
          </form>
        </div>
      </div>

      <!-- Talent Results -->
      <div class="w-full md:w-3/4">
        <div class="bg-white shadow-lg rounded-lg p-6">
          <h2 class="text-xl font-semibold mb-4">Project
            Results</h2>
          @if($projects->isEmpty())
          <p class="text-gray-700">No talents found matching
            your criteria.</p>
          @else
          <div
            class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($projects as $project)
            <div class="p-4 border rounded-lg bg-gray-50">
              <h3 class="text-lg font-semibold">
                {{$project->title}}</h3>
              <p class="text-gray-700">
                {{$project->description}}</p>
              <p class="text-gray-700">
                {{ "$" . $project->budget }}</p>
              <p class="text-gray-700">
                {{$project->duration . " " . "months" }}</p>
              <div class="mt-2 flex flex-wrap">
                <span
                  class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-medium mr-2 mb-2">
                  {{$project->required_skills}}</span>
              </div>
            </div>
            @endforeach
          </div>

          <!-- Pagination -->
          <div class="mt-6">
            {{-- {{ $projects->links() }} --}}
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>


</x-app-layout>