@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gray-100 px-4">
    <div class="w-full max-w-sm sm:max-w-md p-6 sm:p-8 bg-white rounded-lg shadow-lg">
        <div class="text-center mb-6">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Admin Login</h2>
            <p class="text-sm text-gray-600 mt-2">Access the admin dashboard</p>
        </div>
        
        <form method="POST" action="{{ route('admin.login') }}">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                <input id="email" type="email" name="email" required autofocus 
                       class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                       placeholder="admin@example.com">
            </div>
            
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input id="password" type="password" name="password" required 
                       class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                       placeholder="Enter your password">
            </div>
            
            <div class="mb-6 flex items-center">
                <input type="checkbox" name="remember" id="remember" 
                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="remember" class="ml-2 block text-sm text-gray-700">Remember me</label>
            </div>
            
            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                    <p class="text-sm text-red-600">{{ $errors->first() }}</p>
                </div>
            @endif
            
            <button type="submit" 
                    class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 text-sm">
                Sign In to Admin Panel
            </button>
        </form>
        
        <div class="mt-6 text-center">
            <a href="/" class="text-sm text-blue-600 hover:text-blue-500">← Back to Home</a>
        </div>
    </div>
</div>
@endsection 