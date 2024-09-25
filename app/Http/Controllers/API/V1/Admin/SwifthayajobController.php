<?php

namespace App\Http\Controllers\API\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSwifthayajobRequest;
use App\Http\Requests\UpdateSwifthayajobRequest;
use App\Http\Resources\SwifthayajobResource;
use App\Models\Swifthayajob;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class SwifthayajobController extends Controller
{
    // List all jobs with pagination
    public function index()
    {
        try {
            // Retrieve paginated list of jobs
            $jobs = Swifthayajob::paginate(10);

            // Return the jobs in a resource collection format
            return SwifthayajobResource::collection($jobs);
        } catch (Exception $e) {
            // Log the error for internal debugging
            // Log::error('Failed to retrieve jobs: ', ['error' => $e->getMessage()]);

            // Return error message and HTTP status code 500
            return response()->json(['message' => 'Failed to retrieve jobs', 'error' => $e->getMessage()], 500);
        }
    }

    // View a specific job
    public function show(Swifthayajob $swSwifthayajob)
    {
        // Authorize the action (ensure the current user is allowed to view the job)
        Gate::authorize("view", $swSwifthayajob);

        try {
            // Return the specific job as a resource
            return new SwifthayajobResource($swSwifthayajob);
        } catch (Exception $e) {
            // Log the error
            // Log::error('Failed to retrieve job: ', ['error' => $e->getMessage()]);

            // Return error message and HTTP status code 500
            return response()->json(['message' => 'Failed to retrieve job', 'error' => $e->getMessage()], 500);
        }
    }

    // Create a new job
    public function store(StoreSwifthayajobRequest $request)
    {
        DB::beginTransaction(); // Begin DB transaction

        try {
            // Retrieve the current authenticated user (company creating the job)
            $user = Auth::user();

            // Validate the request data
            $validated = $request->validated();

            // Convert the required_skills string into an array
            $skillsArray = explode(',', $validated["skills"]);

            // Assign the authenticated user ID as company_id
            $validated["company_id"] = $user->id;

            // Convert the skills array to a JSON-encoded string for storage
            $validated["required_skills"] = json_encode($skillsArray);

            // Create the job using the relationship method from the User model
            $job = $user->swifthayajob()->create($validated);

            DB::commit(); // Commit transaction

            // Return the created job as a resource
            return new SwifthayajobResource($job);
        } catch (Exception $e) {
            DB::rollBack(); // Rollback transaction in case of error

            // Log the error for debugging
            // Log::error('Failed to create job: ', ['error' => $e->getMessage()]);

            // Return a JSON response with an error message
            return response()->json(['message' => 'Failed to create job', 'error' => $e->getMessage()], 500);
        }
    }

    // Update an existing job
    public function update(UpdateSwifthayajobRequest $request, Swifthayajob $job)
    {
        DB::beginTransaction(); // Begin DB transaction

        try {
            // Validate the request data
            $validated = $request->validated();

            // Convert the required_skills string into an array
            $skillsArray = explode(',', $validated["skills"]);

            // Convert the skills array to a JSON-encoded string for storage
            $validated["required_skills"] = json_encode($skillsArray);

            // Update the job with the validated data
            $job->update($validated);

            DB::commit(); // Commit transaction

            // Return the updated job as a resource
            return new SwifthayajobResource($job);
        } catch (Exception $e) {
            DB::rollBack(); // Rollback transaction in case of error

            // Log the error for debugging
            // Log::error('Failed to update job: ', ['error' => $e->getMessage()]);

            // Return a JSON response with an error message
            return response()->json(['message' => 'Failed to update job', 'error' => $e->getMessage()], 500);
        }
    }

    // Delete a job
    public function destroy(Swifthayajob $job)
    {
        try {
            // Delete the specified job
            $job->delete();

            // Return a success message
            return response()->json(["message" => "Job deleted successfully"]);
        } catch (Exception $e) {
            // Log the error for debugging
            // Log::error('Failed to delete job: ', ['error' => $e->getMessage()]);

            // Return an error message in case of failure
            return response()->json(['message' => 'Failed to delete job', 'error' => $e->getMessage()], 500);
        }
    }

    // Approve a job listing
    public function approve(Swifthayajob $job)
    {
        try {
            // Check if the job exists
            if (!$job) {
                return response()->json(['message' => 'Job not found'], 404);
            }

            // Set the job status to 'approved'
            $job->status = 'approved';
            $job->save();

            // Return a success message
            return response()->json(["message" => "Job has been approved successfully"]);
        } catch (Exception $e) {
            // Log the error for debugging
            // Log::error('Failed to approve job: ', ['error' => $e->getMessage()]);

            // Return an error message in case of failure
            return response()->json(['message' => 'Failed to approve job', 'error' => $e->getMessage()], 500);
        }
    }

    // Reject a job listing
    public function reject(Swifthayajob $job)
    {
        try {
            // Check if the job exists
            if (!$job) {
                return response()->json(['message' => 'Job not found'], 404);
            }

            // Set the job status to 'rejected'
            $job->status = 'rejected';
            $job->save();

            // Return a success message
            return response()->json(["message" => "Job has been rejected successfully"]);
        } catch (Exception $e) {
            // Log the error for debugging
            // Log::error('Failed to reject job: ', ['error' => $e->getMessage()]);

            // Return an error message in case of failure
            return response()->json(['message' => 'Failed to reject job', 'error' => $e->getMessage()], 500);
        }
    }
}

