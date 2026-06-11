@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-r from-yellow-400 via-yellow-500 to-red-500 py-12 mb-8">
    <div class="container mx-auto px-4 flex flex-col md:flex-row items-center justify-between">
        <div class="md:w-2/3 mb-8 md:mb-0">
            <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4">Get a Shipping Quote</h1>
            <p class="text-lg text-white mb-6">Packages and pallets, big and small, get an instant quote for your shipping needs. Domestic and international. Fast, reliable, and secure.</p>
        </div>
    </div>
</div>
<div class="container mx-auto px-4 pb-12">
    <div class="max-w-3xl mx-auto bg-white rounded shadow p-8 mb-8" x-data="Object.assign(rateForm(), { tab: 'quote' })">
        <div class="flex border-b border-gray-200 mb-6">
            <button @click="tab = 'quote'" :class="tab === 'quote' ? 'border-yellow-600 text-yellow-700' : 'border-transparent text-gray-500'" class="flex-1 px-6 py-4 font-bold text-lg border-b-2 focus:outline-none">Get a Quote</button>
            <button @click="tab = 'how'" :class="tab === 'how' ? 'border-yellow-600 text-yellow-700' : 'border-transparent text-gray-500'" class="flex-1 px-6 py-4 font-bold text-lg border-b-2 focus:outline-none">How it Works</button>
        </div>
        <div x-show="tab === 'quote'">
            <form method="POST" action="{{ route('rate.calculate') }}" class="space-y-8" @submit.prevent="validateAndSubmit">
                @csrf
                <!-- Information Of Sending -->
                <div class="border-b pb-6">
                    <h2 class="text-lg font-semibold mb-4 flex items-center"><span class="mr-2">&#128712;</span> Information Of Sending</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-1">Country</label>
                            <input type="text" name="origin_country" class="w-full border rounded px-3 py-2" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-1">Province/State</label>
                            <input type="text" name="origin_province" class="w-full border rounded px-3 py-2" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-1">Pickup Address <span class="text-gray-500 text-xs">(optional)</span></label>
                            <input type="text" name="origin_address" class="w-full border rounded px-3 py-2">
                        </div>
                    </div>
                </div>
                <!-- Information Of Receiving -->
                <div class="border-b pb-6">
                    <h2 class="text-lg font-semibold mb-4 flex items-center"><span class="mr-2">&#128712;</span> Information Of Receiving</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-1">Country</label>
                            <input type="text" name="dest_country" class="w-full border rounded px-3 py-2" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-1">Province/State</label>
                            <input type="text" name="dest_province" class="w-full border rounded px-3 py-2" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-1">Receiver Address <span class="text-gray-500 text-xs">(optional)</span></label>
                            <input type="text" name="dest_address" class="w-full border rounded px-3 py-2">
                        </div>
                    </div>
                </div>
                <!-- Information Of The Parcel -->
                <div class="border-b pb-6">
                    <h2 class="text-lg font-semibold mb-4 flex items-center"><span class="mr-2">&#128712;</span> Information Of The Parcel</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-1">Goods Type</label>
                            <select name="goods_type" class="w-full border rounded px-3 py-2" required x-model="goodsType" @change="updateIcons()">
                                <option value="">Select</option>
                                <option value="Document">Document</option>
                                <option value="Package">Package</option>
                                <option value="Freight">Freight</option>
                            </select>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto mb-4">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">Type</th>
                                    <th class="px-4 py-2">Goods Name</th>
                                    <th class="px-4 py-2">Quantity</th>
                                    <th class="px-4 py-2">Weight (kg)</th>
                                    <th class="px-4 py-2">Length (cm)</th>
                                    <th class="px-4 py-2">Width (cm)</th>
                                    <th class="px-4 py-2">Height (cm)</th>
                                    <th class="px-4 py-2"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="(parcel, idx) in parcels" :key="idx">
                                    <tr>
                                        <td class="text-center">
                                            <template x-if="goodsType === 'Document'"><span title="Document">📄</span></template>
                                            <template x-if="goodsType === 'Package'"><span title="Package">📦</span></template>
                                            <template x-if="goodsType === 'Freight'"><span title="Freight">🚚</span></template>
                                        </td>
                                        <td><input type="text" :name="'goods_name['+idx+']'" class="w-full border rounded px-2 py-1" x-model="parcel.goods_name" :class="{'border-red-500': errors[idx]?.goods_name}" required></td>
                                        <td><input type="number" :name="'quantity['+idx+']'" class="w-full border rounded px-2 py-1" min="1" x-model="parcel.quantity" :class="{'border-red-500': errors[idx]?.quantity}" required></td>
                                        <td><input type="number" step="0.01" :name="'weight['+idx+']'" class="w-full border rounded px-2 py-1" x-model="parcel.weight" :class="{'border-red-500': errors[idx]?.weight}" required></td>
                                        <td><input type="number" step="0.1" :name="'length['+idx+']'" class="w-full border rounded px-2 py-1" x-model="parcel.length" :class="{'border-red-500': errors[idx]?.length}" required></td>
                                        <td><input type="number" step="0.1" :name="'width['+idx+']'" class="w-full border rounded px-2 py-1" x-model="parcel.width" :class="{'border-red-500': errors[idx]?.width}" required></td>
                                        <td><input type="number" step="0.1" :name="'height['+idx+']'" class="w-full border rounded px-2 py-1" x-model="parcel.height" :class="{'border-red-500': errors[idx]?.height}" required></td>
                                        <td>
                                            <button type="button" class="text-red-600 font-bold" @click="parcels.length > 1 ? parcels.splice(idx, 1) : null">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                            </button>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                        <div class="flex justify-between items-center mb-2">
                            <div class="text-gray-700 font-semibold">
                                Total Quantity: <span x-text="totalQuantity()"></span> &nbsp; | &nbsp; Total Weight: <span x-text="totalWeight().toFixed(2)"></span> kg
                            </div>
                            <button type="button" class="text-orange-600 font-bold flex items-center" @click="parcels.push({goods_name: '', quantity: 1, weight: '', length: '', width: '', height: ''})">
                                <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                                Add Other Parcels
                            </button>
                        </div>
                        <template x-if="formError">
                            <div class="text-red-600 font-bold mt-2">Please fill all required fields for each parcel.</div>
                        </template>
                    </div>
                </div>
                <!-- Service Type -->
                <div class="border-b pb-6">
                    <h2 class="text-lg font-semibold mb-4 flex items-center"><span class="mr-2">&#128712;</span> Service Type</h2>
                    <select name="service_type" class="w-full px-4 py-2 border rounded" required>
                        <option value="Standard" @if(old('service_type', $result['service_type'] ?? '') == 'Standard') selected @endif>Standard</option>
                        <option value="Express" @if(old('service_type', $result['service_type'] ?? '') == 'Express') selected @endif>Express</option>
                        <option value="Overnight" @if(old('service_type', $result['service_type'] ?? '') == 'Overnight') selected @endif>Overnight</option>
                        <option value="Priority Overnight" @if(old('service_type', $result['service_type'] ?? '') == 'Priority Overnight') selected @endif>Priority Overnight</option>
                        <option value="International Priority" @if(old('service_type', $result['service_type'] ?? '') == 'International Priority') selected @endif>International Priority</option>
                    </select>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-yellow-600 text-white px-8 py-3 rounded font-bold text-lg hover:bg-yellow-700 transition">Get Quote</button>
                </div>
            </form>
            @if(isset($result))
                <div class="mt-12 p-6 bg-green-50 rounded shadow text-center">
                    <h2 class="text-2xl font-bold mb-2 text-green-700">Your Shipping Quote</h2>
                    <div class="text-lg mb-2">From <span class="font-semibold">{{ $result['origin'] }}</span> to <span class="font-semibold">{{ $result['destination'] }}</span></div>
                    <div class="text-lg mb-2">Weight: <span class="font-semibold">{{ $result['weight'] }} kg</span></div>
                    <div class="text-lg mb-2">Service: <span class="font-semibold">{{ $result['service_type'] }}</span></div>
                    <div class="text-3xl font-extrabold text-green-700 mb-2">${{ number_format($result['price'], 2) }}</div>
                    <div class="text-lg">Estimated Delivery Time: <span class="font-semibold">{{ $result['eta'] }}</span></div>
                </div>
            @endif
        </div>
        <div x-show="tab === 'how'">
            <h2 class="text-2xl font-bold mb-6 text-yellow-700">How It Works</h2>
            <ul class="space-y-4">
                <li class="bg-yellow-50 rounded shadow p-6">
                    <h3 class="text-lg font-bold mb-2 text-yellow-700">Step 1: Enter Shipment Details</h3>
                    <p>Fill in your sender, receiver, and parcel details. You can add multiple parcels for a single quote.</p>
                </li>
                <li class="bg-yellow-50 rounded shadow p-6">
                    <h3 class="text-lg font-bold mb-2 text-yellow-700">Step 2: Get Your Quote</h3>
                    <p>See your shipping price and estimated delivery time instantly. No hidden fees.</p>
                </li>
                <li class="bg-yellow-50 rounded shadow p-6">
                    <h3 class="text-lg font-bold mb-2 text-yellow-700">Step 3: Book & Ship</h3>
                    <p>If you’re happy with your quote, proceed to <a href="/shipments/request" class="text-blue-600 underline">Ship Now</a> and complete your booking.</p>
                </li>
                <li class="bg-yellow-50 rounded shadow p-6">
                    <h3 class="text-lg font-bold mb-2 text-yellow-700">FAQ</h3>
                    <ul class="list-disc pl-6 text-gray-700 text-left">
                        <li class="mb-2"><strong>What services do you offer?</strong> Standard, Express, Overnight, Priority Overnight, and International Priority shipping for documents, packages, and freight.</li>
                        <li class="mb-2"><strong>How is the price calculated?</strong> Based on total weight, service type, and other factors. Use the form to get an exact quote.</li>
                        <li class="mb-2"><strong>How do I track my shipment?</strong> Use the <a href="/tracking" class="text-blue-600 underline">Tracking</a> page with your tracking number or barcode.</li>
                        <li class="mb-2"><strong>Need help?</strong> <a href="/contact" class="text-blue-600 underline">Contact us</a> for support.</li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <div class="bg-yellow-50 rounded shadow p-8 text-center">
        <h2 class="text-xl font-bold mb-4 text-yellow-700">Why Choose SWIFT SYNCH?</h2>
        <ul class="text-lg text-gray-700 space-y-2">
            <li>✔️ Instant quotes for domestic and international shipping</li>
            <li>✔️ Transparent pricing, no hidden fees</li>
            <li>✔️ Fast, secure, and reliable delivery</li>
            <li>✔️ Multiple service options to fit your needs</li>
            <li>✔️ Dedicated customer support</li>
        </ul>
    </div>
</div>
@endsection 

<script>
function rateForm() {
    return {
        goodsType: '',
        parcels: [{goods_name: '', quantity: 1, weight: '', length: '', width: '', height: ''}],
        errors: [],
        formError: false,
        updateIcons() {
            // force Alpine to update icons by re-setting parcels
            this.parcels = this.parcels.map(p => Object.assign({}, p));
        },
        totalQuantity() {
            return this.parcels.reduce((sum, p) => sum + (parseInt(p.quantity) || 0), 0);
        },
        totalWeight() {
            return this.parcels.reduce((sum, p) => sum + (parseFloat(p.weight) || 0), 0);
        },
        validateAndSubmit(e) {
            this.errors = [];
            this.formError = false;
            let valid = true;
            this.parcels.forEach((p, idx) => {
                this.errors[idx] = {};
                if (!p.goods_name) { this.errors[idx].goods_name = true; valid = false; }
                if (!p.quantity || p.quantity < 1) { this.errors[idx].quantity = true; valid = false; }
                if (!p.weight) { this.errors[idx].weight = true; valid = false; }
                if (!p.length) { this.errors[idx].length = true; valid = false; }
                if (!p.width) { this.errors[idx].width = true; valid = false; }
                if (!p.height) { this.errors[idx].height = true; valid = false; }
            });
            if (!valid) {
                this.formError = true;
                return false;
            }
            this.$el.submit();
        }
    }
}
</script> 