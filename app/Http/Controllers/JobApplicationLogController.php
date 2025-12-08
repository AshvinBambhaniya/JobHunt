<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobApplicationLogController extends Controller
{
    public function store(Request $request, JobApplication $jobApplication)
    {
        $validated = $request->validate([
            'status' => 'required|string|max:255',
            'event_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        DB::transaction(function () use ($jobApplication, $validated) {
            $jobApplication->logs()->create($validated);
            $jobApplication->update(['status' => $validated['status']]);
        });

        return redirect()->route('job-applications.show', $jobApplication)
            ->with('success', 'Process log added successfully!');
    }
}
