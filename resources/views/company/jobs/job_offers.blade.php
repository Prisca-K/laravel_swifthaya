<x-app-layout>
  <div
    class="container mx-auto my-10 p-6 bg-white shadow-lg rounded-lg">
    <!-- Header -->
    <div class="mb-6">
      <h2 class="text-2xl font-bold text-gray-800">Confirm
        Job Offer</h2>
      <p class="text-gray-600">Review the details before
        sending the offer to the candidate.</p>
    </div>


    <!-- Candidate Information Section -->
    <div class="mb-8">
      <h3 class="text-xl font-semibold text-gray-800 mb-4">
        Candidate Information</h3>
      <div class="flex items-center space-x-4">
        <img
          src="{{ $candidate->userprofile->getImgUrl() }}"
          alt="Profile Photo"
          class="w-20 h-20 rounded-full shadow-md object-cover">
        <div>
          <h4 class="text-lg font-medium text-gray-900">{{
            $candidate->userprofile->first_name }} {{
            $candidate->userprofile->last_name }}</h4>
          <p class="text-gray-600">{{
            $candidate->userprofile->email }}</p>
          <p class="text-gray-600">{{
            $candidate->userprofile->location }}</p>
        </div>
      </div>
    </div>

    <!-- Contract Terms Section -->
    <div class="mb-8">
      <h3 class="text-xl font-semibold text-gray-800 mb-4">
        Contract Terms</h3>
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label class="block text-gray-700">Start
            Date</label>
          <input type="date"
            class="mt-1 block w-full bg-gray-100 border border-gray-300 rounded-md p-2">
        </div>
        <div>
          <label class="block text-gray-700">Work
            Hours</label>
          <input type="text"
            class="mt-1 block w-full bg-gray-100 border border-gray-300 rounded-md p-2"
            placeholder="e.g., 9 AM - 5 PM">
        </div>
        <div class="col-span-2">
          <label class="block text-gray-700">Payment
            Terms</label>
          <input type="text"
            class="mt-1 block w-full bg-gray-100 border border-gray-300 rounded-md p-2"
            placeholder="e.g., Monthly, Per Milestone">
        </div>
        <div class="col-span-2">
          <label class="block text-gray-700">Additional
            Notes</label>
          <textarea
            class="mt-1 block w-full bg-gray-100 border border-gray-300 rounded-md p-2"
            rows="4"
            placeholder="Add any additional information here..."></textarea>
        </div>
      </div>
    </div>

    <!-- Job Selection Modal Trigger -->
    <div class="text-right mb-4">
      <button id="selectJobButton"
        class="px-6 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
        Select Job to Offer
      </button>
    </div>

    <!-- Selected Job Details Display -->
    <div id="selectedJobDetails" class="mb-8 hidden">
      <h3 class="text-xl font-semibold text-gray-800 mb-4">
        Selected Job:</h3>
      <div class="bg-gray-100 p-4 rounded shadow">
        <p id="jobTitle"
          class="font-semibold text-gray-800"></p>
        <p id="jobDescription" class="text-gray-600 mt-1">
        </p>
        <p id="jobLocation" class="text-gray-600 mt-1"></p>
        <p id="jobSalary" class="text-gray-600 mt-1"></p>
      </div>
    </div>

    <!-- Final Confirmation -->
    <div class="text-right">
      <button id="sendOfferButton"
        class="px-6 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition mt-4 hidden">
        Send Offer
      </button>
    </div>
  </div>

  <!-- Job Selection Modal -->
  <div id="jobSelectionModal"
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div style="min-height:35rem; max-height:35rem;"
      class="bg-white rounded-lg overflow-hidden overflow-y-scroll shadow-xl max-w-md w-full">
      <div class="p-4">
        <h3 class="text-lg font-medium text-gray-900">Select
          a Job</h3>
        <div class="mt-4">
          <ul id="jobList" class="divide-y divide-gray-200">
            @foreach($jobs as $job)
            <li class="p-4 hover:bg-gray-100 cursor-pointer"
              data-job-title="{{ $job->title }}"
              data-job-description="{{ $job->description }}"
              data-job-location="{{ $job->location }}"
              data-job-salary="{{ $job->salary_range }}"
              data-job-id="{{ $job->id }}">
              <h4 class="font-semibold text-gray-800">{{
                $job->title }}</h4>
              <p class="text-gray-600 text-sm mt-1">{{
                Str::limit($job->description, 100) }}</p>
            </li>
            @endforeach
          </ul>
        </div>
      </div>

      {{-- projects --}}
      <div class="p-4">
        <h3 class="text-lg font-medium text-gray-900">Select
          a Project</h3>
        <div class="mt-4">
          <ul id="projectList"
            class="divide-y divide-gray-200">
            {{-- @if ($hasproject) --}}
            @forelse($projects as $project)
            <li class="p-4 hover:bg-gray-100 cursor-pointer"
              data-project-title="{{ $project->title }}"
              data-project-description="{{ $project->description }}"
              data-project-location="{{ $project->location }}"
              data-project-salary="{{ $project->salary_range }}"
              data-project-id="{{ $project->id }}">
              <h4 class="font-semibold text-gray-800">{{
                $project->title }}</h4>
              <p class="text-gray-600 text-sm mt-1">{{
                Str::limit($project->description, 100) }}
              </p>
            </li>
            @empty
            <p class=" text-center text-2xl mt-20 mb-3">No projects yet</p>
            <a class="flex justify-center items-center"
              href="{{Route("project.create",Auth::user()->id)}}"
              style="border: 2px solid gray; padding:5px;
              height:3rem; border-radius:5px;">Post Project
            </a>
            @endforelse
            {{-- @endif --}}
          </ul>
        </div>
      </div>
      <div class="bg-gray-50 px-4 py-3 flex justify-end fixed bottom-20">
        <button id="closeModalButton"
          class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
          Cancel
        </button>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const selectJobButton = document.getElementById('selectJobButton');
      const jobSelectionModal = document.getElementById('jobSelectionModal');
      const jobListItems = document.querySelectorAll('#jobList li');
      const projectListItems = document.querySelectorAll('#projectList li');
      const selectedJobDetails = document.getElementById('selectedJobDetails');
      const sendOfferButton = document.getElementById('sendOfferButton');
      const closeModalButton = document.getElementById('closeModalButton');
      
      // Trigger modal display
      selectJobButton.addEventListener('click', () => {
        jobSelectionModal.classList.remove('hidden');
      });

      // Close modal
      closeModalButton.addEventListener('click', () => {
        jobSelectionModal.classList.add('hidden');
      });

      // Handle job selection
      projectListItems.forEach(item => {
        item.addEventListener('click', () => {
          const projectTitle = item.getAttribute('data-project-title');
          const projectDescription = item.getAttribute('data-project-description');
          const projectLocation = item.getAttribute('data-project-location');
          const projectSalary = item.getAttribute('data-project-salary');
          const projectId = item.getAttribute('data-project-id');

          // Populate selected project details
          document.getElementById('jobTitle').innerText = projectTitle;
          document.getElementById('jobDescription').innerText = projectDescription;
          document.getElementById('jobLocation').innerText = 'Location: ' + projectLocation;
          document.getElementById('jobSalary').innerText = 'Salary: ' + projectSalary;

          // Show selected project details and send offer button
          selectedJobDetails.classList.remove('hidden');
          sendOfferButton.classList.remove('hidden');

          // Hide modal
          jobSelectionModal.classList.add('hidden');
        });
      });
      jobListItems.forEach(item => {
        item.addEventListener('click', () => {
          const jobTitle = item.getAttribute('data-job-title');
          const jobDescription = item.getAttribute('data-job-description');
          const jobLocation = item.getAttribute('data-job-location');
          const jobSalary = item.getAttribute('data-job-salary');
          const jobId = item.getAttribute('data-job-id');

          // Populate selected job details
          document.getElementById('jobTitle').innerText = jobTitle;
          document.getElementById('jobDescription').innerText = jobDescription;
          document.getElementById('jobLocation').innerText = 'Location: ' + jobLocation;
          document.getElementById('jobSalary').innerText = 'Salary: ' + jobSalary;

          // Show selected job details and send offer button
          selectedJobDetails.classList.remove('hidden');
          sendOfferButton.classList.remove('hidden');

          // Hide modal
          jobSelectionModal.classList.add('hidden');
        });
      });

      // Handle offer submission
      sendOfferButton.addEventListener('click', () => {
        // You would submit the form or make an AJAX request to send the offer
        alert('Job offer sent successfully!');
      });
    });
  </script>
</x-app-layout>