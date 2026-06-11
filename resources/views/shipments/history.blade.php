@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">My Shipments</h1>
    <div class="bg-white p-6 rounded shadow">
        @if($shipments->isEmpty())
            <p>You have no shipments yet.</p>
        @else
            <table class="min-w-full table-auto">
                <thead>
                    <tr>
                        <th class="px-4 py-2">Tracking #</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Service Type</th>
                        <th class="px-4 py-2">Total Weight (kg)</th>
                        <th class="px-4 py-2">Packages</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($shipments as $shipment)
                        <tr>
                            <td class="border px-4 py-2">{{ $shipment->tracking_number }}</td>
                            <td class="border px-4 py-2">{{ $shipment->status }}</td>
                            <td class="border px-4 py-2">{{ $shipment->service_type }}</td>
                            <td class="border px-4 py-2">{{ $shipment->total_weight }}</td>
                            <td class="border px-4 py-2">{{ $shipment->packages->count() }}</td>
                            <td class="border px-4 py-2">
                                <a href="{{ route('shipments.user_show', $shipment->id) }}" class="text-blue-600">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection 