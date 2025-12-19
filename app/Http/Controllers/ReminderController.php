<?php

namespace App\Http\Controllers;

use App\Enums\ReminderStatus;
use App\Enums\ReminderType;
use App\Models\JobApplication;
use App\Models\Reminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReminderController extends Controller
{
    public function store(Request $request, JobApplication $jobApplication)
    {
        if ($jobApplication->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'message' => 'required|string|max:255',
            'scheduled_at' => 'required|date|after:now',
        ]);

        $jobApplication->reminders()->create([
            'user_id' => Auth::id(),
            'type' => ReminderType::MANUAL,
            'status' => ReminderStatus::PENDING,
            'message' => $validated['message'],
            'scheduled_at' => $validated['scheduled_at'],
        ]);

        return back()->with('success', 'Reminder scheduled successfully.');
    }

    public function destroy(Reminder $reminder)
    {
        if ($reminder->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $reminder->delete();

        return back()->with('success', 'Reminder removed.');
    }
}
