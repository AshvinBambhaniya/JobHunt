<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    // 1. Show all applications
    public function index()
    {
        $applications = JobApplication::latest()->get();
        return view('job_applications.index', compact('applications'));
    }

    // 2. Show the form to create a new one
    public function create()
    {
        return view('job_applications.create');
    }

    // 3. Save the new application to DB
    public function store(Request $request)
    {
        // Validation: Ensure we have the required data
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'status' => 'required',
            'applied_date' => 'required|date',
            'location' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        JobApplication::create($validated);

        return redirect()->route('job-applications.index')
            ->with('success', 'Job Application added successfully!');
    }

    // 4. Show the form to edit an existing one
    public function edit(JobApplication $jobApplication)
    {
        return view('job_applications.edit', compact('jobApplication'));
    }

    // 5. Update the changes in DB
    public function update(Request $request, JobApplication $jobApplication)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'status' => 'required',
            'applied_date' => 'required|date',
            'location' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $jobApplication->update($validated);

        return redirect()->route('job-applications.index')
            ->with('success', 'Application updated!');
    }

    // 6. Delete an application
    public function destroy(JobApplication $jobApplication)
    {
        $jobApplication->delete();

        return redirect()->route('job-applications.index')
            ->with('success', 'Application deleted');
    }
}