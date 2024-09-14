<x-app-layout>
  <x-slot name="header">
    <h2
      class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      @if (Auth::user()->user_type === "company")
      {{ __('Company Dashboard') }}
      @else
      {{ __('Individual Dashboard') }}
      @endif
    </h2>
  </x-slot>

  <div class="container mx-auto py-8">
    <div class="flex flex-col md:flex-row justify-between">
      <!-- Search Filters -->
      <div class="w-full md:w-1/4 mb-6 md:mb-0">
        <div class="bg-white shadow-lg rounded-lg p-6">
          <h2 class="text-xl font-semibold mb-4">Search
            Filters</h2>
          <form action="{{ route('talent_search') }}"
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

            {{-- skills --}}
            <div>
              <label for="skills"
                class="block text-sm font-medium text-gray-700">Skills
                Level</label>

              <select name="skills" id="skills"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option value="">Select Skills
                </option>
                <option value="Laravel" {{
                  request('skills')=='Laravel'
                  ? 'selected' : '' }}>Laravel</option>
                <option value="PHP" {{
                  request('skills')=='PHP'
                  ? 'selected' : '' }}>Php</option>
                <option value="Figma" {{
                  request('skills')=='Figma'
                  ? 'selected' : '' }}>Figma</option>
                <option value="SEO" {{
                  request('skills')=='SEO'
                  ? 'selected' : '' }}>Seo</option>
                <option value="Photoshop" {{
                  request('skills')=='Photoshop'
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
                <option value="spain" {{
                  request('location')=='spain' ? 'selected'
                  : '' }}>Spain</option>
                <option value="iran" {{
                  request('location')=='iran' ? 'selected'
                  : '' }}>Iran</option>
                <option value="south africa" {{
                  request('location')=='south africa' ? 'selected'
                  : '' }}>South Africa</option>
                <option value="uk" {{
                  request('location')=='uk' ? 'selected'
                  : '' }}>Uk</option>
                <option value="india" {{
                  request('location')=='india' ? 'selected'
                  : '' }}>India</option>
                <option value="ghana" {{
                  request('location')=='ghana' ? 'selected'
                  : '' }}>Ghana</option>
                <option value="mexico" {{
                  request('location')=='mexico' ? 'selected'
                  : '' }}>Mexico</option>
              </select>
            </div>


            <!-- Experience Filter -->
            <div>
              <label for="experience"
                class="block text-sm font-medium text-gray-700">Experience
              </label>

              <select name="experience" id="experience"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option value="">Select experience level
                </option>
                <option value="1" {{
                  request('experience')=='1 year'
                  ? 'selected' : '' }}>1 year</option>
                <option value="2" {{
                  request('experience')=='2 years'
                  ? 'selected' : '' }}>2 years</option>
                <option value="3" {{
                  request('experience')=='3 years'
                  ? 'selected' : '' }}>3 years</option>
                <option value="4" {{
                  request('experience')=='4 years'
                  ? 'selected' : '' }}>4 years</option>
                <option value="5" {{
                  request('experience')=='5 years'
                  ? 'selected' : '' }}>5 years plus</option>
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
          <h2 class="text-xl font-semibold mb-4">Talent
            Results</h2>
          <div
            class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse($talents as $talent)
            <a href="{{Route("talent.details",$talent->id
              )}}" class="p-4 border rounded-lg bg-gray-50">
              <div class="flex items-center mb-4">
                <div class="flex-shrink-0 h-16 w-16 rounded-full">
                  @if($talent->userprofile->getImgUrl())
                  <img
                    src="{{ $talent->userprofile->getImgUrl()}}"
                    alt="Profile Picture"
                    class="w-full h-full rounded-full object-cover">
                  @else
                  <img src="https://via.placeholder.com/150"
                    alt="Profile Picture"
                    class="w-full h-full rounded-full object-cover">
                  @endif
                </div>
                <div class="ml-4">
                  <h3 class="text-lg font-semibold">
                    {{ $talent->userprofile->first_name }}
                    {{ $talent->userprofile->last_name }}
                  </h3>
                  <p class="text-gray-700">{{
                    ucfirst($talent->userprofile->location) }}</p>
                </div>
              </div>
              {{-- skills --}}
              <div class="mt-2 flex flex-wrap">
                @foreach(json_decode($talent->skills) as $skill)
                <span
                  class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-medium mr-2 mb-2">
                  {{$skill}}</span>
                @endforeach
              </div>
              {{-- education --}}
              <p class="text-gray-700">
                <?php $education = json_decode($talent->education, true)[0]?>

                <div class="border p-4 mt-3 rounded">
                  <h3>Education</h3>
                <p><strong>Degree:</strong> {{ucfirst( $education['degree'])}} </p>
                <p><strong>Institution:</strong> {{ $education['institution'] }}</p> 
                <p><strong>Year:</strong> {{ $education['year'] }}</p>
                </div>
              </p>

                {{-- experience --}}
              <p class="text-gray-700">
  
                <p class="text-gray-700">
                <?php $experience = json_decode($talent->experience, true)[0]?>
                    
                <div class="border p-4 mt-3 rounded">
                  <h3>Experience</h3>
                <p><strong>Company:</strong> {{ $experience['company']}} </p>
                <p><strong>Role:</strong> {{ $experience['role'] }}</p> 
                <p><strong>Duration:</strong> {{(intval($experience['duration']) > 1) ? $experience['duration'] . " " . "years" : $experience['duration'] . " " . "year" }}</p>
                </div>
              </p>
              </p>

              
            </a>
            @empty
            <p class="text-gray-700">No talents found matching
              your criteria.</p>
            @endforelse
          </div>

          <!-- Pagination -->
          <div class="mt-6">
            {{ $talents->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>


</x-app-layout>