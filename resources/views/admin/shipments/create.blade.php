@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Create New Shipment</h1>
    <div class="bg-white rounded shadow p-6 max-w-4xl mx-auto">
        <form method="POST" action="{{ route('admin.shipments.store') }}" class="space-y-8">
            @csrf
            
            <!-- User Selection -->
            <div class="border-b pb-6">
                <h2 class="text-lg font-semibold mb-4">Customer</h2>
                <div class="mb-4">
                    <label class="block font-semibold mb-1">Customer</label>
                    <select name="user_id" class="w-full border rounded px-3 py-2">
                        <option value="">No Customer (Anonymous)</option>
                        @foreach(\App\Models\User::all() as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Sender Details -->
            <div class="border-b pb-6">
                <h2 class="text-lg font-semibold mb-4">Sender Details</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold mb-1">Name *</label>
                        <input type="text" name="sender_name" class="w-full border rounded px-3 py-2" required>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Phone Number *</label>
                        <input type="tel" name="sender_phone" class="w-full border rounded px-3 py-2" required>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Email Address *</label>
                        <input type="email" name="sender_email" class="w-full border rounded px-3 py-2" required>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Country *</label>
                        <input type="text" name="sender_country" class="w-full border rounded px-3 py-2" required>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block font-semibold mb-1">Street Address *</label>
                        <input type="text" name="sender_street" class="w-full border rounded px-3 py-2" required>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">City *</label>
                        <input type="text" name="sender_city" class="w-full border rounded px-3 py-2" required>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">State/Province *</label>
                        <input type="text" name="sender_state" class="w-full border rounded px-3 py-2" required>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Postal Code *</label>
                        <input type="text" name="sender_postal_code" class="w-full border rounded px-3 py-2" required>
                    </div>
                </div>
            </div>

            <!-- Receiver Details -->
            <div class="border-b pb-6">
                <h2 class="text-lg font-semibold mb-4">Receiver Details</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold mb-1">Name *</label>
                        <input type="text" name="receiver_name" class="w-full border rounded px-3 py-2" required>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Phone Number *</label>
                        <input type="tel" name="receiver_phone" class="w-full border rounded px-3 py-2" required>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Email Address (Optional)</label>
                        <input type="email" name="receiver_email" class="w-full border rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Country *</label>
                        <input type="text" name="receiver_country" class="w-full border rounded px-3 py-2" required>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block font-semibold mb-1">Street Address *</label>
                        <input type="text" name="receiver_street" class="w-full border rounded px-3 py-2" required>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">City *</label>
                        <input type="text" name="receiver_city" class="w-full border rounded px-3 py-2" required>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">State/Province *</label>
                        <input type="text" name="receiver_state" class="w-full border rounded px-3 py-2" required>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Postal Code *</label>
                        <input type="text" name="receiver_postal_code" class="w-full border rounded px-3 py-2" required>
                    </div>
                </div>
            </div>

            <!-- Shipment Type -->
            <div class="border-b pb-6">
                <h2 class="text-lg font-semibold mb-4">Shipment Type</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold mb-1">Shipment Type *</label>
                        <select name="shipment_type" class="w-full border rounded px-3 py-2" required>
                            <option value="">Select Type</option>
                            <option value="document">Document</option>
                            <option value="package">Package</option>
                            <option value="freight">Freight</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Document Category (if Document)</label>
                        <select name="document_category" class="w-full border rounded px-3 py-2">
                            <option value="">Select Category</option>
                            <option value="letter">Letter</option>
                            <option value="legal">Legal Documents</option>
                            <option value="contracts">Contracts</option>
                            <option value="certificates">Certificates</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Package Details -->
            <div class="border-b pb-6">
                <h2 class="text-lg font-semibold mb-4">Package Details</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold mb-1">Weight (kg) *</label>
                        <input type="number" step="0.01" name="total_weight" class="w-full border rounded px-3 py-2" required>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Length (cm) *</label>
                        <input type="number" step="0.1" name="length" class="w-full border rounded px-3 py-2" required>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Width (cm) *</label>
                        <input type="number" step="0.1" name="width" class="w-full border rounded px-3 py-2" required>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Height (cm) *</label>
                        <input type="number" step="0.1" name="height" class="w-full border rounded px-3 py-2" required>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block font-semibold mb-1">Contents Description *</label>
                        <textarea name="contents_description" class="w-full border rounded px-3 py-2" rows="3" required placeholder="Brief description of items (e.g., electronics, clothing)"></textarea>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Declared Value ($) *</label>
                        <input type="number" step="0.01" name="declared_value" class="w-full border rounded px-3 py-2" required>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Commodity Code (HS Code)</label>
                        <input type="text" name="commodity_code" class="w-full border rounded px-3 py-2" placeholder="6-10 digit HS code for international shipments">
                    </div>
                </div>
            </div>

            <!-- Shipping Service -->
            <div class="border-b pb-6">
                <h2 class="text-lg font-semibold mb-4">Shipping Service</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold mb-1">Service Type *</label>
                        <select name="service_type" class="w-full border rounded px-3 py-2" required>
                            <option value="">Select Service</option>
                            <option value="Standard">Standard</option>
                            <option value="Express">Express</option>
                            <option value="Overnight">Overnight</option>
                            <option value="Priority Overnight">Priority Overnight</option>
                            <option value="International Priority">International Priority</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Price ($) *</label>
                        <input type="number" step="0.01" name="price" class="w-full border rounded px-3 py-2" required>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">ETA (optional)</label>
                        <input type="datetime-local" name="eta" class="w-full border rounded px-3 py-2">
                    </div>
                </div>
            </div>

            <!-- Insurance -->
            <div class="border-b pb-6">
                <h2 class="text-lg font-semibold mb-4">Shipment Protection (Insurance)</h2>
                <div class="space-y-4">
                    <div class="flex items-center">
                        <input type="checkbox" name="insurance_enabled" id="insurance_enabled" class="mr-2">
                        <label for="insurance_enabled" class="font-semibold">Insure my shipment</label>
                    </div>
                    <div id="insurance_details" class="hidden">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-semibold mb-1">Insurance Value ($)</label>
                                <input type="number" step="0.01" name="insurance_value" class="w-full border rounded px-3 py-2">
                            </div>
                            <div>
                                <label class="block font-semibold mb-1">Insurance Cost ($)</label>
                                <input type="number" step="0.01" name="insurance_cost" class="w-full border rounded px-3 py-2">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.shipments.all') }}" class="bg-gray-500 text-white px-6 py-2 rounded font-bold hover:bg-gray-600 transition">Cancel</a>
                <button type="submit" class="bg-red-700 text-white px-6 py-2 rounded font-bold hover:bg-red-800 transition">Create Shipment</button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('insurance_enabled').addEventListener('change', function() {
    const insuranceDetails = document.getElementById('insurance_details');
    if (this.checked) {
        insuranceDetails.classList.remove('hidden');
    } else {
        insuranceDetails.classList.add('hidden');
    }
});
</script>
@endsection 