@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">Shipment Details</h1>
    <div class="bg-white p-6 rounded shadow mb-6">
        <h2 class="text-lg font-semibold mb-2">Tracking Number</h2>
        <p>{{ $shipment->tracking_number }}</p>
        <h2 class="text-lg font-semibold mt-4 mb-2">Service Type</h2>
        <p>{{ $shipment->service_type }}</p>
        <h2 class="text-lg font-semibold mt-4 mb-2">Status</h2>
        <p>{{ $shipment->status }}</p>
        <h2 class="text-lg font-semibold mt-4 mb-2">Packages</h2>
        <table class="min-w-full table-auto mb-4">
            <thead>
                <tr>
                    <th class="px-4 py-2">Barcode</th>
                    <th class="px-4 py-2">Weight (kg)</th>
                    <th class="px-4 py-2">Length (cm)</th>
                    <th class="px-4 py-2">Width (cm)</th>
                    <th class="px-4 py-2">Height (cm)</th>
                    <th class="px-4 py-2">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($shipment->packages as $package)
                    <tr>
                        <td class="border px-4 py-2">{{ $package->barcode }}</td>
                        <td class="border px-4 py-2">{{ $package->weight }}</td>
                        <td class="border px-4 py-2">{{ $package->length }}</td>
                        <td class="border px-4 py-2">{{ $package->width }}</td>
                        <td class="border px-4 py-2">{{ $package->height }}</td>
                        <td class="border px-4 py-2">{{ $package->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <a href="{{ route('shipments.history') }}" class="text-blue-600">Back to My Shipments</a>
</div>
@endsection 