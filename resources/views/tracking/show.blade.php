@extends('layouts.app')

@section('content')
@php
    // Handle different status scenarios
    $currentStatus = $shipment->status;
    $hasHold = ($currentStatus === 'On Hold') || (optional($shipment->statusLogs->last())->status === 'On Hold');
    $isCancelled = $currentStatus === 'Cancelled';
    $isReturned = $currentStatus === 'Returned';
    
    // Define status arrays based on current status
    if ($isCancelled) {
        // Get the status history to show the progression before cancellation
        $statusHistory = $shipment->statusLogs->sortBy('changed_at')->pluck('status')->unique()->values();
        
        // Remove 'Cancelled' from history and add it at the end
        $statusHistory = $statusHistory->filter(function($status) {
            return $status !== 'Cancelled';
        })->push('Cancelled');
        
        $statuses = $statusHistory->toArray();
        
        // Define icons for all possible statuses
        $allStatusIcons = [
            'Pending' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
            'Processed' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2l4-4" /></svg>',
            'Processing' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>',
            'Shipped' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h13v8H3z M16 10h4v8h-4z M5 18v2a1 1 0 001 1h2a1 1 0 001-1v-2" /></svg>',
            'In Transit' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 13h2l.4 2M7 13h10l1.4-2.8A1 1 0 0017.6 9H6.4a1 1 0 00-.9.6L3 13zm0 0v6a1 1 0 001 1h12a1 1 0 001-1v-6" /></svg>',
            'En Route' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 13h2l.4 2M7 13h10l1.4-2.8A1 1 0 0017.6 9H6.4a1 1 0 00-.9.6L3 13zm0 0v6a1 1 0 001 1h12a1 1 0 001-1v-6" /></svg>',
            'On Hold' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="12" cy="12" r="10" stroke-width="2" /><rect x="9" y="9" width="6" height="6" rx="1" fill="currentColor" /></svg>',
            'Dispatched for Delivery' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>',
            'Delivered' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-2a4 4 0 014-4h10a4 4 0 014 4v2" /></svg>',
            'Arrived' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-2a4 4 0 014-4h10a4 4 0 014 4v2" /></svg>',
            'Cancelled' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>',
        ];
        
        // Build status icons array based on actual statuses in history
        $statusIcons = [];
        foreach ($statuses as $status) {
            $statusIcons[$status] = $allStatusIcons[$status] ?? $allStatusIcons['Processed'];
        }
        
        // Build status map based on actual statuses
        $statusMap = [];
        foreach ($statuses as $index => $status) {
            $statusMap[$status] = $index;
        }
    } elseif ($isReturned) {
        $statuses = ['Processed', 'Shipped', 'En Route', 'Returned'];
        $statusIcons = [
            'Processed' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2l4-4" /></svg>',
            'Shipped' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h13v8H3z M16 10h4v8h-4z M5 18v2a1 1 0 001 1h2a1 1 0 001-1v-2" /></svg>',
            'En Route' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 13h2l.4 2M7 13h10l1.4-2.8A1 1 0 0017.6 9H6.4a1 1 0 00-.9.6L3 13zm0 0v6a1 1 0 001 1h12a1 1 0 001-1v-6" /></svg>',
            'Returned' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" /></svg>',
        ];
        $statusMap = [
            'Pending' => 0,
            'Processed' => 0,
            'Processing' => 1,
            'Shipped' => 1,
            'In Transit' => 2,
            'Dispatched for Delivery' => 2,
            'Returned' => 3,
        ];
    } elseif ($hasHold) {
        $statuses = ['Processed', 'Shipped', 'En Route', 'On Hold', 'Arrived'];
        $statusIcons = [
            'Processed' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2l4-4" /></svg>',
            'Shipped' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h13v8H3z M16 10h4v8h-4z M5 18v2a1 1 0 001 1h2a1 1 0 001-1v-2" /></svg>',
            'En Route' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 13h2l.4 2M7 13h10l1.4-2.8A1 1 0 0017.6 9H6.4a1 1 0 00-.9.6L3 13zm0 0v6a1 1 0 001 1h12a1 1 0 001-1v-6" /></svg>',
            'On Hold' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="12" cy="12" r="10" stroke-width="2" /><rect x="9" y="9" width="6" height="6" rx="1" fill="currentColor" /></svg>',
            'Arrived' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-2a4 4 0 014-4h10a4 4 0 014 4v2" /></svg>',
        ];
        $statusMap = [
            'Pending' => 0,
            'Processed' => 0,
            'Processing' => 1,
            'Shipped' => 1,
            'In Transit' => 2,
            'On Hold' => 3,
            'Dispatched for Delivery' => 2,
            'Delivered' => 4,
            'Arrived' => 4,
        ];
    } else {
        $statuses = ['Processed', 'Shipped', 'En Route', 'Arrived'];
        $statusIcons = [
            'Processed' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2l4-4" /></svg>',
            'Shipped' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h13v8H3z M16 10h4v8h-4z M5 18v2a1 1 0 001 1h2a1 1 0 001-1v-2" /></svg>',
            'En Route' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 13h2l.4 2M7 13h10l1.4-2.8A1 1 0 0017.6 9H6.4a1 1 0 00-.9.6L3 13zm0 0v6a1 1 0 001 1h12a1 1 0 001-1v-6" /></svg>',
            'Arrived' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-2a4 4 0 014-4h10a4 4 0 014 4v2" /></svg>',
        ];
        $statusMap = [
            'Pending' => 0,
            'Processed' => 0,
            'Processing' => 1,
            'Shipped' => 1,
            'In Transit' => 2,
            'Dispatched for Delivery' => 2,
            'Delivered' => 3,
            'Arrived' => 3,
        ];
    }
    
    $currentStep = $statusMap[$currentStatus] ?? 0;
    
    // Map status to latest log date
    $statusDates = collect($shipment->statusLogs)->groupBy('status')->map(function($logs) {
        return $logs->sortByDesc('changed_at')->first();
    });
@endphp
<div class="container mx-auto py-8 px-2 sm:px-4">
    @if(!$shipment)
        <div class="bg-white p-6 rounded shadow text-center">
            <h1 class="text-2xl font-bold mb-4">Tracking Not Found</h1>
            <p class="mb-4">Sorry, we could not find a shipment or package with that tracking number or barcode.</p>
            <a href="/tracking" class="text-blue-600">Try Again</a>
        </div>
    @else
    <!-- Modern Tracking Card UI -->
    <div class="bg-white rounded-xl shadow-lg p-4 sm:p-8 mb-8 max-w-2xl mx-auto">
        <div class="flex flex-col sm:flex-row justify-between items-center mb-4 gap-4">
            <div class="w-full sm:w-auto">
                <div class="text-gray-500 text-sm">ORDER</div>
                <div class="text-xl font-bold"><span class="text-blue-600">#{{ $shipment->tracking_number }}</span></div>
            </div>
            <div class="w-full sm:w-auto text-right">
                <div class="text-gray-500 text-sm">Expected Arrival</div>
                <div class="font-bold text-lg">{{ $shipment->eta ? \Carbon\Carbon::parse($shipment->eta)->format('M d, Y') : 'N/A' }}</div>
                <div class="text-gray-500 text-xs mt-1">Ref: <span class="font-bold">{{ $shipment->id }}</span></div>
            </div>
        </div>
        <!-- Progress Bar -->
        <!-- Horizontal Progress Bar for Desktop -->
        <div class="w-full overflow-x-auto hidden sm:block">
            <div class="flex items-center justify-between mb-10 min-w-[500px] sm:min-w-0">
                @foreach($statuses as $i => $step)
                    <div class="flex-1 flex flex-col items-center min-w-[70px]">
                        <div class="relative">
                            <div class="rounded-full h-10 w-10 flex items-center justify-center text-lg {{ $i <= $currentStep ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-400' }}">
                                {!! $statusIcons[$step] !!}
                            </div>
                            @if($i < count($statuses) - 1)
                                <div class="absolute top-1/2 left-full w-20 sm:w-40 h-2 -translate-y-1/2 {{ $i < $currentStep ? 'bg-blue-600' : 'bg-gray-200' }} rounded"></div>
                            @endif
                        </div>
                        <div class="mt-2 text-xs text-center {{ $i <= $currentStep ? 'text-blue-700 font-semibold' : 'text-gray-400' }}">{{ $step }}</div>
                        @php $log = $statusDates[$step] ?? null; @endphp
                        @if($log)
                            <div class="text-[10px] text-gray-500 mt-1">{{ \Carbon\Carbon::parse($log->changed_at)->format('M d, Y H:i') }}</div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
        <!-- Vertical Progress Steps for Mobile -->
        <div class="flex flex-col gap-4 sm:hidden mb-10">
            @foreach($statuses as $i => $step)
                <div class="flex items-center gap-4">
                    <div class="flex flex-col items-center">
                        <div class="rounded-full h-10 w-10 flex items-center justify-center text-lg {{ $i <= $currentStep ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-400' }}">
                            {!! $statusIcons[$step] !!}
                        </div>
                        @if($i < count($statuses) - 1)
                            <div class="w-1 h-6 bg-gray-300 {{ $i < $currentStep ? 'bg-blue-600' : 'bg-gray-200' }}"></div>
                        @endif
                    </div>
                    <div class="flex-1 flex items-center">
                        <div class="text-xs {{ $i <= $currentStep ? 'text-blue-700 font-semibold' : 'text-gray-400' }}">{{ $step }}</div>
                        @php $log = $statusDates[$step] ?? null; @endphp
                        @if($log)
                            <span class="ml-2 text-[10px] text-gray-500">{{ \Carbon\Carbon::parse($log->changed_at)->format('M d, Y H:i') }}</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <!-- Shipment Information Card -->
    <div class="bg-gray-100 rounded-xl shadow p-0 mb-8 max-w-4xl mx-auto">
        <div class="bg-white rounded-xl p-4 sm:p-8">
            <h2 class="text-xl font-bold mb-4">Shipment Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-8">
                <div>
                    <h3 class="font-semibold mb-2">Shipper Address</h3>
                    <div class="mb-1"><strong>Name:</strong> {{ $shipment->sender_name }}</div>
                    <div class="mb-1"><strong>Address:</strong> {{ $shipment->sender_street }}, {{ $shipment->sender_city }}, {{ $shipment->sender_state }}, {{ $shipment->sender_postal_code }}, {{ $shipment->sender_country }}</div>
                    <div class="mb-1"><strong>Email:</strong> {{ $shipment->sender_email }}</div>
                    <div class="mb-1"><strong>Phone:</strong> {{ $shipment->sender_phone }}</div>
                </div>
                <div>
                    <h3 class="font-semibold mb-2">Receiver Address</h3>
                    <div class="mb-1"><strong>Name:</strong> {{ $shipment->receiver_name }}</div>
                    <div class="mb-1"><strong>Address:</strong> {{ $shipment->receiver_street }}, {{ $shipment->receiver_city }}, {{ $shipment->receiver_state }}, {{ $shipment->receiver_postal_code }}, {{ $shipment->receiver_country }}</div>
                    <div class="mb-1"><strong>Email:</strong> {{ $shipment->receiver_email }}</div>
                    <div class="mb-1"><strong>Phone:</strong> {{ $shipment->receiver_phone }}</div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-8 mt-6">
                <div>
                    <div class="mb-1"><strong>Type of Shipment:</strong> {{ $shipment->shipment_type }}</div>
                    @if($shipment->shipment_type === 'document')
                        <div class="mb-1"><strong>Document Category:</strong> {{ $shipment->document_category }}</div>
                    @endif
                    <div class="mb-1"><strong>Weight:</strong> {{ $shipment->total_weight }} kg</div>
                    <div class="mb-1"><strong>Dimensions:</strong> {{ $shipment->length }} x {{ $shipment->width }} x {{ $shipment->height }} cm</div>
                    <div class="mb-1"><strong>Contents:</strong> {{ $shipment->contents_description }}</div>
                    <div class="mb-1"><strong>Declared Value:</strong> ${{ number_format($shipment->declared_value, 2) }}</div>
                    <div class="mb-1"><strong>Commodity Code:</strong> {{ $shipment->commodity_code }}</div>
                </div>
                <div>
                    <div class="mb-1"><strong>Service Type:</strong> {{ $shipment->service_type }}</div>
                    <div class="mb-1"><strong>Price:</strong> ${{ number_format($shipment->price, 2) }}</div>
                    <div class="mb-1"><strong>ETA:</strong> {{ $shipment->eta }}</div>
                    <div class="mb-1"><strong>Insured:</strong> {{ $shipment->insurance_enabled ? 'Yes' : 'No' }}</div>
                    @if($shipment->insurance_enabled)
                        <div class="mb-1"><strong>Insurance Value:</strong> ${{ number_format($shipment->insurance_value, 2) }}</div>
                        <div class="mb-1"><strong>Insurance Cost:</strong> ${{ number_format($shipment->insurance_cost, 2) }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection 