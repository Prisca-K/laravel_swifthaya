<x-app-layout>
  <div class="min-h-screen bg-gray-100 p-6 mt-10">
    <div class="bg-white rounded-lg shadow-md p-4">
      <h2 class="text-2xl font-semibold mb-4">Edit
        {{$profile->company_name}}
        Profile</h2>

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
        action="{{ route('admin.companies.update', $profile->id) }}"
        method="POST">
        @csrf
        <div class="mb-4">
          <label class="block text-gray-700">Company
            Name</label>
          <input type="text" name="company_name"
            value=" {{$profile->company_name}} "
            class="w-full px-4 py-2 border rounded-lg">
        </div>
        <div class="mb-4">
          <label
            class="block text-gray-700">Industry</label>
          <input type="text" name="industry"
            value="{{ $profile->industry }}"
            class="w-full px-4 py-2 border rounded-lg">
        </div>
        <div class="mb-4">
          <label
            class="block text-gray-700">Company_size</label>
          <input type="number" name="company_size"
            value="{{ $profile->company_size }}"
            class="w-full px-4 py-2 border rounded-lg">
        </div>
        <div class="mb-4">
          <label
            class="block text-gray-700">Founded_year</label>
          <input type="text" name="founded_year"
            value="{{ $profile->founded_year }}"
            class="w-full px-4 py-2 border rounded-lg">
        </div>


        <div class="flex items-center justify-between">
          <button type="submit"
            class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Update</button>
          <a href="{{ route('admin.companies') }}"
            class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</x-app-layout>