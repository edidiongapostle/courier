@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-4 sm:py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Package Status Log</h1>
            <a href="{{ route('admin.packages.status', $package->id) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                ← Back to Status Update
            </a>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 mb-6">
            <div class="mb-6">
                <h2 class="text-lg sm:text-xl font-semibold text-gray-900 mb-2">Package Information</h2>
                <div class="bg-gray-50 rounded-lg p-4 space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Barcode:</span>
                        <span class="font-medium">{{ $package->barcode }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Shipment:</span>
                        <span class="font-medium">{{ $package->shipment->tracking_number }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Current Status:</span>
                        <span class="inline-block px-2 py-1 text-xs rounded-full 
                            @if($package->status === 'Pending') bg-yellow-100 text-yellow-800
                            @elseif($package->status === 'In Transit') bg-blue-100 text-blue-800
                            @elseif($package->status === 'Delivered') bg-green-100 text-green-800
                            @elseif($package->status === 'On Hold') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ $package->status }}
                        </span>
                    </div>
                </div>
            </div>
            
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Status History</h3>
            
            <!-- Mobile: Card Layout -->
            <div class="block sm:hidden space-y-4">
                @forelse($logs as $log)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between items-start mb-2">
                            <span class="inline-block px-2 py-1 text-xs rounded-full 
                                @if($log->status === 'Pending') bg-yellow-100 text-yellow-800
                                @elseif($log->status === 'In Transit') bg-blue-100 text-blue-800
                                @elseif($log->status === 'Delivered') bg-green-100 text-green-800
                                @elseif($log->status === 'On Hold') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ $log->status }}
                            </span>
                            <span class="text-xs text-gray-500">{{ $log->changed_at ?? $log->created_at }}</span>
                        </div>
                        <div class="text-sm text-gray-600 mb-2">
                            Updated by: {{ optional($log->admin)->name ?? 'System' }}
                        </div>
                        @if($log->note)
                            <div class="text-sm text-gray-700 bg-gray-50 p-2 rounded">
                                {{ $log->note }}
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="text-center text-gray-500 py-8">
                        <p>No status updates found.</p>
                    </div>
                @endforelse
            </div>

            <!-- Desktop: Table Layout -->
            <div class="hidden sm:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Updated By</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Changed At</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Note</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($logs as $log)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-block px-2 py-1 text-xs rounded-full 
                                        @if($log->status === 'Pending') bg-yellow-100 text-yellow-800
                                        @elseif($log->status === 'In Transit') bg-blue-100 text-blue-800
                                        @elseif($log->status === 'Delivered') bg-green-100 text-green-800
                                        @elseif($log->status === 'On Hold') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ $log->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ optional($log->admin)->name ?? 'System' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $log->changed_at ?? $log->created_at }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $log->note ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">No status updates found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 