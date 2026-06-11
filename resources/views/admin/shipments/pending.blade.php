@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-4 sm:py-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
        <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Pending Shipment Requests</h1>
        <div class="mt-2 sm:mt-0">
            <span class="text-sm text-gray-600">{{ $shipments->count() }} pending requests</span>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        @if($shipments->isEmpty())
            <div class="p-8 text-center text-gray-500">
                <p class="text-lg">No pending shipment requests.</p>
                <p class="text-sm mt-2">All shipment requests have been processed.</p>
            </div>
        @else
            <!-- Mobile: Card Layout -->
            <div class="block sm:hidden">
                @foreach($shipments as $shipment)
                    <div class="border-b border-gray-200 p-4">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h3 class="font-semibold text-gray-900">{{ $shipment->tracking_number }}</h3>
                                <p class="text-sm text-gray-600">{{ $shipment->service_type }}</p>
                            </div>
                            <div class="text-right">
                                <span class="inline-block px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">
                                    Pending
                                </span>
                            </div>
                        </div>
                        
                        <div class="space-y-2 text-sm">
                            <div>
                                <span class="text-gray-500">Customer:</span>
                                <span class="ml-1 font-medium">{{ optional($shipment->user)->name ?? 'N/A' }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Email:</span>
                                <span class="ml-1">{{ optional($shipment->user)->email ?? 'N/A' }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Total Weight:</span>
                                <span class="ml-1 font-medium">{{ $shipment->total_weight }} kg</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Packages:</span>
                                <span class="ml-1 font-medium">{{ $shipment->packages->count() }}</span>
                            </div>
                        </div>
                        
                        <div class="mt-4 flex gap-2">
                            <a href="{{ route('admin.shipments.show', $shipment->id) }}" 
                               class="bg-blue-500 text-white px-3 py-2 rounded text-sm hover:bg-blue-600 transition">
                                View Details
                            </a>
                            <form action="{{ route('admin.shipments.approve', $shipment->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-green-500 text-white px-3 py-2 rounded text-sm hover:bg-green-600 transition">
                                    Approve
                                </button>
                            </form>
                            <form action="{{ route('admin.shipments.reject', $shipment->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-red-500 text-white px-3 py-2 rounded text-sm hover:bg-red-600 transition">
                                    Reject
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Desktop: Table Layout -->
            <div class="hidden sm:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tracking #</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Weight</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Packages</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($shipments as $shipment)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $shipment->tracking_number }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div>{{ optional($shipment->user)->name ?? 'N/A' }}</div>
                                    <div class="text-xs text-gray-400">{{ optional($shipment->user)->email ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $shipment->service_type }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $shipment->total_weight }} kg</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $shipment->packages->count() }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                    <a href="{{ route('admin.shipments.show', $shipment->id) }}" 
                                       class="text-blue-600 hover:text-blue-900">View</a>
                                    <form action="{{ route('admin.shipments.approve', $shipment->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-green-600 hover:text-green-900">Approve</button>
                                    </form>
                                    <form action="{{ route('admin.shipments.reject', $shipment->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-red-600 hover:text-red-900">Reject</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection 