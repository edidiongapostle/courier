@extends('layouts.app')

@section('content')
<div class="container mx-auto py-12">
    <h1 class="text-3xl font-bold mb-8 text-yellow-700">Track Your Shipment</h1>
    <div class="bg-white rounded shadow p-8 mb-8">
        <form method="GET" action="/tracking" class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-4">
            <input type="text" name="tracking" placeholder="Enter Tracking Number or Barcode" class="flex-1 px-4 py-2 border rounded" required>
            <button type="submit" class="bg-yellow-600 text-white px-6 py-2 rounded hover:bg-yellow-700">Track</button>
        </form>
    </div>
    <div class="mt-12">
        <h2 class="text-2xl font-bold mb-6 text-yellow-700">Frequently Asked Questions</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-yellow-50 rounded shadow p-6">
                <h3 class="text-lg font-bold mb-2 text-yellow-700">How do I track my shipment?</h3>
                <p>Enter your tracking number or package barcode above and click "Track" to see the latest status and location of your shipment.</p>
            </div>
            <div class="bg-yellow-50 rounded shadow p-6">
                <h3 class="text-lg font-bold mb-2 text-yellow-700">What if my tracking number is not found?</h3>
                <p>Double-check your tracking number or barcode. If it still doesn't work, contact our support team for assistance.</p>
            </div>
            <div class="bg-yellow-50 rounded shadow p-6">
                <h3 class="text-lg font-bold mb-2 text-yellow-700">How long does delivery take?</h3>
                <p>Delivery time depends on the service type and distance. Use our <a href="/rate" class="text-blue-600 underline">Rate Calculator</a> for an estimate.</p>
            </div>
            <div class="bg-yellow-50 rounded shadow p-6">
                <h3 class="text-lg font-bold mb-2 text-yellow-700">Can I change my delivery address?</h3>
                <p>Contact our support team as soon as possible to request a change. Changes may not be possible if the shipment is already out for delivery.</p>
            </div>
            <div class="bg-yellow-50 rounded shadow p-6">
                <h3 class="text-lg font-bold mb-2 text-yellow-700">What do the different package statuses mean?</h3>
                <p><strong>Pending:</strong> Awaiting processing.<br><strong>In Transit:</strong> On the way.<br><strong>On Hold:</strong> Temporarily delayed.<br><strong>Dispatched for Delivery:</strong> Out for delivery.<br><strong>Delivered:</strong> Successfully delivered.</p>
            </div>
            <div class="bg-yellow-50 rounded shadow p-6">
                <h3 class="text-lg font-bold mb-2 text-yellow-700">How do I contact support?</h3>
                <p>Visit our <a href="/contact" class="text-blue-600 underline">Contact</a> page for support options, or email support@swiftsynch.com.</p>
            </div>
        </div>
    </div>
</div>
@endsection 