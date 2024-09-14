<x-app-layout>
  <x-slot name="header">
    <h2
      class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Talent Dashboard') }}
    </h2>
    <h3 class="text-xl">{{$profile->userprofile->first_name . " " . $profile->userprofile->last_name}}</h3>
  </x-slot>
  <div
    class="min-h-screen max-w-3xl max-md:max-w-full  bg-gray-100 p-6 mx-auto">
    <div class="bg-white rounded-lg shadow-md p-4">
      <h2 class="text-2xl font-semibold mb-4">Edit
        Talent Profile</h2>

      @if ($errors->any())
      <div
        class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6"
        role="alert">
        <strong class="font-bold">Whoops!</strong> There
        were
        some problems with your input.<br><br>
        <ul class="mt-3 list-disc list-inside">
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif

      <form
        action="{{ route('admin.talents.update', $profile->id) }}"
        method="POST">
        @csrf
        @method("PATCH")
        <div class="mb-4">
          <label class="block text-gray-700">Skills</label>
          <input type="text" name="skills"
            value="{{implode(",", json_decode($profile->skills))}}"
            class="mt-1 block w-full border border-gray-300 rounded-md">
          @error('skills') <span
            class=" text-red-500 text-sm">{{ $message
            }}</span> @enderror
        </div>

        {{-- experience --}}
        <div id="experience-fields"
          class="border rounded p-4 mb-8">
          <h2 class="text-2xl font-semibold mb-4">Experience
          </h2>
          @foreach (json_decode($profile->experience) as $i => $exp)
          <div class="experience-item mb-4">
            <h3> Experience {{$i + 1}}</h3>
            <label for="company"
              class="block text-sm font-medium text-gray-700">Company</label>
            <input type="text" name="experience[0][company]"
              class="company my-1 block w-full border border-gray-300 rounded-md" value="{{$exp->company}}">
            <label for="role"
              class="block text-sm font-medium text-gray-700">Role</label>
            <input type="text" name="experience[0][role]"
              class="role my-1 block w-full border border-gray-300 rounded-md" value="{{$exp->role}}">

            <label for="duration"
              class="block text-sm font-medium text-gray-700">Duration</label>
            <input type="number"
              name="experience[0][duration]"
              class="duration my-1 block w-full border border-gray-300 rounded-md" value="{{$exp->duration}}">
          </div>
          @endforeach
        </div>

        <button
          class="block mb-10 bg-blue-500 text-white px-4 py-2 rounded"
          type="button" onclick="addExperienceField()">Add
          Experience
        </button>


        <!-- Education Section -->
        <div id="education-fields"
          class="mb-8 border rounded p-4">
          <h2 class="text-2xl font-semibold mb-4">Education
          </h2>
          @foreach (json_decode($profile->education) as $i => $edu)
              
          <div class="education-item mb-4">
            <h3> Education {{$i + 1}}</h3>
            <label for="degree"
              class="block text-sm font-medium text-gray-700">Degree</label>
            <input type="text" name="education[0][degree]"
              id="degree"
              class="degree text my-1 block w-full border border-gray-300 rounded-md" value="{{$edu->degree}}">

            <label for="institution"
              class="block text-sm font-medium text-gray-700">Institution</label>
            <input type="text"
              name="education[0][institution]"
              id="institution"
              class="institution my-1 block w-full border border-gray-300 rounded-md" value="{{$edu->institution}}">

            <label for="year"
              class="block text-sm font-medium text-gray-700">Year</label>
            <input type="number" name="education[0][year]"
              id="year"
              class="year my-1 block w-full border border-gray-300 rounded-md" value="{{$edu->year}}">
          </div>
          @endforeach
        </div>
        <button type="button" onclick="addEducationField()"
          class="mb-10 bg-blue-500 text-white px-4 py-2 rounded">
          Add
          Education
        </button>

        <!-- Portfolio Section -->
        <div id="portfolio-fields"
          class="mb-8 border rounded p-4">
          <h2 class="text-2xl font-semibold mb-4">Portfolio
          </h2>
          @foreach (json_decode($profile->portfolio) as $i => $port)
          <div class="portfolio-item">
            <h3> Portfolio {{$i + 1}}</h3>
            <label for="title"
              class="block text-sm font-medium text-gray-700">Title</label>
            <input type="text" name="portfolio[0][title]"
              id="title"
              class="title my-1 block w-full border border-gray-300 rounded-md" value="{{$port->title}}" >

            <label for="description"
              class="block text-sm font-medium text-gray-700">Description</label>
            <input type="text"
              name="portfolio[0][description]"
              id="description"
              class="description my-1 block w-full border border-gray-300 rounded-md" value="{{$port->description}}">

            <label for="url"
              class="block text-sm font-medium text-gray-700">URL</label>
            <input type="url" name="portfolio[0][url]"
              id="url"
              class="url my-1 block w-full border border-gray-300 rounded-md" value="{{$port->url}}">
          </div>
          @endforeach
        </div>
        <button type="button" onclick="addPortfolioField()"
          class="block mb-10 bg-blue-500 text-white px-4 py-2 rounded">Add
          Portfolio
        </button>

        <div class="flex justify-between">
          <button type="submit"
            class="bg-green-500 text-white px-6 py-2 rounded">
            Edit
          </button>

          <a href="{{ route('talent.dashboard') }}"
            class="bg-gray-500 text-white px-4 py-3 rounded hover:bg-gray-600">Cancel</a>
        </div>
      </form>
    </div>
  </div>
  <script>
    function addExperienceField() {
      const container = document.getElementById('experience-fields');
      const index = container.children.length - 1;
      console.log(index);
      
      const newItem = `
        <div class="experience-item">
            <h3> Experience ${index + 1}</h3>
            <label for="company" class="block text-sm font-medium text-gray-700">Company</label>
            <input type="text" name="experience[${index}][company]" class="company mt-1 block w-full border border-gray-300 rounded-md">

            <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
            <input type="text" name="experience[${index}][role]" class="role mt-1 block w-full border border-gray-300 rounded-md">

            <label for="duration" class="block text-sm font-medium text-gray-700">Duration</label>
            <input type="number" name="experience[${index}][duration]" class="duration mt-1 block w-full border border-gray-300 rounded-md">
        </div>
      `;
      container.insertAdjacentHTML('beforeend', newItem);
    }
    // Add Education Field
    function addEducationField() {
      const container = document.getElementById('education-fields');
      const index = container.children.length - 1;
      console.log();
      
      const newItem = `
        <div class="education-item">
            <h3> Education ${index + 1}</h3>
            <label for="degree" class="block text-sm font-medium text-gray-700">Degree</label>
            <input type="text" name="education[${index}][degree]" id="degree" class="degree my-1 block w-full border border-gray-300 rounded-md">

            <label for="institution}" class="block text-sm font-medium text-gray-700">Institution</label>
            <input type="text" name="education[${index}][institution]" id="institution}" class="institution my-1 block w-full border border-gray-300 rounded-md">

            <label for="year" class="block text-sm font-medium text-gray-700">Year</label>
            <input type="number" name="education[${index}][year]" id="year" class="year my-1 block w-full border border-gray-300 rounded-md">
        </div>
      `;
      container.insertAdjacentHTML('beforeend', newItem);
    }

    // Add Portfolio Field
    function addPortfolioField() {
      const container = document.getElementById('portfolio-fields');
      const index = container.children.length - 1;
      const newItem = `
        <div class="portfolio-item">
            <h3> Portfolio ${index + 1}</h3>
            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
            <input type="text" name="portfolio[${index}][title]" id="title" class="title my-1 block w-full border border-gray-300 rounded-md">

            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <input type="text" name="portfolio[${index}][description]" id="description" class="description my-1 block w-full border border-gray-300 rounded-md">

            <label for="url" class="block text-sm font-medium text-gray-700">URL</label>
            <input type="url" name="portfolio[${index}][url]" id="url" class="url my-1 block w-full border border-gray-300 rounded-md">
        </div>
      `;
      container.insertAdjacentHTML('beforeend', newItem);
    }

  </script>
</x-app-layout>