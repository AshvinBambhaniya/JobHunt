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
    <div class="bg-white rounded-xl shadow-lg p-4 mb-4">
        <form action="{{ route('job-applications.index') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div class="md:col-span-2">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition" placeholder="Search by company or role...">
                </div>
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition">
                        <option value="">All</option>
                        <option value="applied" @if(request('status') == 'applied') selected @endif>Applied</option>
                        <option value="shortlisted" @if(request('status') == 'shortlisted') selected @endif>Shortlisted</option>
                        <option value="interviewed" @if(request('status') == 'interviewed') selected @endif>Interviewed</option>
                        <option value="offer" @if(request('status') == 'offer') selected @endif>Offer</option>
                        <option value="rejected" @if(request('status') == 'rejected') selected @endif>Rejected</option>
                    </select>
                </div>
                <div>
                    <label for="job_type" class="block text-sm font-medium text-gray-700 mb-1">Job Type</label>
                    <select name="job_type" id="job_type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition">
                        <option value="">All</option>
                        @foreach($jobTypes as $type)
                            <option value="{{ $type->value }}" @if(request('job_type') == $type->value) selected @endif>{{ ucfirst($type->value) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-end items-end">
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-indigo-700 transition">Filter</button>
                    <a href="{{ route('job-applications.index') }}" class="ml-4 bg-gray-200 text-gray-800 px-4 py-2 rounded-lg font-semibold hover:bg-gray-300 transition">Reset</a>
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
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-600">{{ $app->applied_date->format('M d, Y') }}</td>
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


