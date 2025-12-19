@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">{{ $jobApplication->company_name }} - {{ $jobApplication->role }}</h2>
            <p class="text-gray-600 mt-1">{{ $jobApplication->location }}</p>
        </div>
        <a href="{{ route('job-applications.index') }}" class="text-gray-600 hover:text-gray-800 transition flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to all applications
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md" role="alert">
        <p class="font-bold">Success</p>
        <p>{{ session('success') }}</p>
    </div>
    @endif

    @if($errors->any())
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md" role="alert">
        <p class="font-bold">Errors</p>
        <ul class="list-disc ml-5">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-lg p-8">
                <h3 class="text-2xl font-bold text-gray-800 mb-6">Process Timeline</h3>
                <div class="relative">
                    <div class="border-l-2 border-gray-200 absolute h-full left-3 top-0"></div>
                    @forelse($jobApplication->logs->sortByDesc('event_date') as $log)
                        <div class="flex items-start mb-8">
                            <div class="w-6 h-6 bg-indigo-600 rounded-full flex items-center justify-center -ml-0.5">
                                <div class="w-3 h-3 bg-white rounded-full"></div>
                            </div>
                            <div class="ml-6">
                                <p class="text-lg font-semibold text-gray-800">{{ ucfirst($log->status) }}</p>
                                <p class="text-sm text-gray-500">{{ $log->event_date->format('F d, Y - h:i A') }}</p>
                                @if($log->notes)
                                    <div class="mt-2 text-gray-600 bg-gray-50 p-4 rounded-lg">
                                        {{ $log->notes }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="flex items-center">
                            <div class="w-6 h-6 bg-gray-300 rounded-full"></div>
                            <div class="ml-6 text-gray-500">
                                No process logs yet.
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Reminders Section -->
            <div class="bg-white rounded-xl shadow-lg p-8 mt-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-800">Reminders</h3>
                </div>
                
                @if($jobApplication->reminders->isNotEmpty())
                    <div class="space-y-4 mb-8">
                        @foreach($jobApplication->reminders as $reminder)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-100">
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $reminder->message }}</p>
                                    <p class="text-sm text-gray-500">
                                        Due: {{ $reminder->scheduled_at->format('M d, Y h:i A') }}
                                        <span class="ml-2 px-2 py-0.5 rounded text-xs {{ $reminder->status->value === 'pending' ? 'bg-yellow-100 text-yellow-800' : ($reminder->status->value === 'sent' ? 'bg-green-100 text-green-800' : 'bg-gray-100') }}">
                                            {{ ucfirst($reminder->status->value) }}
                                        </span>
                                    </p>
                                </div>
                                <form action="{{ route('reminders.destroy', $reminder->id) }}" method="POST" onsubmit="return confirm('Delete reminder?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('reminders.store', $jobApplication) }}" method="POST" class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                    @csrf
                    <h4 class="font-bold text-gray-700 mb-4">Set a new reminder</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                            <input type="text" name="message" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" placeholder="e.g. Follow up email" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Date & Time</label>
                            <input type="datetime-local" name="scheduled_at" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" required>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-indigo-700 transition">Set Reminder</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div>
            @if($jobApplication->notes)
            <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                <h3 class="text-2xl font-bold text-gray-800 mb-6">Notes</h3>
                <div class="text-gray-600">
                    {!! nl2br(e($jobApplication->notes)) !!}
                </div>
            </div>
            @endif
            <div class="bg-white rounded-xl shadow-lg p-8">
                <h3 class="text-2xl font-bold text-gray-800 mb-6">Add New Log</h3>
                <form action="{{ route('job-applications.logs.store', $jobApplication) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" id="status" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition" required>
                            <option value="shortlisted">Shortlisted</option>
                            <option value="interviewed">Interviewed</option>
                            <option value="offer">Offer</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="event_date" class="block text-sm font-medium text-gray-700 mb-2">Event Date</label>
                        <input type="datetime-local" name="event_date" id="event_date" value="{{ now()->format('Y-m-d\TH:i') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition" required>
                    </div>
                    <div class="mb-6">
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                        <textarea name="notes" id="notes" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition"></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="w-full bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">Add Log</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

