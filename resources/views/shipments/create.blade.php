@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">Request a Shipment</h1>
    <form method="POST" action="{{ route('shipments.store') }}">
        @csrf
        <div class="mb-4">
            <label for="service_type" class="block text-gray-700">Service Type</label>
            <select id="service_type" name="service_type" class="w-full px-3 py-2 border rounded" required>
                <option value="">Select Service</option>
                <option value="Standard">Standard</option>
                <option value="Express">Express</option>
            </select>
        </div>
        <div id="packages">
            <h2 class="text-lg font-semibold mb-2">Packages</h2>
            <div class="package mb-4 border p-4 rounded bg-gray-50">
                <div class="mb-2">
                    <label class="block text-gray-700">Weight (kg)</label>
                    <input type="number" step="0.01" name="packages[0][weight]" class="w-full px-3 py-2 border rounded" required>
                </div>
                <div class="mb-2">
                    <label class="block text-gray-700">Length (cm)</label>
                    <input type="number" step="0.01" name="packages[0][length]" class="w-full px-3 py-2 border rounded" required>
                </div>
                <div class="mb-2">
                    <label class="block text-gray-700">Width (cm)</label>
                    <input type="number" step="0.01" name="packages[0][width]" class="w-full px-3 py-2 border rounded" required>
                </div>
                <div class="mb-2">
                    <label class="block text-gray-700">Height (cm)</label>
                    <input type="number" step="0.01" name="packages[0][height]" class="w-full px-3 py-2 border rounded" required>
                </div>
            </div>
        </div>
        <button type="button" id="add-package" class="mb-4 bg-green-600 text-white px-4 py-2 rounded">Add Another Package</button>
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded">Submit Request</button>
    </form>
</div>
<script>
    let packageIndex = 1;
    document.getElementById('add-package').addEventListener('click', function(e) {
        e.preventDefault();
        const container = document.createElement('div');
        container.className = 'package mb-4 border p-4 rounded bg-gray-50';
        container.innerHTML = `
            <div class=\"mb-2\">
                <label class=\"block text-gray-700\">Weight (kg)</label>
                <input type=\"number\" step=\"0.01\" name=\"packages[${packageIndex}][weight]\" class=\"w-full px-3 py-2 border rounded\" required>
            </div>
            <div class=\"mb-2\">
                <label class=\"block text-gray-700\">Length (cm)</label>
                <input type=\"number\" step=\"0.01\" name=\"packages[${packageIndex}][length]\" class=\"w-full px-3 py-2 border rounded\" required>
            </div>
            <div class=\"mb-2\">
                <label class=\"block text-gray-700\">Width (cm)</label>
                <input type=\"number\" step=\"0.01\" name=\"packages[${packageIndex}][width]\" class=\"w-full px-3 py-2 border rounded\" required>
            </div>
            <div class=\"mb-2\">
                <label class=\"block text-gray-700\">Height (cm)</label>
                <input type=\"number\" step=\"0.01\" name=\"packages[${packageIndex}][height]\" class=\"w-full px-3 py-2 border rounded\" required>
            </div>
        `;
        document.getElementById('packages').appendChild(container);
        packageIndex++;
    });
</script>
@endsection 