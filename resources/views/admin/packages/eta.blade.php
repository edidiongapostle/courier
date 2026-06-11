@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-4 sm:py-8">
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Update Package ETA</h1>
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
                        <span class="text-gray-600">Current ETA:</span>
                        <span class="font-medium">{{ $package->eta ?? 'Not set' }}</span>
                    </div>
                </div>
            </div>
            
            <form method="POST" action="{{ route('admin.packages.eta.update', $package->id) }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">New ETA</label>
                    <input type="datetime-local" name="eta" 
                           class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                           required>
                    <p class="text-xs text-gray-500 mt-1">Select the expected delivery date and time</p>
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