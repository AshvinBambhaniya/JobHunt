<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobApplicationController extends Controller
{
    public function index()
    {
        // FILTER: Only get applications where user_id matches the logged-in user
        $applications = JobApplication::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('job_applications.index', compact('applications'));
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
            'status' => 'required',
            'applied_date' => 'required|date',
            'location' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        // AUTOMATICALLY set the user_id to the current user
        $validated['user_id'] = Auth::id();

        JobApplication::create($validated);

        return redirect()->route('job-applications.index')
            ->with('success', 'Job Application added successfully!');
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
            'status' => 'required',
            'applied_date' => 'required|date',
            'location' => 'nullable|string',
            'notes' => 'nullable|string',
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
