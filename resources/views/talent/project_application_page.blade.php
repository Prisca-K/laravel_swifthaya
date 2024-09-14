<x-app-layout>
  <x-slot name="header">
    <h2
      class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Apply for Project') }}
    </h2>
  </x-slot>

  <div class="container mx-auto py-12">
    <div class="bg-white shadow rounded-lg p-8">

      <!-- Error Messages -->
      @if ($errors->any())
      <div class="mb-4">
        <ul class="list-disc list-inside text-red-600">
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif

      <!-- Project Application Form -->
      <form action="{{ route('talent.project.apply.store', [$project->id, Auth::user()->id]) }}"
        method="POST" enctype="multipart/form-data"
        class="mt-8">
        @csrf

        <!-- Project Title (Read-Only) -->
        <div class="mb-6">
          <label for="project_title"
            class="block text-sm font-medium text-gray-700">Project
            Title</label>
          <input type="text" id="project_title" name="project_title"
            value="{{ old('project_title', $project->title) }}"
            readonly
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
        </div>

        <!-- Cover Letter -->
        <div class="mb-6">
          <label for="cover_letter"
            class="block text-sm font-medium text-gray-700">Cover
            Letter</label>
          <textarea id="cover_letter" name="cover_letter"
            rows="6"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
            placeholder="Write your cover letter here...">{{ old('cover_letter') }}</textarea>
          @error('cover_letter')
          <span class="text-red-600 text-sm">{{ $message
            }}</span>
          @enderror
        </div>

        <!-- Attachments -->
        <div class="mb-6">
          <label for="attachments"
            class="block text-sm font-medium text-gray-700">Attachments
            (e.g., Resume, Portfolio)</label>
          <input type="file" id="attachments"
            name="attachments"
            class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:border-transparent">
          @error('attachmentss')
          <span class="text-red-600 text-sm">{{ $message
            }}</span>
          @enderror
          <p class="mt-2 text-sm text-gray-500">PDF, DOC,
            DOCX, or ZIP (Max size: 5MB)</p>
        </div>
        {{-- applied at --}}
        <div class="form-group mb-4">
          <label for="applied_at">Applied at</label>
          <input type="date" class="form-control"
            id="applied_at" name="applied_at">
          @error('applied_at')
          <p>{{ $message }}</p>
          @enderror
        </div>

        <!-- Submit Button -->
        <div class="text-center">
          <button type="submit"
            class="w-full bg-blue-600 text-white px-6 py-3 rounded-lg text-lg font-bold hover:bg-blue-500 transition">
            Submit Application
          </button>
        </div>
      </form>
    </div>
  </div>
</x-app-layout>