<x-app-layout>
  <div class="min-h-screen bg-gray-100 p-6">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-semibold">Create New User
      </h1>
      <a href="{{ route('admin.users') }}"
        class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">Back</a>
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
      <form action="{{ route('admin.users.store') }}"
        method="POST">
        @csrf

        <div class="mb-4">
          <label for="first_name"
            class="block text-sm font-medium text-gray-700">First_Name</label>
          <input type="text" name="first_name" id="first_name"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            value="{{ old('first_name') }}">
          @error('first_name')
          <p class="text-red-500 text-xs mt-2">{{ $message
            }}</p>
          @enderror
        </div>

        <div class="mb-4">
          <label for="last_name"
            class="block text-sm font-medium text-gray-700">Last Name</label>
          <input type="text" name="last_name" id="last_name"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            value="{{ old('last_name') }}">
          @error('last_name')
          <p class="text-red-500 text-xs mt-2">{{ $message
            }}</p>
          @enderror
        </div>

        <div class="mb-4">
          <label for="email"
            class="block text-sm font-medium text-gray-700">Email</label>
          <input type="email" name="email" id="email"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            value="{{ old('email') }}">
          @error('email')
          <p class="text-red-500 text-xs mt-2">{{ $message
            }}</p>
          @enderror
        </div>

        <div class="mb-4">
          <label for="password"
            class="block text-sm font-medium text-gray-700">Password</label>
          <input type="password" name="password"
            id="password"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
          @error('password')
          <p class="text-red-500 text-xs mt-2">{{ $message
            }}</p>
          @enderror
        </div>

        <div class="mb-4">
          <label for="password_confirmation"
            class="block text-sm font-medium text-gray-700">Confirm
            Password</label>
          <input type="password"
            name="password_confirmation"
            id="password_confirmation"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>

        <div class="mb-4">
          <label for="user_type"
            class="block text-sm font-medium text-gray-700">User Type</label>
          <select name="user_type" id="user_type"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="talent">Talent</option>
            <option value="user">Individual</option>
            <option value="company">Company</option>
            <option value="admin">Admin</option>
          </select>
          @error('user_type')
          <p class="text-red-500 text-xs mt-2">{{ $message
            }}</p>
          @enderror
        </div>

        <div class="flex justify-end">
          <button type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Create
            User</button>
        </div>
      </form>
    </div>
  </div>
</x-app-layout>