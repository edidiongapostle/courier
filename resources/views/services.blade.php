@extends('layouts.app')

@section('content')
<div class="container mx-auto py-12">
    <h1 class="text-3xl font-bold mb-8 text-yellow-700">Our Services</h1>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white rounded shadow p-6 text-center">
            <div class="text-4xl mb-2">🚚</div>
            <h2 class="text-xl font-bold mb-2 text-yellow-700">Express Delivery</h2>
            <p>Fast, time-definite delivery for urgent shipments nationwide.</p>
        </div>
        <div class="bg-white rounded shadow p-6 text-center">
            <div class="text-4xl mb-2">📦</div>
            <h2 class="text-xl font-bold mb-2 text-yellow-700">Bulk & Consolidated Shipping</h2>
            <p>Ship multiple packages together for cost-effective, secure delivery.</p>
        </div>
        <div class="bg-white rounded shadow p-6 text-center">
            <div class="text-4xl mb-2">🔒</div>
            <h2 class="text-xl font-bold mb-2 text-yellow-700">Secure Handling</h2>
            <p>Every shipment is handled with care and tracked at every stage.</p>
        </div>
        <div class="bg-white rounded shadow p-6 text-center">
            <div class="text-4xl mb-2">🌍</div>
            <h2 class="text-xl font-bold mb-2 text-yellow-700">Nationwide Coverage</h2>
            <p>We deliver to every state and major city in the country.</p>
        </div>
        <div class="bg-white rounded shadow p-6 text-center">
            <div class="text-4xl mb-2">💼</div>
            <h2 class="text-xl font-bold mb-2 text-yellow-700">Business Solutions</h2>
            <p>Custom logistics and shipping solutions for businesses of all sizes.</p>
        </div>
        <div class="bg-white rounded shadow p-6 text-center">
            <div class="text-4xl mb-2">💬</div>
            <h2 class="text-xl font-bold mb-2 text-yellow-700">Customer Support</h2>
            <p>Professional support and real-time tracking for peace of mind.</p>
        </div>
    </div>
</div>
@endsection 