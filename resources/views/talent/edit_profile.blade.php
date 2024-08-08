<x-app-layout>
  <x-slot name="header">
    <h2
      class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Talent Dashboard') }}
    </h2>
    <h3>{{$user_profile->first_name}}</h3>
  </x-slot>

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
      margin-block: 5rem;
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
      padding: 0.5rem 2rem;
      margin-block: 1rem;
      border: 2px solid grey;
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
      border: 1px solid grey;
      border-radius: 1rem;
      padding: 2rem;
    }
  </style>
  {{-- form --}}
  <div class="form-container">
    <h1>Edit Talent Profile</h1>
    <form
      action="{{ route('talent.update', [ $talent_profile->id]) }}"
      method="POST">
      @csrf
      @method("PATCH")
      <div class="form-group">
        <label for="skills">Skills</label>
        <textarea name="skills" id="skills"
          class="form-control">{{$talent_profile ->skills}}</textarea>
      </div>
      <div class="form-group">
        <label for="education">Education</label>
        <textarea name="education" id="education"
          class="form-control">{{$talent_profile ->education}}</textarea>
      </div>
      <div class="form-group">
        <label for="portfolio">Portfolio</label>
        <textarea name="portfolio" id="portfolio"
          class="form-control">{{$talent_profile ->portfolio}}</textarea>
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