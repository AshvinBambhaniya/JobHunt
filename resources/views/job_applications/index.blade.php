@extends('layouts.app')

@section('content')
<div>
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold text-gray-800">My Job Applications</h2>
        <a href="{{ route('job-applications.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-indigo-700 transition">
            Add New Application
        </a>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-6">
        <form action="{{ route('job-applications.index') }}" method="GET">
            <div class="flex flex-col lg:flex-row gap-4 items-end">
                <!-- Search -->
                <div class="w-full lg:flex-1">
                    <label for="search" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" 
                            class="pl-10 block w-full rounded-lg border-gray-300 bg-gray-50 focus:bg-white focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-150 ease-in-out py-2.5" 
                            placeholder="Company, Role...">
                    </div>
                </div>

                <!-- Status Filter -->
                <div class="w-full sm:w-1/2 lg:w-48">
                    <label for="status" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Status</label>
                    <select name="status" id="status" class="block w-full rounded-lg border-gray-300 bg-gray-50 focus:bg-white focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm py-2.5">
                        <option value="">All Statuses</option>
                        <option value="applied" @if(request('status') == 'applied') selected @endif>Applied</option>
                        <option value="shortlisted" @if(request('status') == 'shortlisted') selected @endif>Shortlisted</option>
                        <option value="interviewed" @if(request('status') == 'interviewed') selected @endif>Interviewed</option>
                        <option value="offer" @if(request('status') == 'offer') selected @endif>Offer</option>
                        <option value="rejected" @if(request('status') == 'rejected') selected @endif>Rejected</option>
                    </select>
                </div>

                <!-- Job Type Filter -->
                <div class="w-full sm:w-1/2 lg:w-48">
                    <label for="job_type" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Job Type</label>
                    <select name="job_type" id="job_type" class="block w-full rounded-lg border-gray-300 bg-gray-50 focus:bg-white focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm py-2.5">
                        <option value="">All Types</option>
                        @foreach($jobTypes as $type)
                            <option value="{{ $type->value }}" @if(request('job_type') == $type->value) selected @endif>{{ ucfirst($type->value) }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Actions -->
                <div class="flex gap-2 w-full lg:w-auto mt-2 lg:mt-0">
                    <button type="submit" class="flex-1 lg:flex-none inline-flex justify-center items-center px-4 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        Filter
                    </button>
                    
                    <a href="{{ route('job-applications.index') }}" class="flex-1 lg:flex-none inline-flex justify-center items-center px-4 py-2.5 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors" title="Reset Filters">
                        <svg class="h-4 w-4 lg:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        <span class="hidden lg:inline">Reset</span>
                    </a>

                    <a href="{{ route('job-applications.export', request()->query()) }}" class="flex-1 lg:flex-none inline-flex justify-center items-center px-4 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors" title="Export CSV">
                        <svg class="h-4 w-4 lg:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        <span class="hidden lg:inline">Export</span>
                    </a>
                </div>
            </div>
        </form>
    </div>

    @if($applications->isEmpty())
        <div class="text-center py-20 bg-white rounded-lg shadow">
            <svg class="w-16 h-16 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            <p class="mt-4 text-xl font-semibold text-gray-600">No applications found.</p>
            <p class="text-gray-500 mt-2">Try adjusting your search or filters.</p>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Company Name</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Job Type</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Salary</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applied</th>
                        <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($applications as $app)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-900">{{ $app->company_name }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-600">{{ $app->role }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-600">{{ $app->location }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-600">{{ ucfirst($app->job_type->value) }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-600">${{ number_format($app->expected_salary, 0) }}</td>
                            <td class="px-4 py-2 whitespace-nowrap">
                                @php
                                    $statusColor = [
                                        'applied' => 'bg-blue-100 text-blue-800',
                                        'shortlisted' => 'bg-yellow-100 text-yellow-800',
                                        'interviewed' => 'bg-purple-100 text-purple-800',
                                        'offer' => 'bg-green-100 text-green-800',
                                        'rejected' => 'bg-red-100 text-red-800',
                                    ][$app->status] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColor }}">
                                    {{ ucfirst($app->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-600">{{ \Carbon\Carbon::parse($app->applied_date)->format('M d, Y') }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end items-center">
                                    <a href="{{ route('job-applications.show', $app->id) }}" class="text-gray-500 hover:text-indigo-600 p-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                    </a>
                                    <a href="{{ route('job-applications.edit', $app->id) }}" class="text-gray-500 hover:text-indigo-600 p-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.5L16.732 3.732z" /></svg>
                                    </a>
                                    <form action="{{ route('job-applications.destroy', $app->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this application?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-500 hover:text-red-600 p-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $applications->appends(request()->query())->links() }}
        </div>
    @endif
</div>
@endsection


