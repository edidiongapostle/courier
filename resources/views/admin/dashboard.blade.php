@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-4 sm:py-8">
    <!-- Stats Cards - Mobile Responsive Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6 sm:mb-8">
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
            <div class="text-gray-500 text-sm sm:text-base">Total Users</div>
            <div class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $userCount }}</div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
            <div class="text-gray-500 text-sm sm:text-base">Blocked Users</div>
            <div class="text-2xl sm:text-3xl font-bold text-red-600">{{ $blockedCount }}</div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
            <div class="text-gray-500 text-sm sm:text-base">Pending Shipments</div>
            <div class="text-2xl sm:text-3xl font-bold text-yellow-600">{{ $pendingShipments }}</div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
            <div class="text-gray-500 text-sm sm:text-base">Total Shipments</div>
            <div class="text-2xl sm:text-3xl font-bold text-blue-600">{{ $totalShipments }}</div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6 sm:mb-8">
        <!-- Quick Links Card -->
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
            <h2 class="text-lg sm:text-xl font-semibold mb-4 text-gray-900">Quick Links</h2>
            
            <!-- Mobile: Stacked buttons -->
            <div class="block sm:hidden space-y-3">
                <a href="{{ route('admin.users.all') }}" class="w-full bg-gray-900 text-yellow-400 px-4 py-3 rounded-lg font-bold text-center hover:bg-gray-800 transition block">
                    👥 Manage Users
                </a>
                <a href="{{ route('admin.shipments.pending') }}" class="w-full bg-yellow-500 text-gray-900 px-4 py-3 rounded-lg font-bold text-center hover:bg-yellow-600 transition block">
                    ⏳ Pending Shipments
                </a>
                <a href="{{ route('admin.shipments.all') }}" class="w-full bg-red-700 text-white px-4 py-3 rounded-lg font-bold text-center hover:bg-red-800 transition block">
                    📦 All Shipments
                </a>
            </div>

            <!-- Desktop: Side-by-side buttons -->
            <div class="hidden sm:block space-y-3">
                <a href="{{ route('admin.users.all') }}" class="w-full bg-gray-900 text-yellow-400 px-4 py-2 rounded font-bold text-center hover:bg-gray-800 transition block">
                    Manage Users
                </a>
                <a href="{{ route('admin.shipments.pending') }}" class="w-full bg-yellow-500 text-gray-900 px-4 py-2 rounded font-bold text-center hover:bg-yellow-600 transition block">
                    Pending Shipments
                </a>
                <a href="{{ route('admin.shipments.all') }}" class="w-full bg-red-700 text-white px-4 py-2 rounded font-bold text-center hover:bg-red-800 transition block">
                    All Shipments
                </a>
            </div>

            <!-- Quick Links List -->
            <div class="mt-6">
                <h3 class="text-sm font-semibold text-gray-700 mb-2">Quick Navigation</h3>
                <ul class="space-y-1 text-sm">
                    <li><a href="{{ route('admin.users.all') }}" class="text-blue-600 hover:underline">All Users</a></li>
                    <li><a href="{{ route('admin.shipments.pending') }}" class="text-blue-600 hover:underline">Pending Shipments</a></li>
                    <li><a href="{{ route('admin.shipments.all') }}" class="text-blue-600 hover:underline">All Shipments</a></li>
                    <li><a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline">Dashboard Home</a></li>
                </ul>
            </div>
        </div>

        <!-- Recent Shipments Card -->
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
            <h2 class="text-lg sm:text-xl font-semibold mb-4 text-gray-900">Recent Shipments</h2>
            @if($recentShipments->isEmpty())
                <p class="text-gray-500 text-sm">No recent shipments.</p>
            @else
                <!-- Mobile: Card layout -->
                <div class="block sm:hidden space-y-3">
                    @foreach($recentShipments as $shipment)
                        <div class="border rounded-lg p-3 bg-gray-50">
                            <div class="flex justify-between items-start mb-2">
                                <span class="font-semibold text-sm">{{ $shipment->tracking_number }}</span>
                                <span class="text-xs text-gray-500">{{ $shipment->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="text-sm text-gray-600">
                                <div>User: {{ optional($shipment->user)->name ?? 'N/A' }}</div>
                                <div class="mt-1">
                                    <span class="inline-block px-2 py-1 text-xs rounded-full 
                                        @if($shipment->status === 'Pending') bg-yellow-100 text-yellow-800
                                        @elseif($shipment->status === 'In Transit') bg-blue-100 text-blue-800
                                        @elseif($shipment->status === 'Delivered') bg-green-100 text-green-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ $shipment->status }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Desktop: Table layout -->
                <div class="hidden sm:block overflow-x-auto">
                    <table class="min-w-full table-auto text-sm">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tracking #</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($recentShipments as $shipment)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-3 py-2 text-sm font-medium text-gray-900">{{ $shipment->tracking_number }}</td>
                                    <td class="px-3 py-2 text-sm text-gray-500">{{ optional($shipment->user)->name ?? 'N/A' }}</td>
                                    <td class="px-3 py-2 text-sm">
                                        <span class="inline-block px-2 py-1 text-xs rounded-full 
                                            @if($shipment->status === 'Pending') bg-yellow-100 text-yellow-800
                                            @elseif($shipment->status === 'In Transit') bg-blue-100 text-blue-800
                                            @elseif($shipment->status === 'Delivered') bg-green-100 text-green-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ $shipment->status }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-2 text-sm text-gray-500">{{ $shipment->created_at->diffForHumans() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Welcome Section -->
    <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 text-center">
        <h1 class="text-2xl sm:text-3xl font-bold mb-2 text-gray-900">Welcome to the Admin Dashboard</h1>
        <p class="text-gray-600 mb-4 text-sm sm:text-base">Manage users, shipments, and more. Use the quick links and summary cards above to get started.</p>
        <div class="flex justify-center">
            <img src="/favicon.ico" alt="Logo" class="w-12 h-12 sm:w-16 sm:h-16">
        </div>
    </div>
</div>
@endsection 