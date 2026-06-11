@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-4 sm:py-8">
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Update Package Status</h1>
            <a href="{{ url()->previous() }}" class="text-blue-600 hover:text-blue-800 text-sm">
                ← Back
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
            
            <form method="POST" action="{{ route('admin.packages.status.update', $package->id) }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">New Status</label>
                    <select name="status" class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm" required>
                        @foreach($statuses as $status)
                            <option value="{{ $status }}" @if($package->status == $status) selected @endif>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Note (optional)</label>
                    <textarea name="note" rows="3" 
                              class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                              placeholder="Add any additional notes about this status update..."></textarea>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-3 pt-4">
                    <button type="submit" 
                            class="w-full sm:w-auto bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                        Update Status
                    </button>
                    <a href="{{ route('admin.packages.status.log', $package->id) }}" 
                       class="w-full sm:w-auto bg-gray-100 text-gray-700 px-6 py-3 rounded-lg font-medium hover:bg-gray-200 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition text-center">
                        View Status Log
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 