@extends('layouts.app')

@section('content')
<!-- HERO SECTION START -->
<div x-data="{
    slides: [
        { src: '/public/img/containers-railways-shipment-concept.jpg', alt: 'Logistics Hero 1' },
        { src: '/public/img/transport-logistics-products.jpg', alt: 'Logistics Hero 2' }
    ],
    active: 0,
    interval: null,
    next() {
        this.active = (this.active + 1) % this.slides.length
    },
    start() {
        if (this.interval) return;
        this.interval = setInterval(() => {
            this.next();
        }, 5000);
    },
    stop() {
        if (this.interval) clearInterval(this.interval);
        this.interval = null;
    },
    init() {
        this.start();
    }
}" x-init="init" class="relative min-h-[500px] flex flex-col justify-center items-center bg-gradient-to-br from-yellow-400/80 via-red-400/70 to-red-600/90 overflow-hidden">
    <!-- Slider Images -->
    <template x-for="(slide, i) in slides" :key="i">
        <img :src="slide.src" :alt="slide.alt" x-show="active === i" x-transition:enter="transition-opacity duration-700" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-60" x-transition:leave="transition-opacity duration-700" x-transition:leave-start="opacity-60" x-transition:leave-end="opacity-0" class="absolute inset-0 w-full h-full object-cover opacity-60 pointer-events-none" />
    </template>
    <!-- No dots or arrows -->
    <!-- Hero Content Overlay -->
    <div class="relative z-10 flex flex-col items-center w-full max-w-2xl mx-auto px-4 py-16 text-center">
        <h1 class="text-4xl md:text-5xl font-extrabold text-white drop-shadow mb-2">SWIFT SYNCH Express Shipping</h1>
        <p class="text-lg md:text-xl text-white/90 mb-8">Fast, reliable, and secure shipping for documents, parcels, and cargo—domestic and international.</p>
        <form class="flex mx-auto mb-8 max-w-xs sm:max-w-xl w-full justify-center" action="/tracking" method="GET">
            <div class="flex-1 relative">
                <input type="text" name="tracking" placeholder="Enter your tracking number" class="w-full rounded-l-lg px-3 py-2 text-base sm:px-5 sm:py-3 sm:text-lg shadow focus:ring-2 focus:ring-blue-500 outline-none" required>
                <span class="absolute left-2 sm:left-3 top-1/2 -translate-y-1/2 text-gray-400"><svg xmlns='http://www.w3.org/2000/svg' class='h-4 w-4 sm:h-5 sm:w-5' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z'/></svg></span>
            </div>
            <button class="bg-red-600 hover:bg-red-700 text-white font-bold px-4 py-2 text-base sm:px-8 sm:py-3 sm:text-lg rounded-r-lg shadow transition">Track</button>
        </form>
        <div class="flex flex-col md:flex-row gap-6 w-full max-w-3xl mb-8">
            <a href="/# " class="flex-1 bg-white/90 rounded-xl shadow-lg p-6 flex flex-col items-center hover:scale-105 hover:bg-yellow-50 transition">
                <svg class="w-10 h-10 text-yellow-500 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7l9-4 9 4-9 4-9-4zm0 7l9 4 9-4" /></svg>
                <span class="font-semibold text-lg">Ship Now</span>
            </a>
            <a href="/rate" class="flex-1 bg-white/90 rounded-xl shadow-lg p-6 flex flex-col items-center hover:scale-105 hover:bg-green-50 transition">
                <svg class="w-10 h-10 text-green-500 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zm0 0V4m0 8v8m8-8a8 8 0 11-16 0 8 8 0 0116 0z" /></svg>
                <span class="font-semibold text-lg">Get Quote</span>
            </a>
            <a href="/contact" class="flex-1 bg-white/90 rounded-xl shadow-lg p-6 flex flex-col items-center hover:scale-105 hover:bg-blue-50 transition">
                <svg class="w-10 h-10 text-blue-500 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 21v-2a4 4 0 014-4h10a4 4 0 014 4v2M16 3.13a4 4 0 010 7.75M8 3.13a4 4 0 000 7.75" /></svg>
                <span class="font-semibold text-lg text-center">Request Business Account</span>
            </a>
        </div>
    </div>
</div>
<!-- HERO SECTION END -->

<div class="bg-yellow-100 py-4">
    <div class="max-w-5xl mx-auto px-4 flex flex-col md:flex-row items-center justify-between">
        <div class="flex items-center space-x-4">
            <span class="font-bold text-yellow-900">Navigating Latest Tariff Developments</span>
            <a href="#" class="bg-yellow-400 text-yellow-900 font-bold px-4 py-2 rounded hover:bg-yellow-500 transition">Explore Our Solutions</a>
        </div>
        <span class="text-sm text-yellow-900 mt-2 md:mt-0">Stay up to date with regulatory and logistics changes</span>
    </div>
</div>

<div class="max-w-6xl mx-auto px-4 py-12 grid grid-cols-1 md:grid-cols-2 gap-8">
    <div class="bg-white rounded shadow p-6 flex flex-col md:flex-row items-center">
        <img src="/public/img/rosebox.jpg" alt="Document Shipping" class="w-32 h-32 object-cover rounded mr-6 mb-4 md:mb-0">
        <div>
            <h2 class="text-xl font-bold mb-2">Document and Parcel Shipping</h2>
            <p class="mb-2 text-gray-700">For all shippers. Next possible business day delivery, tailored business solutions, and import/export options.</p>
            <a href="/services" class="bg-red-700 text-white px-4 py-2 rounded font-bold hover:bg-red-800 transition">Explore Express</a>
        </div>
    </div>
    <div class="bg-white rounded shadow p-6 flex flex-col md:flex-row items-center">
        <img src="https://images.unsplash.com/photo-1515378791036-0648a3ef77b2?auto=format&fit=crop&w=400&q=80" alt="Retailer Shipping" class="w-32 h-32 object-cover rounded mr-6 mb-4 md:mb-0">
        <div>
            <h2 class="text-xl font-bold mb-2">Retailer or Volume Shipping</h2>
            <p class="mb-2 text-gray-700">Business only. Solutions for e-commerce, retail, and manufacturing. Volume discounts and dedicated support.</p>
            <a href="/contact" class="bg-yellow-500 text-yellow-900 px-4 py-2 rounded font-bold hover:bg-yellow-600 transition">Request Business Account</a>
        </div>
    </div>
    <div class="bg-white rounded shadow p-6 flex flex-col md:flex-row items-center">
        <img src="https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=400&q=80" alt="Cargo Shipping" class="w-32 h-32 object-cover rounded mr-6 mb-4 md:mb-0">
        <div>
            <h2 class="text-xl font-bold mb-2">Cargo Shipping</h2>
            <p class="mb-2 text-gray-700">Business only. Air, road, and sea freight. Discover shipping and logistics options for large shipments.</p>
            <a href="/services" class="bg-red-700 text-white px-4 py-2 rounded font-bold hover:bg-red-800 transition">Explore Global Forwarding</a>
        </div>
    </div>
    <div class="bg-white rounded shadow p-6 flex flex-col md:flex-row items-center">
        <img src="https://images.unsplash.com/photo-1504384308090-c894fdcc538d?auto=format&fit=crop&w=400&q=80" alt="Enterprise Logistics" class="w-32 h-32 object-cover rounded mr-6 mb-4 md:mb-0">
        <div>
            <h2 class="text-xl font-bold mb-2">Enterprise Logistics Services</h2>
            <p class="mb-2 text-gray-700">Business only. Supply chain, warehousing, packaging, and more. Custom solutions for your business.</p>
            <a href="/contact" class="bg-yellow-500 text-yellow-900 px-4 py-2 rounded font-bold hover:bg-yellow-600 transition">Contact Logistics Team</a>
        </div>
    </div>
</div>

<div class="bg-yellow-50 py-8">
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-2xl font-bold mb-4 text-yellow-900">Important Service Updates</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded shadow p-4">
                <h3 class="font-bold text-lg mb-2">Sustainability</h3>
                <p class="text-gray-700 mb-2">Learn about SWIFT SYNCH's green logistics and sustainable shipping initiatives for a better future.</p>
                <a href="#" class="text-yellow-700 font-bold hover:underline">Read More</a>
            </div>
            <div class="bg-white rounded shadow p-4">
                <h3 class="font-bold text-lg mb-2">Innovation</h3>
                <p class="text-gray-700 mb-2">How technology is shaping next-generation logistics and delivery for our customers worldwide.</p>
                <a href="#" class="text-yellow-700 font-bold hover:underline">Read More</a>
            </div>
            <div class="bg-white rounded shadow p-4">
                <h3 class="font-bold text-lg mb-2">Trade Africa 2025</h3>
                <p class="text-gray-700 mb-2">Our vision for 2025 and the trends to grow African trade and logistics through new technology and partnerships.</p>
                <a href="#" class="text-yellow-700 font-bold hover:underline">Read More</a>
            </div>
        </div>
    </div>
</div>
@endsection 