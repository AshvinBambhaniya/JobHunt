@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Edit Job Application</h1>
        <a href="{{ route('job-applications.index') }}" class="text-gray-600 hover:text-gray-800 transition">
            &larr; Back to all applications
        </a>
    </div>

    <div class="bg-white p-8 rounded-lg shadow-lg">
        <form action="{{ route('job-applications.update', $jobApplication->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="company_name" class="block text-sm font-medium text-gray-700 mb-1">Company Name</label>
                    <input type="text" name="company_name" id="company_name" value="{{ $jobApplication->company_name }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <input type="text" name="role" id="role" value="{{ $jobApplication->role }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                    <input type="text" name="location" id="location" value="{{ $jobApplication->location }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="applied" @if($jobApplication->status == 'applied') selected @endif>Applied</option>
                        <option value="shortlisted" @if($jobApplication->status == 'shortlisted') selected @endif>Shortlisted</option>
                        <option value="interviewed" @if($jobApplication->status == 'interviewed') selected @endif>Interviewed</option>
                        <option value="offer" @if($jobApplication->status == 'offer') selected @endif>Offer</option>
                        <option value="rejected" @if($jobApplication->status == 'rejected') selected @endif>Rejected</option>
                    </select>
                </div>
                <div>
                    <label for="job_type" class="block text-sm font-medium text-gray-700 mb-1">Job Type</label>
                    <select name="job_type" id="job_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="remote" @if($jobApplication->job_type->value == 'remote') selected @endif>Remote</option>
                        <option value="onsite" @if($jobApplication->job_type->value == 'onsite') selected @endif>Onsite</option>
                        <option value="hybrid" @if($jobApplication->job_type->value == 'hybrid') selected @endif>Hybrid</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label for="applied_date" class="block text-sm font-medium text-gray-700 mb-1">Applied Date</label>
                    <input type="date" name="applied_date" id="applied_date" value="{{ $jobApplication->applied_date }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div class="md:col-span-2">
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                    <textarea name="notes" id="notes" rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">{{ $jobApplication->notes }}</textarea>
                </div>
            </div>

            <div class="mt-8 flex justify-end">
                <a href="{{ route('job-applications.index') }}" class="bg-gray-200 text-gray-800 px-6 py-2 rounded-lg hover:bg-gray-300 transition mr-4">Cancel</a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">Update Application</button>
            </div>
        </form>
    </div>
</div>
@endsection
