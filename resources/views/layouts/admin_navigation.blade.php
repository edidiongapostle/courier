<nav x-data="{ open: false }" class="bg-gray-900 text-white border-b border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex items-center space-x-8">
                <a href="/admin/dashboard" class="font-bold text-xl text-yellow-400">SWIFT SYNCH Admin</a>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/admin/dashboard" class="hover:text-yellow-400">Dashboard</a>
                    <a href="/admin/shipments/pending" class="hover:text-yellow-400">Pending Shipments</a>
                    <a href="/admin/users" class="hover:text-yellow-400">Users</a>
                    <a href="/admin/shipments" class="hover:text-yellow-400">All Shipments</a>
                </div>
            </div>
            <div class="hidden md:flex items-center space-x-4">
                <span class="text-sm">{{ auth('admin')->user()->name ?? 'Admin' }}</span>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="bg-yellow-400 text-gray-900 px-4 py-2 rounded font-bold hover:bg-yellow-500 transition">Logout</button>
                </form>
            </div>
            <!-- Hamburger -->
            <div class="md:hidden flex items-center">
                <button @click="open = !open" class="text-yellow-400 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
        <!-- Mobile Menu -->
        <div x-show="open" class="md:hidden mt-2 bg-gray-900 border rounded shadow-lg z-20">
            <a href="/admin/dashboard" class="block px-4 py-2 hover:text-yellow-400">Dashboard</a>
            <a href="/admin/shipments/pending" class="block px-4 py-2 hover:text-yellow-400">Pending Shipments</a>
            <a href="/admin/users" class="block px-4 py-2 hover:text-yellow-400">Users</a>
            <a href="/admin/shipments" class="block px-4 py-2 hover:text-yellow-400">All Shipments</a>
            <div class="border-t my-2 border-gray-700"></div>
            <span class="block px-4 py-2 text-sm">{{ auth('admin')->user()->name ?? 'Admin' }}</span>
            <form method="POST" action="{{ route('admin.logout') }}" class="px-4 py-2">
                @csrf
                <button type="submit" class="w-full bg-yellow-400 text-gray-900 px-4 py-2 rounded font-bold hover:bg-yellow-500 transition">Logout</button>
            </form>
        </div>
    </div>
</nav> 