@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-4 sm:py-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
        <h1 class="text-xl sm:text-2xl font-bold text-gray-900">All Users</h1>
        <div class="mt-2 sm:mt-0">
            <span class="text-sm text-gray-600">Total: {{ $users->total() }} users</span>
        </div>
    </div>
    
    @if(session('status'))
        <div class="mb-4 p-3 bg-green-100 border border-green-200 text-green-800 rounded-lg text-sm">{{ session('status') }}</div>
    @endif
    
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Mobile: Card Layout -->
        <div class="block sm:hidden">
            @forelse($users as $user)
                <div class="border-b border-gray-200 p-4">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <h3 class="font-semibold text-gray-900">{{ $user->name }}</h3>
                            <p class="text-sm text-gray-600">{{ $user->email }}</p>
                        </div>
                        <div class="text-right">
                            <span class="inline-block px-2 py-1 text-xs rounded-full 
                                @if($user->role === 'admin') bg-purple-100 text-purple-800
                                @else bg-blue-100 text-blue-800 @endif">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-2 mb-3 text-sm">
                        <div>
                            <span class="text-gray-500">Verified:</span>
                            <span class="ml-1 @if($user->is_verified) text-green-600 @else text-red-600 @endif">
                                {{ $user->is_verified ? 'Yes' : 'No' }}
                            </span>
                        </div>
                        <div>
                            <span class="text-gray-500">Blocked:</span>
                            <span class="ml-1 @if($user->is_blocked) text-red-600 @else text-green-600 @endif">
                                {{ $user->is_blocked ? 'Yes' : 'No' }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="text-xs text-gray-500 mb-3">
                        Created: {{ $user->created_at->format('M d, Y H:i') }}
                    </div>
                    
                    <div class="flex flex-wrap gap-2">
                        @if(!$user->is_verified)
                            <form action="{{ route('admin.users.verify', $user->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded text-xs hover:bg-blue-600 transition">
                                    Verify
                                </button>
                            </form>
                        @endif
                        
                        @if(!$user->is_blocked)
                            <form action="{{ route('admin.users.block', $user->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-yellow-500 text-white px-3 py-1 rounded text-xs hover:bg-yellow-600 transition">
                                    Block
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin.users.unblock', $user->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded text-xs hover:bg-green-600 transition">
                                    Unblock
                                </button>
                            </form>
                        @endif
                        
                        <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded text-xs hover:bg-red-700 transition">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-gray-500">
                    <p>No users found.</p>
                </div>
            @endforelse
        </div>

        <!-- Desktop: Table Layout -->
        <div class="hidden sm:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Verified</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Blocked</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-block px-2 py-1 text-xs rounded-full 
                                    @if($user->role === 'admin') bg-purple-100 text-purple-800
                                    @else bg-blue-100 text-blue-800 @endif">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-block px-2 py-1 text-xs rounded-full 
                                    @if($user->is_verified) bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ $user->is_verified ? 'Yes' : 'No' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-block px-2 py-1 text-xs rounded-full 
                                    @if($user->is_blocked) bg-red-100 text-red-800
                                    @else bg-green-100 text-green-800 @endif">
                                    {{ $user->is_blocked ? 'Yes' : 'No' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->created_at->format('M d, Y H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm space-x-1">
                                @if(!$user->is_verified)
                                    <form action="{{ route('admin.users.verify', $user->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded text-xs hover:bg-blue-600 transition">Verify</button>
                                    </form>
                                @endif
                                @if(!$user->is_blocked)
                                    <form action="{{ route('admin.users.block', $user->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-yellow-500 text-white px-2 py-1 rounded text-xs hover:bg-yellow-600 transition">Block</button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.users.unblock', $user->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-green-500 text-white px-2 py-1 rounded text-xs hover:bg-green-600 transition">Unblock</button>
                                    </form>
                                @endif
                                <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 text-white px-2 py-1 rounded text-xs hover:bg-red-700 transition">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-4 py-3 border-t border-gray-200">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection 