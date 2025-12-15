<?php

namespace App\Http\Controllers;

use App\Enums\JobType;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class JobApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = JobApplication::where('user_id', Auth::id());

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('company_name', 'like', '%'.$request->search.'%')
                    ->orWhere('role', 'like', '%'.$request->search.'%');
            });
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('job_type') && $request->job_type != '') {
            $query->where('job_type', $request->job_type);
        }

        $applications = $query->latest()->paginate(10);

        return view('job_applications.index', [
            'applications' => $applications,
            'jobTypes' => JobType::cases(),
        ]);
    }

    public function create()
    {
        return view('job_applications.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'applied_date' => 'required|date',
            'location' => 'nullable|string',
            'notes' => 'nullable|string',
            'job_type' => ['required', Rule::enum(JobType::class)],
            'expected_salary' => 'nullable|numeric',
        ]);

        // AUTOMATICALLY set the user_id to the current user
        $validated['user_id'] = Auth::id();
        $validated['status'] = 'applied';

        $application = JobApplication::create($validated);

        $application->logs()->create([
            'status' => 'applied',
            'event_date' => $validated['applied_date'],
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('job-applications.index')
            ->with('success', 'Job Application added successfully!');
    }

    public function show(JobApplication $jobApplication)
    {
        // SECURITY CHECK: Ensure user owns this record
        if ($jobApplication->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $jobApplication->load('logs');

        return view('job_applications.show', compact('jobApplication'));
    }

    public function edit(JobApplication $jobApplication)
    {
        // SECURITY CHECK: Ensure user owns this record
        if ($jobApplication->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('job_applications.edit', compact('jobApplication'));
    }

    public function update(Request $request, JobApplication $jobApplication)
    {
        // SECURITY CHECK
        if ($jobApplication->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'applied_date' => 'required|date',
            'location' => 'nullable|string',
            'notes' => 'nullable|string',
            'job_type' => ['required', Rule::enum(JobType::class)],
            'expected_salary' => 'nullable|numeric',
        ]);

        $jobApplication->update($validated);

        return redirect()->route('job-applications.index')->with('success', 'Application updated!');
    }

    public function destroy(JobApplication $jobApplication)
    {
        // SECURITY CHECK
        if ($jobApplication->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $jobApplication->delete();

        return redirect()->route('job-applications.index')->with('success', 'Application deleted');
    }
}
