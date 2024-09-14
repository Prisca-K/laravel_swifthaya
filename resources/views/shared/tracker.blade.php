<x-app-layout>
  <div
    class="container mx-auto px-4 py-8 flex justify-center flex-col items-center">
    <h1 class="text-3xl font-medium text-gray-600">
      Job/Project Tracker</h1>
    <div class="mt-20 bg-gray-300 p-4 rounded">
      @if (session('success'))
      <div
        class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6"
        role="alert">
        <strong class="font-bold">{{ session('success')
          }}</strong>
      </div>
      @endif
      @foreach ($appliedjobs as $job)
      <div class="card border-2 rounded p-3 w-96">
        <div class="flex justify-between items-center">
          <h2 class="text-2xl">
            {{$job->swifthayajob->user->userprofile->companyprofile->company_name}}
          </h2>
          <p class="bg-gray-400 text-gray-200 p-2 rounded">
            {{$job->created_at->diffForHumans()}}</p>
        </div>
        <p class="text-2xl font-light">
          {{$job->swifthayajob->title}}
        </p>

        <p
          class="mb-5 mt-2 w-fit px-2 pb-1 bg-orange-200 text-orange-700  rounded-full text-xl font-medium">
          {{$job->swifthayajob->tracking_status}}
        </p>

        @if ($job->swifthayajob->tracking_status ===
        "pending")
        <form method="post" action="{{Route("tracking.start",
          $job->swifthayajob_id)}}" class="buttons flex
          items-center mt-5">
          @csrf
          @method('patch')
          <button
            class="bg-green-600 rounded text-white py-2 px-4"
            type="submit">Mark
            as started</button>
        </form>
        @elseif($job->swifthayajob->tracking_status ===
        "in_progress")
        <form method="post" action="{{Route("tracking.complete",
          $job->swifthayajob_id)}}" class="buttons flex
          items-center mt-5">
          @csrf
          @method('patch')
          <button
            class="bg-red-600 rounded text-white py-2 px-4"
            type="submit">Mark
            as completed</button>
        </form>
        @else
        <a
          class="bg-blue-600 rounded text-white py-2 px-4"
          href="{{Route("tracking.history")}}"
          type="submit">
          View
        </a>
        @endif
      </div>
      @endforeach
    </div>
  </div>
</x-app-layout>