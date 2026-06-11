<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="/" class="flex items-center">
                    <img src="/public/images/logo.png" alt="SWIFT SYNCH" class="h-16 w-auto" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                    <span class="font-bold text-xl text-blue-700" style="display: none;">SWIFT SYNCH</span>
                </a>
            </div>
            
            <!-- Centered Navigation Links -->
            <div class="hidden md:flex items-center space-x-8 absolute left-1/2 transform -translate-x-1/2">
                <a href="/" class="text-gray-700 hover:text-blue-700">Home</a>
                <a href="/tracking" class="text-gray-700 hover:text-blue-700">Tracking</a>
                <div class="relative" x-data="{ shippingOpen: false }">
                    <button @click="shippingOpen = !shippingOpen" @click.away="shippingOpen = false" class="text-gray-700 hover:text-blue-700 focus:outline-none">Shipping</button>
                    <div x-show="shippingOpen" class="absolute left-1/2 transform -translate-x-1/2 mt-2 w-32 bg-white border rounded shadow-lg z-10">
                        <a href="/shipments/request" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Ship Now</a>
                        <a href="/rate" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Rate</a>
                    </div>
                </div>
                <a href="/services" class="text-gray-700 hover:text-blue-700">Services</a>
                <a href="/contact" class="text-gray-700 hover:text-blue-700">Contact</a>
                <a href="/about" class="text-gray-700 hover:text-blue-700">About</a>
            </div>
            
            <!-- Right side - Dashboard link or empty space -->
            <div class="hidden md:flex items-center space-x-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="text-blue-700 font-semibold">Dashboard</a>
                @endauth
            </div>
            <!-- Hamburger -->
            <div class="md:hidden flex items-center">
                <button @click="open = !open" class="text-gray-700 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
        <!-- Mobile Menu -->
        <div x-show="open" class="md:hidden mt-2 bg-white border rounded shadow-lg z-20">
            <a href="/" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Home</a>
            <a href="/tracking" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Tracking</a>
            <div x-data="{ shippingOpen: false }" class="relative">
                <button @click="shippingOpen = !shippingOpen" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-blue-50 flex items-center justify-between">
                    Shipping
                    <svg :class="{'transform rotate-180': shippingOpen}" class="h-4 w-4 ml-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="shippingOpen" class="pl-4">
                    <a href="/shipments/request" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Ship Now</a>
                    <a href="/rate" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Rate</a>
                </div>
            </div>
            <a href="/services" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Services</a>
            <a href="/contact" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Contact</a>
            <a href="/about" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">About</a>
            <div class="border-t my-2"></div>
            @auth
                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-blue-700 font-semibold">Dashboard</a>
            @endauth
        </div>
    </div>
</nav>
