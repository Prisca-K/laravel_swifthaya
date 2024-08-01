<x-app-layout>
  <x-slot name="header">
    <h2
      class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Talent Dashboard') }}
    </h2>
    <h3>{{$user_profile->first_name}}</h3>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div
        class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
          {{ __("You're logged in!") }}
        </div>
      </div>
    </div>
  </div>

  <style>
    h1 {
      font-size: 1.1rem;
    }

    .form-container {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      gap: 1rem;
      margin-bottom: 5rem;
    }

    .form-group {
      display: flex;
      justify-content: flex-end;
    }

    label {
      display: flex;
      justify-content: flex-start;
      align-items: center;
      width: 100px;
    }

    button {
      padding: 0.5rem;
      margin-block: 1rem;
      border: 2px solid blue;
      border-radius: 5px
    }

    textarea,
    select {
      width: 300px;
    }

    form {
      /* background-color: red; */
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      gap: 1rem;
    }
  </style>
  {{-- form --}}
  <div class="form-container">
    <h1>Create Talent Profile</h1>
    <form
      action="{{-- {{ route('talent_profile.store') }} --}}"
      method="POST">
      @csrf
      <div class="form-group">
        <label for="skills">Skills</label>
        <textarea name="skills" id="skills"
          class="form-control"></textarea>
      </div>
      <div class="form-group">
        <label for="education">Education</label>
        <textarea name="education" id="education"
          class="form-control"></textarea>
      </div>
      <div class="form-group">
        <label for="portfolio">Portfolio</label>
        <textarea name="portfolio" id="portfolio"
          class="form-control"></textarea>
      </div>
      <div class="form-group">
        <label for="experience">Experience</label>
        <select name="experience" id="experience">
          <option value="1">1 Year</option>
          <option value="2">2 Years</option>
          <option value="3">3 Years</option>
          <option value="4">4 Years</option>
          <option value="5">5 Years</option>
          <option value="6_plus">6+ Years</option>
        </select>
      </div>
      <button type="submit"
        class="btn btn-primary">Submit</button>
    </form>
  </div>
</x-app-layout>