@extends('layouts.app')

@section('content')
<div class="container mx-auto py-12">
    <h1 class="text-3xl font-bold mb-8 text-yellow-700">Contact Us</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-white rounded shadow p-8">
            <h2 class="text-xl font-bold mb-4">Send us a message</h2>
            <form method="POST" action="#">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700">Name</label>
                    <input type="text" name="name" class="w-full px-3 py-2 border rounded" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Email</label>
                    <input type="email" name="email" class="w-full px-3 py-2 border rounded" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Message</label>
                    <textarea name="message" class="w-full px-3 py-2 border rounded" rows="5" required></textarea>
                </div>
                <button type="submit" class="bg-yellow-600 text-white px-6 py-2 rounded hover:bg-yellow-700">Send</button>
            </form>
        </div>
        <div class="bg-yellow-50 rounded shadow p-8">
            <h2 class="text-xl font-bold mb-4 text-yellow-700">Contact Information</h2>
            <p class="mb-2">SWIFT SYNCH</p>
            <p class="mb-2">1640 W 23rd St # 400, DFW Airport, TX 75220, United States</p>
            <p class="mb-2">Email: support@swiftsynch.com</p>
            <p class="mb-2">Phone: +1 (800) 000 0000</p>
            <div class="mt-6">
                <h3 class="font-semibold mb-2">Business Hours</h3>
                <p>Mon - Fri: 8:00am - 6:00pm</p>
                <p>Sat: 9:00am - 2:00pm</p>
            </div>
        </div>
    </div>
</div>
@endsection 