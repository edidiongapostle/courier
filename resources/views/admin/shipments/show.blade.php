@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-4 sm:py-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Shipment Details</h1>
            <div class="mt-4 sm:mt-0 flex gap-2">
                <button onclick="document.getElementById('statusModal').classList.remove('hidden')" 
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-blue-700 transition text-sm">
                    Update Status
                </button>
                <a href="{{ route('admin.shipments.pending') }}" 
                   class="bg-gray-500 text-white px-4 py-2 rounded-lg font-medium hover:bg-gray-600 transition text-sm">
                    ← Back
                </a>
            </div>
        </div>

        <!-- Status Messages -->
        @if(session('status'))
            <div class="mb-4 p-3 bg-green-100 border border-green-200 text-green-800 rounded-lg text-sm">{{ session('status') }}</div>
        @endif
        @if($errors->has('status'))
            <div class="mb-4 p-3 bg-red-100 border border-red-200 text-red-800 rounded-lg text-sm">{{ $errors->first('status') }}</div>
        @endif

        <!-- Status Update Modal -->
        <div id="statusModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden p-4">
            <div class="bg-white rounded-lg shadow-lg p-4 sm:p-8 w-full max-w-md relative">
                <button onclick="document.getElementById('statusModal').classList.add('hidden')" 
                        class="absolute top-2 right-2 text-gray-400 hover:text-gray-700 text-xl">&times;</button>
                <h2 class="text-lg sm:text-xl font-bold mb-4">Update Shipment Status</h2>
                <form method="POST" action="{{ route('admin.shipments.status.update', $shipment->id) }}">
                    @csrf
                    @php
                        $workflow = [
                            'pending' => ['processing', 'cancelled'],
                            'processing' => ['shipped', 'cancelled'],
                            'shipped' => ['in_transit', 'returned'],
                            'in_transit' => ['delivered', 'returned'],
                            'delivered' => [],
                            'cancelled' => [],
                            'returned' => [],
                        ];
                        $current = strtolower($shipment->status);
                        $validNext = $workflow[$current] ?? [];
                    @endphp
                    <div class="mb-4">
                        <label class="block font-semibold mb-2 text-sm">Current Status: 
                            <span class="text-blue-700 font-bold uppercase">{{ $shipment->status }}</span>
                        </label>
                        @if(count($validNext))
                            <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="">Select next status</option>
                                @foreach($validNext as $status)
                                    <option value="{{ $status }}">{{ ucfirst(str_replace('_', ' ', $status)) }}</option>
                                @endforeach
                            </select>
                        @else
                            <div class="text-gray-500 text-sm">No further transitions allowed.</div>
                        @endif
                    </div>
                    <div class="flex flex-col sm:flex-row gap-2 justify-end">
                        <button type="button" onclick="document.getElementById('statusModal').classList.add('hidden')" 
                                class="bg-gray-400 text-white px-4 py-2 rounded-lg font-medium hover:bg-gray-500 transition text-sm">
                            Cancel
                        </button>
                        @if(count($validNext))
                            <button type="submit" class="bg-blue-700 text-white px-4 py-2 rounded-lg font-medium hover:bg-blue-800 transition text-sm">
                                Update
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Shipment Information -->
            <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
                <h2 class="text-lg sm:text-xl font-semibold text-gray-900 mb-4">Shipment Information</h2>
                
                <div class="space-y-4">
                    <!-- Basic Info -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="font-semibold text-gray-900 mb-2 text-sm">Basic Information</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tracking Number:</span>
                                <span class="font-medium">{{ $shipment->tracking_number }}</span>
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
                            <div class="flex justify-between">
                                <span class="text-gray-600">Service Type:</span>
                                <span class="font-medium">{{ $shipment->service_type }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Total Weight:</span>
                                <span class="font-medium">{{ $shipment->total_weight }} kg</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Price:</span>
                                <span class="font-medium">${{ number_format($shipment->price, 2) }}</span>
                            </div>
                            @if($shipment->eta)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">ETA:</span>
                                    <span class="font-medium">{{ $shipment->eta->format('M d, Y H:i') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- User Info -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="font-semibold text-gray-900 mb-2 text-sm">Customer Information</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Name:</span>
                                <span class="font-medium">{{ optional($shipment->user)->name ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Email:</span>
                                <span class="font-medium">{{ optional($shipment->user)->email ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Address Information -->
            <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
                <h2 class="text-lg sm:text-xl font-semibold text-gray-900 mb-4">Address Information</h2>
                
                <div class="space-y-4">
                    <!-- Sender Details -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="font-semibold text-gray-900 mb-2 text-sm">Sender Details</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Name:</span>
                                <span class="font-medium">{{ $shipment->sender_name ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Phone:</span>
                                <span class="font-medium">{{ $shipment->sender_phone ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Email:</span>
                                <span class="font-medium">{{ $shipment->sender_email ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Address:</span>
                                <span class="font-medium text-right">
                                    {{ $shipment->sender_street ?? 'N/A' }}, {{ $shipment->sender_city ?? 'N/A' }}, {{ $shipment->sender_state ?? 'N/A' }}, {{ $shipment->sender_postal_code ?? 'N/A' }}, {{ $shipment->sender_country ?? 'N/A' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Receiver Details -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="font-semibold text-gray-900 mb-2 text-sm">Receiver Details</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Name:</span>
                                <span class="font-medium">{{ $shipment->receiver_name ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Phone:</span>
                                <span class="font-medium">{{ $shipment->receiver_phone ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Email:</span>
                                <span class="font-medium">{{ $shipment->receiver_email ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Address:</span>
                                <span class="font-medium text-right">
                                    {{ $shipment->receiver_street ?? 'N/A' }}, {{ $shipment->receiver_city ?? 'N/A' }}, {{ $shipment->receiver_state ?? 'N/A' }}, {{ $shipment->receiver_postal_code ?? 'N/A' }}, {{ $shipment->receiver_country ?? 'N/A' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Package Details and Insurance -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Package Details -->
            <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
                <h2 class="text-lg sm:text-xl font-semibold text-gray-900 mb-4">Package Details</h2>
                
                <div class="space-y-4">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="font-semibold text-gray-900 mb-2 text-sm">Shipment Information</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Type:</span>
                                <span class="font-medium">{{ $shipment->shipment_type ?? 'N/A' }}</span>
                            </div>
                            @if($shipment->shipment_type === 'document')
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Document Category:</span>
                                    <span class="font-medium">{{ $shipment->document_category ?? 'N/A' }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between">
                                <span class="text-gray-600">Dimensions:</span>
                                <span class="font-medium">{{ $shipment->length ?? 'N/A' }} x {{ $shipment->width ?? 'N/A' }} x {{ $shipment->height ?? 'N/A' }} cm</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Contents:</span>
                                <span class="font-medium">{{ $shipment->contents_description ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Declared Value:</span>
                                <span class="font-medium">${{ number_format($shipment->declared_value ?? 0, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Commodity Code:</span>
                                <span class="font-medium">{{ $shipment->commodity_code ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Insurance Information -->
            <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
                <h2 class="text-lg sm:text-xl font-semibold text-gray-900 mb-4">Insurance Information</h2>
                
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Insured:</span>
                            <span class="font-medium">{{ $shipment->insurance_enabled ? 'Yes' : 'No' }}</span>
                        </div>
                        @if($shipment->insurance_enabled)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Insurance Value:</span>
                                <span class="font-medium">${{ number_format($shipment->insurance_value ?? 0, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Insurance Cost:</span>
                                <span class="font-medium">${{ number_format($shipment->insurance_cost ?? 0, 2) }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Packages Table -->
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
            <h2 class="text-lg sm:text-xl font-semibold text-gray-900 mb-4">Packages</h2>
            
            <!-- Mobile: Card Layout -->
            <div class="block sm:hidden space-y-4">
                @foreach($shipment->packages as $package)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h3 class="font-semibold text-gray-900">{{ $package->barcode }}</h3>
                                <p class="text-sm text-gray-600">Package {{ $loop->iteration }}</p>
                            </div>
                            <span class="inline-block px-2 py-1 text-xs rounded-full 
                                @if($package->status === 'Pending') bg-yellow-100 text-yellow-800
                                @elseif($package->status === 'In Transit') bg-blue-100 text-blue-800
                                @elseif($package->status === 'Delivered') bg-green-100 text-green-800
                                @elseif($package->status === 'On Hold') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ $package->status }}
                            </span>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-2 text-sm mb-3">
                            <div>
                                <span class="text-gray-500">Weight:</span>
                                <span class="ml-1 font-medium">{{ $package->weight }} kg</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Dimensions:</span>
                                <span class="ml-1 font-medium">{{ $package->length }} x {{ $package->width }} x {{ $package->height }} cm</span>
                            </div>
                        </div>
                        
                        <div class="flex gap-2">
                            <a href="{{ route('admin.packages.status', $package->id) }}" 
                               class="bg-blue-500 text-white px-3 py-1 rounded text-xs hover:bg-blue-600 transition">
                                Update Status
                            </a>
                            <a href="{{ route('admin.packages.status.log', $package->id) }}" 
                               class="bg-green-500 text-white px-3 py-1 rounded text-xs hover:bg-green-600 transition">
                                View Log
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Desktop: Table Layout -->
            <div class="hidden sm:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Barcode</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Weight (kg)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dimensions (cm)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($shipment->packages as $package)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $package->barcode }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $package->weight }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $package->length }} x {{ $package->width }} x {{ $package->height }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-block px-2 py-1 text-xs rounded-full 
                                        @if($package->status === 'Pending') bg-yellow-100 text-yellow-800
                                        @elseif($package->status === 'In Transit') bg-blue-100 text-blue-800
                                        @elseif($package->status === 'Delivered') bg-green-100 text-green-800
                                        @elseif($package->status === 'On Hold') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ $package->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                    <a href="{{ route('admin.packages.status', $package->id) }}" class="text-blue-600 hover:text-blue-900">Update Status</a>
                                    <span class="text-gray-300">|</span>
                                    <a href="{{ route('admin.packages.status.log', $package->id) }}" class="text-green-600 hover:text-green-900">View Log</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 