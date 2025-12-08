@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md">
        <div class="bg-white p-8 rounded-xl shadow-lg">
            <h2 class="text-3xl font-bold mb-6 text-center text-gray-800">Welcome Back</h2>

            <form action="{{ route('login') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Email Address</label>
                    <input type="email" name="email" class="w-full border rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" required autofocus>
                    @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                    <input type="password" name="password" class="w-full border rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" required>
                </div>

                <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-indigo-700 transition">
                    Login
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-gray-600">
                Don't have an account? <a href="{{ route('register') }}" class="text-indigo-600 hover:underline font-semibold">Register here</a>
            </p>
        </div>
    </div>
</div>
@endsection