@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-4 sm:py-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
        <h1 class="text-xl sm:text-2xl font-bold text-gray-900">All Shipments</h1>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('admin.shipments.create') }}" 
               class="inline-flex items-center bg-green-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-green-700 transition">
                <span class="mr-2">+</span> Create Shipment
            </a>
        </div>
    </div>
    
    @if(session('status'))
        <div class="mb-4 p-3 bg-green-100 border border-green-200 text-green-800 rounded-lg text-sm">{{ session('status') }}</div>
    @endif
    @if($errors->has('status'))
        <div class="mb-4 p-3 bg-red-100 border border-red-200 text-red-800 rounded-lg text-sm">{{ $errors->first('status') }}</div>
    @endif
    
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Mobile: Card Layout -->
        <div class="block sm:hidden">
            @forelse($shipments as $shipment)
                <div class="border-b border-gray-200 p-4">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <h3 class="font-semibold text-gray-900">{{ $shipment->tracking_number }}</h3>
                            <p class="text-sm text-gray-600">{{ $shipment->service_type }}</p>
                        </div>
                        <div class="text-right">
                            <span class="inline-block px-2 py-1 text-xs rounded-full 
                                @if($shipment->status === 'Pending') bg-yellow-100 text-yellow-800
                                @elseif($shipment->status === 'In Transit') bg-blue-100 text-blue-800
                                @elseif($shipment->status === 'Delivered') bg-green-100 text-green-800
                                @elseif($shipment->status === 'On Hold') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ $shipment->status }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="space-y-2 text-sm mb-4">
                        <div>
                            <span class="text-gray-500">Customer:</span>
                            <span class="ml-1 font-medium">{{ optional($shipment->user)->name ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Created:</span>
                            <span class="ml-1">{{ $shipment->created_at->format('M d, Y H:i') }}</span>
                        </div>
                    </div>
                    
                    <div class="flex flex-wrap gap-2 mb-3">
                        <a href="{{ route('admin.shipments.show', $shipment->id) }}" 
                           class="bg-blue-500 text-white px-3 py-1 rounded text-xs hover:bg-blue-600 transition">
                            View
                        </a>
                        <a href="{{ route('admin.shipments.edit', $shipment->id) }}" 
                           class="bg-yellow-500 text-white px-3 py-1 rounded text-xs hover:bg-yellow-600 transition">
                            Edit
                        </a>
                    </div>
                    
                    <!-- Mobile Status Update -->
                    <form method="POST" action="{{ route('admin.shipments.status.update', $shipment->id) }}" 
                          class="mt-3" onsubmit="return confirm('Update status for this shipment?');">
                        @csrf
                        <div class="flex gap-2">
                            <select name="status" class="flex-1 border border-gray-300 rounded px-2 py-1 text-xs">
                                @foreach(['Pending', 'Processing', 'Shipped', 'In Transit', 'On Hold', 'Delivered', 'Cancelled', 'Returned'] as $status)
                                    <option value="{{ $status }}" @if($shipment->status == $status) selected @endif>{{ $status }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded text-xs hover:bg-green-700 transition">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            @empty
                <div class="p-8 text-center text-gray-500">
                    <p>No shipments found.</p>
                </div>
            @endforelse
        </div>

        <!-- Desktop: Table Layout -->
        <div class="hidden sm:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tracking #</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($shipments as $shipment)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $shipment->tracking_number }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ optional($shipment->user)->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-block px-2 py-1 text-xs rounded-full 
                                    @if($shipment->status === 'Pending') bg-yellow-100 text-yellow-800
                                    @elseif($shipment->status === 'In Transit') bg-blue-100 text-blue-800
                                    @elseif($shipment->status === 'Delivered') bg-green-100 text-green-800
                                    @elseif($shipment->status === 'On Hold') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ $shipment->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $shipment->service_type }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $shipment->created_at->format('M d, Y H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                <a href="{{ route('admin.shipments.show', $shipment->id) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                <a href="{{ route('admin.shipments.edit', $shipment->id) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                <form method="POST" action="{{ route('admin.shipments.status.update', $shipment->id) }}" class="inline" onsubmit="return confirm('Are you sure you want to update the status for this shipment?');">
                                    @csrf
                                    <select name="status" class="border rounded px-2 py-1 text-xs">
                                        @foreach(['Pending', 'Processing', 'Shipped', 'In Transit', 'On Hold', 'Delivered', 'Cancelled', 'Returned'] as $status)
                                            <option value="{{ $status }}" @if($shipment->status == $status) selected @endif>{{ $status }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="bg-green-600 text-white px-2 py-1 rounded text-xs ml-1 hover:bg-green-700 transition">Update</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">No shipments found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-4 py-3 border-t border-gray-200">
            {{ $shipments->links() }}
        </div>
    </div>
</div>
@endsection 