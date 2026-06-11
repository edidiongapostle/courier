@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-4 sm:py-8">
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Update Shipment ETA</h1>
            <a href="{{ url()->previous() }}" class="text-blue-600 hover:text-blue-800 text-sm">
                ← Back
            </a>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 mb-6">
            <div class="mb-6">
                <h2 class="text-lg sm:text-xl font-semibold text-gray-900 mb-2">Shipment Information</h2>
                <div class="bg-gray-50 rounded-lg p-4 space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tracking Number:</span>
                        <span class="font-medium">{{ $shipment->tracking_number }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Current ETA:</span>
                        <span class="font-medium">{{ $shipment->eta ?? 'Not set' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Status:</span>
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
            </div>
            
            <form method="POST" action="{{ route('admin.shipments.eta.update', $shipment->id) }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">New ETA</label>
                    <input type="datetime-local" name="eta" 
                           class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                           required>
                    <p class="text-xs text-gray-500 mt-1">Select the expected delivery date and time for the entire shipment</p>
                </div>
                
                <div class="pt-4">
                    <button type="submit" 
                            class="w-full bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                        Update ETA
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 