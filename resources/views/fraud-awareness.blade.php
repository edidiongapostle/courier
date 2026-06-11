@extends('layouts.app')

@section('content')
<div class="container mx-auto py-12">
    <div class="max-w-2xl mx-auto bg-white rounded shadow p-8">
        <div class="flex items-center mb-4">
            <svg class="h-8 w-8 text-yellow-500 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" /></svg>
            <h1 class="text-3xl font-bold">Fraud Awareness</h1>
        </div>
        <p class="mb-4 text-gray-700">Protect yourself from scams and fraudulent activities. SWIFT SYNCH will never ask for your password, payment information, or verification codes via email, phone, or SMS.</p>
        <ul class="list-disc pl-6 text-gray-700 mb-4">
            <li>Always verify the sender of emails and messages claiming to be from SWIFT SYNCH.</li>
            <li>Do not share your login credentials or OTPs with anyone.</li>
            <li>Be cautious of offers that seem too good to be true.</li>
            <li>Check website URLs for authenticity before entering sensitive information.</li>
            <li>If you suspect fraud, contact our support team immediately at <a href="/contact" class="text-blue-600 underline">Contact Us</a>.</li>
        </ul>
        <div class="bg-yellow-100 border-l-4 border-yellow-500 p-4 text-yellow-800 rounded">
            <strong>Report Suspicious Activity:</strong> If you receive suspicious emails, calls, or messages, please report them to us so we can investigate and protect our community.
        </div>
    </div>
</div>
@endsection 