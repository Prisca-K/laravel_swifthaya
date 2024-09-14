<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Message;
use App\Models\Payment;
use App\Models\Project;
use App\Models\Swifthayajob;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
  public function index()
  {

    $totalUsers = User::count();
    $totalJobs = Swifthayajob::count();
    $totalProjects = Project::count();
    $totalApplications = Application::count();
    // $totalRevenue = Application::where('status', 'Accepted')->sum('amount'); // Assuming you have an amount column
    $paymentsProcessed = Payment::all()->sum('amount'); // This is just a placeholder value. You'd fetch this from your payments table.

    $recentJobs = Swifthayajob::with(['user', 'application'])->latest()->take(5)->get();
    $recentProjects = Project::with(['user', 'application'])->latest()->take(5)->get();
    $recentJobApplications = Application::with(['user', 'swifthayajob'])
      ->whereNotNull('swifthayajob_id')
      ->latest()
      ->paginate(5);
    $recentProjectApplications = Application::with(['user', 'project'])
      ->whereNotNull('project_id')
      ->latest()
      ->paginate(5);
    $newMessages = Message::where('status', 'new')->count();
    $pendingMessages = Message::where('status', 'pending')->count();
    $resolvedMessages = Message::where('status', 'resolved')->count();

    return view('admin.dashboard', compact(
      'totalUsers',
      'totalJobs',
      'totalProjects',
      'totalApplications',
      'recentJobs',
      'recentProjects',
      'paymentsProcessed',
      'recentJobApplications',
      'recentProjectApplications',
      'newMessages',
      'pendingMessages',
      'resolvedMessages',
    ));
  }
}
