<x-app-layout>
  <x-slot name="header">
    <h2
      class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Talent Dashboard') }}
    </h2>
  </x-slot>


  @if(session('error'))
  <div
    class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative m-6"
    role="alert">
    <strong class="font-bold">{{ session('error')
      }}</strong>
  </div>
  @endif

  <div class="min-h-screen max-w-3xl max-md:max-w-full  bg-gray-100 p-6 mx-auto mt-10">
    <div class="bg-white rounded-lg shadow-md p-4">
      <div class="flex justify-between items-center">
        <h2 class="text-2xl font-semibold mb-4">Talent Profile
          Details</h2>
        <p class="mt-4 border rounded p-2 border-yellow-600"><strong>Status:</strong> {{
          ucfirst($talent_profile->status) }}</p>
      </div>
      <div>
        <h3 class="text-xl">
          {{$talent_profile->userprofile->first_name . " " .
          $talent_profile->userprofile->last_name}}
        </h3>
        <p class="mb-4">
          {{ $talent_profile->userprofile->user->email }}
        </p>
        
        {{-- skills --}}
        <p><strong>Skills:</strong>
          @foreach (json_decode($talent_profile->skills) as $skill)
          <li>{{$skill}}</li>
          @endforeach
        </p>
        {{-- exp --}}
        <p class="text-gray-700">
          <?php $experience = json_decode($talent_profile->experience, true)?>
          @foreach ($experience as $i => $exp)
          <div class="border p-4 mt-3 rounded">
            <h3>Experience {{$i + 1}}</h3>
            <p><strong>Company:</strong> {{
              $exp['company']}} </p>
            <p><strong>Role:</strong> {{ $exp['role']
              }}</p>
            <p><strong>Duration:</strong>
              {{(intval($exp['duration']) > 1) ?
              $exp['duration'] . " " . "years" :
              $exp['duration'] . " " . "year" }}</p>
          </div>
          @endforeach
        </p>

        {{-- edu --}}
        <p class="text-gray-700">
          <?php $education = json_decode($talent_profile->education, true)?>
          @foreach ($education as $i => $edu)
          <div class="border p-4 mt-3 rounded">
            <h3>Education {{$i + 1}}</h3>
          <p><strong>Degree:</strong> {{ucfirst( $edu['degree'])}} </p>
          <p><strong>Institution:</strong> {{ $edu['institution'] }}</p> 
          <p><strong>Year:</strong> {{ $edu['year'] }}</p>
          </div>
          @endforeach
        </p>

        {{-- port --}}
        <p class="text-gray-700">
          <?php $portfolio = json_decode($talent_profile->portfolio, true)?>
          @foreach ($portfolio as $i => $port)
          <div class="border p-4 mt-3 rounded">
            <h3>Portfolio {{$i + 1}}</h3>
          <p><strong>Degree:</strong> {{ucfirst( $port['title'])}} </p>
          <p><strong>Institution:</strong> {{ $port['description'] }}</p> 
          <p><strong>Year:</strong> {{ $port['url'] }}</p>
          </div>
          @endforeach
        </p>
      
        
      </div>
      <div class="mt-8 flex justify-between items-center">
        <a href="{{ route('talent.dashboard') }}"
          class="bg-blue-500 text-white px-8 py-2 rounded hover:bg-blue-600">Back</a>
        <a href="{{ route('talent.edit', $talent_profile->id) }}"
          class="bg-green-500 text-white px-8 py-2 rounded hover:bg-green-600">Edit</a>
        {{-- <form
          action="{{ route('talent.delete', $talent_profile->id) }}"
          method="POST" class="inline">
          @csrf
          @method('DELETE')
          <button type="submit"
            class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600"
            onclick="return confirm('Are you sure you want to delete this profile?');">Delete</button>
        </form> --}}
      </div>
    </div>
  </div>

</x-app-layout>