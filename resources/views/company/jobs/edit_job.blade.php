<x-app-layout>
  <x-slot name="header">
    <div
      class="flex justify-between items-center justify-center">
      <h2
        class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Company Dashboard') }}
      </h2>
      <a class="flex items-center justify-center px-6"
        href="{{Route("jobs", [$user->id])}}"
        style="border: 2px solid gray;
        height:3rem; border-radius:5px;">All Jobs
      </a>

    </div>
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
    <h1>Edit Job</h1>
    <form action="{{ route('job.update',$job->id) }}"
      method="POST">
      @csrf
      @method("PATCH")
      <!-- Title -->
      <div class="form-group">
        <label for="title">Job Title</label>
        <input type="text" class="form-control" id="title"
          name="title" value="{{$job->title}}" required
          maxlength="255">
        @error('title')
        <p>{{ $message }}</p>
        @enderror
      </div>

      <!-- Description -->
      <div class="form-group">
        <label for="description">Job Description</label>
        <textarea class="form-control" id="description"
          name="description" required>
        {{$job->description}}
        </textarea>
        @error('description')
        <p>{{ $message }}</p>
        @enderror
      </div>

      <!-- Required Skills -->
      <div class="form-group">
        <label for="required_skills">Required Skills</label>
        <input type="text" class="form-control"
          id="required_skills"
          value="{{$job->required_skills}}"
          name="required_skills">
        @error('required_skills')
        <p>{{ $message }}</p>
        @enderror
      </div>

      <!-- Location -->
      <div class="form-group">
        <label for="location">Location</label>
        <input type="text" class="form-control"
          id="location" name="location" maxlength="255"
          value="{{$job->location}}">
        @error('location')
        <p>{{ $message }}</p>
        @enderror
      </div>

      <!-- Salary Range -->
      <div class="form-group">
        <label for="salary_range">Salary Range</label>
        <input type="text" class="form-control"
          id="salary_range" name="salary_range"
          maxlength="255" value="{{$job->salary_range}}">
        @error('salary_range')
        <p>{{ $message }}</p>
        @enderror
      </div>

      <!-- Job Type -->
      <div class="form-group">
        <label for="job_type">Job Type</label>
        <select class="form-control" id="job_type"
          name="job_type" required>
          <option value="Full-time">Full-time</option>
          <option value="Part-time">Part-time</option>
          <option value="Contract">Contract</option>
        </select>
        @error('job_type')
        <p>{{ $message }}</p>
        @enderror
      </div>

      <!-- Posted At -->
      <div class="form-group">
        <label for="posted_at">Posted At</label>
        <input type="date" class="form-control"
          id="posted_at" name="posted_at"
          value="{{$job->posted_at}}">
        @error('posted_at')
        <p>{{ $message }}</p>
        @enderror
      </div>

      <!-- Deadline Date -->
      <div class="form-group">
        <label for="deadline_date">Deadline Date</label>
        <input type="date" class="form-control"
          id="deadline_date" name="deadline_date"
          {{$job->deadline_date}}>
        @error('deadline_date')
        <p>{{ $message }}</p>
        @enderror
      </div>

      <button type="submit"
        class="btn btn-primary">Submit</button>
    </form>
  </div>
</x-app-layout>