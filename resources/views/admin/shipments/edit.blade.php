@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Edit Shipment</h1>
    <div class="bg-white rounded shadow p-6 max-w-4xl mx-auto">
        <form method="POST" action="{{ route('admin.shipments.update', $shipment->id) }}" class="space-y-8">
            @csrf
            @method('PUT')
            
            <!-- Customer Info (Read-only) -->
            <div class="border-b pb-6">
                <h2 class="text-lg font-semibold mb-4">Customer</h2>
                <div class="bg-gray-50 p-4 rounded">
                    <p><strong>Name:</strong> {{ optional($shipment->user)->name }}</p>
                    <p><strong>Email:</strong> {{ optional($shipment->user)->email }}</p>
                </div>
            </div>

            <!-- Sender Details -->
            <div class="border-b pb-6">
                <h2 class="text-lg font-semibold mb-4">Sender Details</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold mb-1">Name *</label>
                        <input type="text" name="sender_name" class="w-full border rounded px-3 py-2" required value="{{ old('sender_name', $shipment->sender_name ?? '') }}">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Phone Number *</label>
                        <input type="tel" name="sender_phone" class="w-full border rounded px-3 py-2" required value="{{ old('sender_phone', $shipment->sender_phone ?? '') }}">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Email Address *</label>
                        <input type="email" name="sender_email" class="w-full border rounded px-3 py-2" required value="{{ old('sender_email', $shipment->sender_email ?? '') }}">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Country *</label>
                        <input type="text" name="sender_country" class="w-full border rounded px-3 py-2" required value="{{ old('sender_country', $shipment->sender_country ?? '') }}">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block font-semibold mb-1">Street Address *</label>
                        <input type="text" name="sender_street" class="w-full border rounded px-3 py-2" required value="{{ old('sender_street', $shipment->sender_street ?? '') }}">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">City *</label>
                        <input type="text" name="sender_city" class="w-full border rounded px-3 py-2" required value="{{ old('sender_city', $shipment->sender_city ?? '') }}">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">State/Province *</label>
                        <input type="text" name="sender_state" class="w-full border rounded px-3 py-2" required value="{{ old('sender_state', $shipment->sender_state ?? '') }}">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Postal Code *</label>
                        <input type="text" name="sender_postal_code" class="w-full border rounded px-3 py-2" required value="{{ old('sender_postal_code', $shipment->sender_postal_code ?? '') }}">
                    </div>
                </div>
            </div>

            <!-- Receiver Details -->
            <div class="border-b pb-6">
                <h2 class="text-lg font-semibold mb-4">Receiver Details</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold mb-1">Name *</label>
                        <input type="text" name="receiver_name" class="w-full border rounded px-3 py-2" required value="{{ old('receiver_name', $shipment->receiver_name ?? '') }}">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Phone Number *</label>
                        <input type="tel" name="receiver_phone" class="w-full border rounded px-3 py-2" required value="{{ old('receiver_phone', $shipment->receiver_phone ?? '') }}">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Email Address (Optional)</label>
                        <input type="email" name="receiver_email" class="w-full border rounded px-3 py-2" value="{{ old('receiver_email', $shipment->receiver_email ?? '') }}">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Country *</label>
                        <input type="text" name="receiver_country" class="w-full border rounded px-3 py-2" required value="{{ old('receiver_country', $shipment->receiver_country ?? '') }}">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block font-semibold mb-1">Street Address *</label>
                        <input type="text" name="receiver_street" class="w-full border rounded px-3 py-2" required value="{{ old('receiver_street', $shipment->receiver_street ?? '') }}">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">City *</label>
                        <input type="text" name="receiver_city" class="w-full border rounded px-3 py-2" required value="{{ old('receiver_city', $shipment->receiver_city ?? '') }}">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">State/Province *</label>
                        <input type="text" name="receiver_state" class="w-full border rounded px-3 py-2" required value="{{ old('receiver_state', $shipment->receiver_state ?? '') }}">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Postal Code *</label>
                        <input type="text" name="receiver_postal_code" class="w-full border rounded px-3 py-2" required value="{{ old('receiver_postal_code', $shipment->receiver_postal_code ?? '') }}">
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
                            <option value="document" @if(old('shipment_type', $shipment->shipment_type ?? '') == 'document') selected @endif>Document</option>
                            <option value="package" @if(old('shipment_type', $shipment->shipment_type ?? '') == 'package') selected @endif>Package</option>
                            <option value="freight" @if(old('shipment_type', $shipment->shipment_type ?? '') == 'freight') selected @endif>Freight</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Document Category (if Document)</label>
                        <select name="document_category" class="w-full border rounded px-3 py-2">
                            <option value="">Select Category</option>
                            <option value="letter" @if(old('document_category', $shipment->document_category ?? '') == 'letter') selected @endif>Letter</option>
                            <option value="legal" @if(old('document_category', $shipment->document_category ?? '') == 'legal') selected @endif>Legal Documents</option>
                            <option value="contracts" @if(old('document_category', $shipment->document_category ?? '') == 'contracts') selected @endif>Contracts</option>
                            <option value="certificates" @if(old('document_category', $shipment->document_category ?? '') == 'certificates') selected @endif>Certificates</option>
                            <option value="other" @if(old('document_category', $shipment->document_category ?? '') == 'other') selected @endif>Other</option>
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
                        <input type="number" step="0.01" name="total_weight" class="w-full border rounded px-3 py-2" required value="{{ old('total_weight', $shipment->total_weight) }}">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Length (cm) *</label>
                        <input type="number" step="0.1" name="length" class="w-full border rounded px-3 py-2" required value="{{ old('length', $shipment->length ?? '') }}">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Width (cm) *</label>
                        <input type="number" step="0.1" name="width" class="w-full border rounded px-3 py-2" required value="{{ old('width', $shipment->width ?? '') }}">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Height (cm) *</label>
                        <input type="number" step="0.1" name="height" class="w-full border rounded px-3 py-2" required value="{{ old('height', $shipment->height ?? '') }}">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block font-semibold mb-1">Contents Description *</label>
                        <textarea name="contents_description" class="w-full border rounded px-3 py-2" rows="3" required placeholder="Brief description of items (e.g., electronics, clothing)">{{ old('contents_description', $shipment->contents_description ?? '') }}</textarea>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Declared Value ($) *</label>
                        <input type="number" step="0.01" name="declared_value" class="w-full border rounded px-3 py-2" required value="{{ old('declared_value', $shipment->declared_value ?? '') }}">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Commodity Code (HS Code)</label>
                        <input type="text" name="commodity_code" class="w-full border rounded px-3 py-2" placeholder="6-10 digit HS code for international shipments" value="{{ old('commodity_code', $shipment->commodity_code ?? '') }}">
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
                            <option value="Standard" @if(old('service_type', $shipment->service_type) == 'Standard') selected @endif>Standard</option>
                            <option value="Express" @if(old('service_type', $shipment->service_type) == 'Express') selected @endif>Express</option>
                            <option value="Overnight" @if(old('service_type', $shipment->service_type) == 'Overnight') selected @endif>Overnight</option>
                            <option value="Priority Overnight" @if(old('service_type', $shipment->service_type) == 'Priority Overnight') selected @endif>Priority Overnight</option>
                            <option value="International Priority" @if(old('service_type', $shipment->service_type) == 'International Priority') selected @endif>International Priority</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Price ($) *</label>
                        <input type="number" step="0.01" name="price" class="w-full border rounded px-3 py-2" required value="{{ old('price', $shipment->price) }}">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">ETA (optional)</label>
                        <input type="datetime-local" name="eta" class="w-full border rounded px-3 py-2" value="{{ old('eta', optional($shipment->eta)->format('Y-m-d\TH:i') ?? '') }}">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Status *</label>
                        <select name="status" class="w-full border rounded px-3 py-2" required>
                            @foreach(['Pending', 'In Transit', 'On Hold', 'Dispatched for Delivery', 'Delivered'] as $status)
                                <option value="{{ $status }}" @if(old('status', $shipment->status) == $status) selected @endif>{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Insurance -->
            <div class="border-b pb-6">
                <h2 class="text-lg font-semibold mb-4">Shipment Protection (Insurance)</h2>
                <div class="space-y-4">
                    <div class="flex items-center">
                        <input type="checkbox" name="insurance_enabled" id="insurance_enabled" class="mr-2" @if(old('insurance_enabled', $shipment->insurance_enabled ?? false)) checked @endif>
                        <label for="insurance_enabled" class="font-semibold">Insure my shipment</label>
                    </div>
                    <div id="insurance_details" class="{{ old('insurance_enabled', $shipment->insurance_enabled ?? false) ? '' : 'hidden' }}">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-semibold mb-1">Insurance Value ($)</label>
                                <input type="number" step="0.01" name="insurance_value" class="w-full border rounded px-3 py-2" value="{{ old('insurance_value', $shipment->insurance_value ?? '') }}">
                            </div>
                            <div>
                                <label class="block font-semibold mb-1">Insurance Cost ($)</label>
                                <input type="number" step="0.01" name="insurance_cost" class="w-full border rounded px-3 py-2" value="{{ old('insurance_cost', $shipment->insurance_cost ?? '') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.shipments.show', $shipment->id) }}" class="bg-gray-500 text-white px-6 py-2 rounded font-bold hover:bg-gray-600 transition">Cancel</a>
                <button type="submit" class="bg-blue-700 text-white px-6 py-2 rounded font-bold hover:bg-blue-800 transition">Update Shipment</button>
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