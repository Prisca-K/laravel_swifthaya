<x-app-layout>
  {{-- <div class="min-h-screen bg-gray-100">
    <div class="flex">
      <!-- Sidebar -->
      <div class="w-64 bg-blue-900 text-white">
        <div class="p-4">
          <h2 class="text-2xl font-bold">Swifthaya Admin
          </h2>
        </div>
        <nav class="mt-6">
          <a href="#"
            class="block py-2 px-4 hover:bg-blue-700">Dashboard</a>
          <a href="#"
            class="block py-2 px-4 hover:bg-blue-700">User
            Management</a>
          <a href="#"
            class="block py-2 px-4 hover:bg-blue-700">Job
            Management</a>
          <a href="#"
            class="block py-2 px-4 hover:bg-blue-700">Project
            Management</a>
          <a href="#"
            class="block py-2 px-4 hover:bg-blue-700">Application
            Tracking</a>
          <a href="#"
            class="block py-2 px-4 hover:bg-blue-700">Messaging</a>
          <a href="#"
            class="block py-2 px-4 hover:bg-blue-700">Payment
            Management</a>
          <a href="#"
            class="block py-2 px-4 hover:bg-blue-700">Settings</a>
        </nav>
      </div>

      <!-- Main Content -->
      <div class="flex-1 p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
          <h1 class="text-3xl font-semibold">Admin Dashboard
          </h1>
          <div class="flex items-center">
            <span class="mr-4">Admin Name</span>
            <img src="/images/admin_avatar.png"
              class="w-10 h-10 rounded-full"
              alt="Admin Avatar">
          </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-4 gap-6 mb-6">
          <div class="bg-white p-4 rounded-lg shadow-md">
            <div class="flex items-center">
              <div
                class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center">
                <i class="fas fa-users text-white"></i>
              </div>
              <div class="ml-4">
                <h4 class="text-lg font-semibold">Total
                  Users</h4>
                <p class="text-gray-500">1,234</p>
              </div>
            </div>
          </div>

          <div class="bg-white p-4 rounded-lg shadow-md">
            <div class="flex items-center">
              <div
                class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center">
                <i class="fas fa-briefcase text-white"></i>
              </div>
              <div class="ml-4">
                <h4 class="text-lg font-semibold">Jobs
                  Posted</h4>
                <p class="text-gray-500">567</p>
              </div>
            </div>
          </div>

          <div class="bg-white p-4 rounded-lg shadow-md">
            <div class="flex items-center">
              <div
                class="w-12 h-12 bg-yellow-500 rounded-full flex items-center justify-center">
                <i class="fas fa-file-alt text-white"></i>
              </div>
              <div class="ml-4">
                <h4 class="text-lg font-semibold">Projects
                  Posted</h4>
                <p class="text-gray-500">123</p>
              </div>
            </div>
          </div>

          <div class="bg-white p-4 rounded-lg shadow-md">
            <div class="flex items-center">
              <div
                class="w-12 h-12 bg-red-500 rounded-full flex items-center justify-center">
                <i
                  class="fas fa-dollar-sign text-white"></i>
              </div>
              <div class="ml-4">
                <h4 class="text-lg font-semibold">Payments
                  Processed</h4>
                <p class="text-gray-500">$34,567</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Recent Applications Table -->
        <div class="bg-white rounded-lg shadow-md p-4 mb-6">
          <h2 class="text-2xl font-semibold mb-4">Recent
            Applications</h2>
          <table class="min-w-full table-auto">
            <thead class="bg-gray-200">
              <tr>
                <th class="px-4 py-2">Applicant Name</th>
                <th class="px-4 py-2">Job Title</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2">Date Applied</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="border px-4 py-2">John Doe</td>
                <td class="border px-4 py-2">Web Developer
                </td>
                <td class="border px-4 py-2 text-green-500">
                  Accepted</td>
                <td class="border px-4 py-2">2024-08-10</td>
              </tr>
              <tr>
                <td class="border px-4 py-2">Jane Smith</td>
                <td class="border px-4 py-2">Graphic
                  Designer</td>
                <td
                  class="border px-4 py-2 text-yellow-500">
                  Pending</td>
                <td class="border px-4 py-2">2024-08-09</td>
              </tr>
              <!-- Add more rows as needed -->
            </tbody>
          </table>
        </div>

        <!-- Messaging Overview -->
        <div class="bg-white rounded-lg shadow-md p-4">
          <h2 class="text-2xl font-semibold mb-4">Messaging
            Overview</h2>
          <div class="grid grid-cols-3 gap-4">
            <div class="p-4 bg-blue-100 rounded-lg">
              <h3 class="text-lg font-semibold">New Messages
              </h3>
              <p class="text-blue-700">12</p>
            </div>
            <div class="p-4 bg-yellow-100 rounded-lg">
              <h3 class="text-lg font-semibold">Pending
                Messages</h3>
              <p class="text-yellow-700">5</p>
            </div>
            <div class="p-4 bg-green-100 rounded-lg">
              <h3 class="text-lg font-semibold">Resolved
                Messages</h3>
              <p class="text-green-700">20</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> --}}

  <div class="min-h-screen bg-gray-100">
    <div class="flex">
      <!-- Sidebar -->
      <div class="w-64 bg-blue-900 text-white">
        <div class="p-4">
          <h2 class="text-2xl font-bold">Admin</h2>
        </div>
        <nav class="mt-6">
          <a href="{{ route('admin.dashboard', Auth::user()->id) }}"
            class="block py-2 px-4 hover:bg-blue-700">Dashboard</a>
          <a href="{{ route('admin.users') }}"
            class="block py-2 px-4 hover:bg-blue-700">User
            Management</a>
          <a href="{{ route('admin.jobs') }}"
            class="block py-2 px-4 hover:bg-blue-700">Job
            Management</a>
          <a href="{{ route('admin.projects') }}"
            class="block py-2 px-4 hover:bg-blue-700">Project
            Management</a>
          <a href="{{ route('admin.talents') }}"
            class="block py-2 px-4 hover:bg-blue-700">Talent 
            Management</a>
          <a href="{{ route('admin.companies') }}"
            class="block py-2 px-4 hover:bg-blue-700">Company 
            Management</a>
          <a href="{{ route('admin.applications') }}"
            class="block py-2 px-4 hover:bg-blue-700">Application
            Tracking</a>
          <a href="{{ route('admin.messages') }}"
            class="block py-2 px-4 hover:bg-blue-700">Messaging</a>
          <a href="{{ route('admin.payments') }}"
            class="block py-2 px-4 hover:bg-blue-700">Payment
            Management</a>
          <a href="{{ route('profile.edit') }}"
            class="block py-2 px-4 hover:bg-blue-700">Settings</a>
        </nav>
      </div>

      <!-- Main Content -->
      <div class="flex-1 p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
          <h1 class="text-3xl font-semibold">Swifthaya Admin
            Dashboard
          </h1>
          <div class="flex items-center">
            <span
              class="mr-4">{{Auth::user()->userprofile->first_name
              . " " .
              Auth::user()->userprofile->last_name}}</span>
            <img
              src="{{Auth::user()->userprofile->getImgUrl()}}"
              class="object-cover w-12 h-12 rounded-full border border-gray-600"
              alt="Admin Avatar">
          </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-4 gap-6 mb-6">
          <div class="bg-white p-4 rounded-lg shadow-md">
            <div class="flex items-center">
              <div
                class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center">
                <i class="fas fa-users text-white"></i>
              </div>
              <div class="ml-4">
                <h4 class="text-lg font-semibold">Total
                  Users</h4>
                <p class="text-gray-500">{{ $totalUsers }}
                </p>
              </div>
            </div>
          </div>

          <div class="bg-white p-4 rounded-lg shadow-md">
            <div class="flex items-center">
              <div
                class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center">
                <i class="fas fa-briefcase text-white"></i>
              </div>
              <div class="ml-4">
                <h4 class="text-lg font-semibold">Jobs
                  Posted</h4>
                <p class="text-gray-500">{{ $totalJobs }}
                </p>
              </div>
            </div>
          </div>

          <div class="bg-white p-4 rounded-lg shadow-md">
            <div class="flex items-center">
              <div
                class="w-12 h-12 bg-yellow-500 rounded-full flex items-center justify-center">
                <i class="fas fa-file-alt text-white"></i>
              </div>
              <div class="ml-4">
                <h4 class="text-lg font-semibold">Projects
                  Posted</h4>
                <p class="text-gray-500">{{ $totalProjects
                  }}</p>
              </div>
            </div>
          </div>

          <div class="bg-white p-4 rounded-lg shadow-md">
            <div class="flex items-center">
              <div
                class="w-12 h-12 bg-red-500 rounded-full flex items-center justify-center">
                <i
                  class="fas fa-dollar-sign text-white"></i>
              </div>
              <div class="ml-4">
                <h4 class="text-lg font-semibold">
                Payments made
                </h4>
                <p class="text-gray-500">${{
                  $paymentsProcessed }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Recent Job Applications Table -->
        <div class="bg-white rounded-lg shadow-md p-4 mb-6">
          <h2 class="text-2xl font-semibold mb-4">Recent Job
            Applications</h2>
          <table class="min-w-full table-auto">
            <thead class="bg-gray-200">
              <tr>
                <th class="px-4 py-2">Applicant Name</th>
                <th class="px-4 py-2">Job Title</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2">Date Applied</th>
              </tr>
            </thead>
            <tbody>
              @foreach($recentJobApplications as $application)
              <tr>
                <td class="border px-4 py-2">{{
                  $application->user->userprofile->first_name
                  . " " .
                  $application->user->userprofile->last_name
                  }}</td>
                <td class="border px-4 py-2">{{
                  $application->swifthayajob->title }}</td>
                <td
                  class="border px-4 py-2 text-center">
                  <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-md font-medium 
                                      {{ $application->status == 'Accepted' ? 'bg-green-100 text-green-800' : ($application->status == 'Rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                    {{ $application->status }}
                  </span>
                </td>
                <td class="border px-4 py-2">{{
                  $application->applied_at
                  }}
                  </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          <div class="mt-3">
            {{$recentJobApplications->links()}}
          </div>
        </div>

        <!-- Recent Project Applications Table -->
        <div class="bg-white rounded-lg shadow-md p-4 mb-6">
          <h2 class="text-2xl font-semibold mb-4">Recent
            Projects
            Applications</h2>
          <table class="min-w-full table-auto">
            <thead class="bg-gray-200">
              <tr>
                <th class="px-4 py-2">Applicant Name</th>
                <th class="px-4 py-2">Project Title</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2">Date Applied</th>
              </tr>
            </thead>
            <tbody>
              @foreach($recentProjectApplications as $application)
              <tr>
                <td class="border px-4 py-2">{{
                  $application->user->userprofile->first_name
                  . " " .
                  $application->user->userprofile->last_name
                  }}</td>
                <td class="border px-4 py-2">{{
                  $application->project->title }}</td>
                <td
                  class="border px-4 py-2 text-center">
                  <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-md font-medium 
                                      {{ $application->status == 'Accepted' ? 'bg-green-100 text-green-800' : ($application->status == 'Rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                    {{ $application->status }}
                  </span>
                </td>
                <td class="border px-4 py-2">{{
                  $application->applied_at
                  }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
          <div class="mt-3">
            {{$recentProjectApplications->links()}}
          </div>
        </div>

        <!-- Messaging Overview -->
        <div class="bg-white rounded-lg shadow-md p-4">
          <h2 class="text-2xl font-semibold mb-4">Messaging
            Overview</h2>
          <div class="grid grid-cols-3 gap-4">
            <div class="p-4 bg-blue-100 rounded-lg">
              <h3 class="text-lg font-semibold">New Messages
              </h3>
              <p class="text-blue-700">{{ $newMessages }}
              </p>
            </div>
            <div class="p-4 bg-yellow-100 rounded-lg">
              <h3 class="text-lg font-semibold">Pending
                Messages</h3>
              <p class="text-yellow-700">{{ $pendingMessages
                }}</p>
            </div>
            <div class="p-4 bg-green-100 rounded-lg">
              <h3 class="text-lg font-semibold">Resolved
                Messages</h3>
              <p class="text-green-700">{{ $resolvedMessages
                }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</x-app-layout>