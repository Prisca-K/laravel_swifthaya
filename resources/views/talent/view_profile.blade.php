<x-app-layout>
  <x-slot name="header">
    <h2
      class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Talent Dashboard') }}
    </h2>
    <h3 class="text-xl">{{$talent_profile->userprofile->first_name . " " . $talent_profile->userprofile->last_name}}</h3>
  </x-slot>
  <div class="min-h-screen bg-gray-100 p-6">
    <div class="bg-white rounded-lg shadow-md p-4">
      <h2 class="text-2xl font-semibold mb-4">Talent Profile
        Details</h2>
      <div>
        <p><strong>Name:</strong> {{ $talent_profile->userprofile->first_name . " " . $talent_profile->userprofile->last_name }}
        </p>
        <p><strong>Email:</strong> {{ $talent_profile->userprofile->user->email
          }}</p>
        <p><strong>Skills:</strong> {{ $talent_profile->skills }}
        </p>
        <p><strong>Experience:</strong> 
        {{(intval( $talent_profile->experience) > 1) ?  $talent_profile->experience . " " . "years" : $talent_profile->experience . " " . "year"}}
        </p>
        <p><strong>Education:</strong> {{
          $talent_profile->education }}</p>
        <p><strong>Portfolio:</strong> {{
          $talent_profile->portfolio }}</p>
        <p><strong>Status:</strong> {{
          ucfirst($talent_profile->status) }}</p>
      </div>
      <div class="mt-4">
        <a href="{{ route('talent.dashboard', Auth::user()->id) }}"
          class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Back</a>
        <a href="{{ route('talent.edit', $talent_profile->id) }}"
          class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Edit</a>
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