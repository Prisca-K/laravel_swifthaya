<x-app-layout>
  <x-slot name="header">
    <h2
      class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Company Dashboard') }}
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
    select,
    input {
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
    <h1>Create Company Profile</h1>
    <form
      action="{{ route('company.store', $user_profile->id) }}"
      method="POST">
      @csrf
      <!-- Company Name -->
      <div class="form-group">
        <label for="company_name">Company Name</label>
        <input type="text" class="form-control"
          id="company_name" name="company_name" required
          maxlength="255">
      </div>

      <!-- Industry -->
      <div class="form-group">
        <label for="industry">Industry</label>
        <input type="text" class="form-control"
          id="industry" name="industry" required
          maxlength="255">
      </div>

      <!-- Company Size -->
      <div class="form-group">
        <label for="company_size">Company Size</label>
        <input type="number" class="form-control"
          id="company_size" name="company_size" required
          min="1">
      </div>

      <!-- Founded Year -->
      <div class="form-group">
        <label for="founded_year">Founded Year</label>
        <input type="number" class="form-control"
          id="founded_year" name="founded_year" required
          min="1800" max="{{ date('Y') }}">
      </div>

      <!-- Location -->
      <div class="form-group">
        <label for="location">Location</label>
        <input type="text" class="form-control"
          id="location" name="location" maxlength="255">
      </div>

      <!-- Website -->
      <div class="form-group">
        <label for="website">Website</label>
        <input type="url" class="form-control" id="website"
          name="website" maxlength="255">
      </div>

      <!-- Phone Number -->
      <div class="form-group">
        <label for="phone_number">Phone Number</label>
        <input type="text" class="form-control"
          id="phone_number" name="phone_number"
          maxlength="15">
      </div>

      <button type="submit"
        class="btn btn-primary">Submit</button>
    </form>
  </div>


</x-app-layout>