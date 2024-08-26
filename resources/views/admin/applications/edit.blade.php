<x-app-layout>
  <div class="min-h-screen bg-gray-100 p-6">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-semibold">Edit Application
      </h1>
      <a href="{{ route('admin.applications') }}"
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
      <form
        action="{{ route('admin.applications.update', $application->id) }}"
        method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
          <label for="status"
            class="block text-sm font-medium text-gray-700">Status</label>
          <input type="text" name="status" id="status"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            value="{{ old('status', $application->status) }}">
        </div>

        <div class="mb-4">
          <label for="cover_letter"
            class="block text-sm font-medium text-gray-700">Cover Letter</label>
          <textarea rows="10" name="cover_letter" id="cover_letter"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('cover_letter', $application->cover_letter) }}</textarea>
        </div>

        <div class="flex justify-end">
          <button type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Update
            Application</button>
        </div>
      </form>
    </div>
  </div>
</x-app-layout>