<x-app-layout>
  <div class="min-h-screen bg-gray-100 p-6">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-semibold">Edit User</h1>
      <a href="{{ route('admin.users') }}"
        class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Back</a>
    </div>


    @if ($errors->any())
    <div
      class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6"
      role="alert">
      <strong class="font-bold">Whoops!</strong> There were
      some problems with your input.<br><br>
      <ul class="mt-3 list-disc list-inside">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <div class="bg-white rounded-lg shadow-md p-4">
      <form
        action="{{ route('admin.users.update', $user->id) }}"
        method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
          <label for="first_name"
            class="block text-sm font-medium text-gray-700">First
            Name</label>
          <input type="text" name="first_name" id="first_name"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            value="{{ old('first_name', $user->userprofile->first_name) }}">
        </div>

        <div class="mb-4">
          <label for="last_name"
            class="block text-sm font-medium text-gray-700">Last
            Name</label>
          <input type="text" name="last_name" id="last_name"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            value="{{ old('last_name', $user->userprofile->last_name) }}">
        </div>
        {{-- bio --}}
        <div class="mb-4">
          <label for="bio"
            class="block text-sm font-medium text-gray-700">Bio</label>
          <textarea
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            name="bio" id="bio" cols="30" rows="10">
              {{ old('bio', $user->userprofile->bio) }}
            </textarea>
        </div>
        {{-- location --}}
        <div class="mb-4">
          <label for="location"
            class="block text-sm font-medium text-gray-700">
            Location
          </label>
          <input type="text" name="location" id="location"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            value="{{ old('location', $user->userprofile->location) }}">
        </div>
        {{-- phone --}}
        <div class="mb-4">
          <label for="phone_number"
            class="block text-sm font-medium text-gray-700">
            Phone Number
          </label>
          <input type="text" name="phone_number"
            id="phone_number"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            value="{{ old('phone_number', $user->userprofile->phone_number) }}">
        </div>
        {{-- website --}}
        <div class="mb-4">
          <label for="website"
            class="block text-sm font-medium text-gray-700">
            Website
          </label>
          <input type="url" name="website" id="website"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            value="{{ old('website', $user->userprofile->website) }}">
        </div>
        {{-- email --}}
        <div class="mb-4">
          <label for="email"
            class="block text-sm font-medium text-gray-700">Email</label>
          <input type="email" name="email" id="email"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            value="{{ old('email', $user->email) }}">
        </div>

        {{-- <div class="mb-4">
          <label for="user_type"
            class="block text-sm font-medium text-gray-700">User
            Type</label>
          <select name="user_type" id="user_type"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="individual" {{ $user->user_type
              == 'individual' ?
              'selected' : '' }}>Individual</option>
            <option value="admin" {{ $user->user_type ==
              'admin'
              ? 'selected' : '' }}>Admin</option>
            <option value="talent" {{ $user->user_type ==
              'talent' ? 'selected' : '' }}>Talent</option>
            <option value="company" {{ $user->user_type ==
              'company' ? 'selected' : '' }}>Company
            </option>
          </select>
        </div> --}}

        <div class="flex justify-end">
          <button type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Update
            User</button>
        </div>
      </form>
    </div>
  </div>
</x-app-layout>