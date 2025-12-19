@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Notifications</h1>
        <form action="{{ route('notifications.readAll') }}" method="POST">
            @csrf
            <button type="submit" class="text-sm text-indigo-600 hover:text-indigo-800 font-semibold">Mark all as read</button>
        </form>
    </div>

    @if($notifications->isEmpty())
        <div class="bg-white p-8 rounded-xl shadow-lg text-center text-gray-500">
            No notifications found.
        </div>
    @else
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <ul class="divide-y divide-gray-200">
                @foreach($notifications as $notification)
                    <li class="p-4 hover:bg-gray-50 transition {{ $notification->read_at ? 'opacity-60' : 'bg-blue-50' }}">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="font-bold text-gray-800">{{ $notification->data['title'] ?? 'Notification' }}</h4>
                                <p class="text-gray-600 mt-1">{{ $notification->data['message'] ?? '' }}</p>
                                <p class="text-xs text-gray-400 mt-2">{{ $notification->created_at->diffForHumans() }}</p>
                            </div>
                            @if(!$notification->read_at)
                                <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-xs bg-indigo-100 text-indigo-700 px-2 py-1 rounded hover:bg-indigo-200 transition">Mark Read</button>
                                </form>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="mt-4">
            {{ $notifications->links() }}
        </div>
    @endif
</div>
@endsection
