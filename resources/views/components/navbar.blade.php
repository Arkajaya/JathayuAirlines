<nav x-data="{ open: false, servicesOpen: false, infoOpen: false }" class="sticky top-0 z-50 bg-white/95 backdrop-blur-md shadow-lg border-b border-gray-100">
    <div class="container mx-auto px-4">
        <!-- Top Bar -->
        <div class="flex items-center justify-between h-20">
            <!-- Logo -->
            <div class="flex items-center space-x-3">
                <a href="{{ route('home') }}" class="flex items-center space-x-3">
                    <img src="{{ asset('logo.png') }}" alt="Jathayu Airlines" class="h-28">
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center space-x-8">
                <!-- Home Link -->
                <a href="{{ route('home') }}" 
                   class="text-gray-700 hover:text-primary font-medium transition-colors duration-300 {{ request()->is('/') ? 'text-primary font-semibold' : '' }}">
                    Beranda
                </a>

                <!-- Services Dropdown -->
                <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                    <button class="flex items-center text-gray-700 hover:text-primary font-medium transition-colors duration-300">
                        Layanan Penerbangan
                        <i class="fas fa-chevron-down ml-2 text-xs" :class="{ 'rotate-180': open }"></i>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute left-0 mt-2 w-72 bg-white rounded-xl shadow-2xl border border-gray-100 py-4 z-50"
                         style="display: none;">
                        <div class="space-y-1">
                            <!-- Flight Booking -->
                            <a href="{{ route('bookings.index') }}" 
                               class="flex items-center px-6 py-3 hover:bg-blue-50 group transition-colors duration-300">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-100 to-blue-200 rounded-lg flex items-center justify-center mr-4 group-hover:from-blue-200 group-hover:to-blue-300 transition-all duration-300">
                                    <i class="fas fa-plane text-primary text-lg"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900">Reservasi Tiket</h4>
                                    <p class="text-sm text-gray-500">Pesan penerbangan Anda</p>
                                </div>
                            </a>
                            
                            <!-- Online Check-in -->
                            <a href="{{ route('checkin.index') }}" 
                               class="flex items-center px-6 py-3 hover:bg-green-50 group transition-colors duration-300">
                                <div class="w-10 h-10 bg-gradient-to-br from-green-100 to-green-200 rounded-lg flex items-center justify-center mr-4 group-hover:from-green-200 group-hover:to-green-300 transition-all duration-300">
                                    <i class="fas fa-check-circle text-green-600 text-lg"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900">Check-in Online</h4>
                                    <p class="text-sm text-gray-500">Check-in cepat & mudah</p>
                                </div>
                            </a>
                            
                            
                        </div>
                        
                        <div class="border-t border-gray-100 mt-4 pt-4 px-6">
                            <a href="#" class="text-primary hover:text-secondary font-medium text-sm flex items-center">
                                Lihat Semua Layanan
                                <i class="fas fa-arrow-right ml-2 text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Information Dropdown -->
                <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                    <button class="flex items-center text-gray-700 hover:text-primary font-medium transition-colors duration-300">
                        Informasi & Tips
                        <i class="fas fa-chevron-down ml-2 text-xs" :class="{ 'rotate-180': open }"></i>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute left-0 mt-2 w-80 bg-white rounded-xl shadow-2xl border border-gray-100 py-4 z-50"
                         style="display: none;">
                        <div class="px-4 pb-3">
                            <h4 class="font-bold text-gray-900 text-lg mb-3">Blog & Artikel</h4>
                            <div class="space-y-3">
                                <a href="{{ route('blogs.index') }}" 
                                   class="flex items-center p-3 hover:bg-gray-50 rounded-lg transition-colors duration-300 group">
                                    <div class="w-12 h-12 bg-gradient-to-br from-primary/10 to-secondary/10 rounded-lg flex items-center justify-center mr-3 group-hover:from-primary/20 group-hover:to-secondary/20">
                                        <i class="fas fa-newspaper text-primary"></i>
                                    </div>
                                    <div>
                                        <h5 class="font-semibold text-gray-900">Artikel Perjalanan</h5>
                                        <p class="text-sm text-gray-500">Tips & panduan</p>
                                    </div>
                                </a>
                                
                                <a href="{{ route('infographics') }}" 
                                   class="flex items-center p-3 hover:bg-gray-50 rounded-lg transition-colors duration-300 group">
                                    <div class="w-12 h-12 bg-gradient-to-br from-primary/10 to-secondary/10 rounded-lg flex items-center justify-center mr-3 group-hover:from-primary/20 group-hover:to-secondary/20">
                                        <i class="fas fa-chart-bar text-primary"></i>
                                    </div>
                                    <div>
                                        <h5 class="font-semibold text-gray-900">Statistik Penerbangan</h5>
                                        <p class="text-sm text-gray-500">Data & infografis</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        
                        <div class="border-t border-gray-100 pt-4 px-4">
                            <h4 class="font-bold text-gray-900 text-lg mb-3">Quick Info</h4>
                            <div class="grid grid-cols-2 gap-3">
                                <a href="{{ route('destinations') }}" class="p-3 bg-gray-50 hover:bg-blue-50 rounded-lg transition-colors duration-300">
                                    <div class="flex items-center">
                                        <i class="fas fa-map-marker-alt text-blue-600 mr-2"></i>
                                        <span class="text-sm font-medium">Destinasi</span>
                                    </div>
                                </a>
                                <a href="#footer" class="p-3 bg-gray-50 hover:bg-yellow-50 rounded-lg transition-colors duration-300">
                                    <div class="flex items-center">
                                        <i class="fas fa-info-circle text-yellow-600 mr-2"></i>
                                        <span class="text-sm font-medium">Tentang</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Destinations Link -->
                <a href="{{ route('destinations') }}" 
                   class="text-gray-700 hover:text-primary font-medium transition-colors duration-300">
                    Destinasi
                </a>

                <!-- Get in Touch Button -->
                <a href="#footer" 
                   class="bg-gradient-to-r from-primary to-secondary text-white px-6 py-3 rounded-xl font-medium hover:shadow-lg hover:scale-105 transition-all duration-300">
                    Hubungi Kami
                </a>
            </div>

            <!-- User Menu & Mobile Toggle -->
            <div class="flex items-center space-x-4">
                @auth
                    <!-- User Dropdown -->
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = !open" 
                                class="flex items-center space-x-3 focus:outline-none">
                            <div class="w-10 h-10 bg-gradient-to-br from-primary to-secondary rounded-full flex items-center justify-center">
                                <span class="text-white font-bold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                            <div class="hidden lg:block text-left">
                                <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ Auth::user()->isAdmin() ? 'Admin' : 'Penumpang' }}</p>
                            </div>
                            <i class="fas fa-chevron-down text-gray-400 text-xs" :class="{ 'rotate-180': open }"></i>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-2xl border border-gray-100 py-2 z-50"
                             style="display: none;">
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-base font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                            </div>
                            
                            <div class="py-2">
                                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <i class="fas fa-user mr-3 text-gray-400"></i>
                                    Profil Saya
                                </a>
                                <a href="{{ route('bookings.my-bookings') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <i class="fas fa-ticket-alt mr-3 text-gray-400"></i>
                                    Riwayat Pemesanan
                                </a>
                                <a href="{{ route('checkin.index') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <i class="fas fa-check-circle mr-3 text-gray-400"></i>
                                    Check-in Online
                                </a>

                                <a href="{{ route('cancellations.index') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <i class="fas fa-circle-xmark mr-3 text-gray-400"></i>
                                    Pengajuan Pembatalan
                                </a>
                                
                                @if(Auth::user()->isAdmin())
                                    <div class="border-t border-gray-100 my-2"></div>
                                    <a href="{{ url(config('filament.path', 'admin')) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                        <i class="fas fa-chart-line mr-3 text-primary"></i>
                                        <span class="font-medium text-primary">Dashboard Admin</span>
                                    </a>
                                @endif
                                
                                <div class="border-t border-gray-100 my-2"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        <i class="fas fa-sign-out-alt mr-3"></i>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Login/Register Links -->
                    <div class="hidden lg:flex items-center space-x-4">
                        <a href="{{ route('login') }}" 
                           class="text-gray-700 hover:text-primary font-medium transition-colors duration-300">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" 
                           class="bg-gradient-to-r from-primary to-secondary text-white px-6 py-3 rounded-xl font-medium hover:shadow-lg hover:scale-105 transition-all duration-300">
                            Daftar
                        </a>
                    </div>
                @endauth

                <!-- Mobile Menu Button -->
                <button @click="open = !open" 
                        class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors duration-300">
                    <i class="fas fa-bars text-2xl text-gray-700"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="lg:hidden bg-white border-t border-gray-100 shadow-lg"
         style="display: none;">
        <div class="container mx-auto px-4 py-6">
            <div class="space-y-4">
                <a href="{{ route('home') }}" 
                   class="block py-3 px-4 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors duration-300">
                    <i class="fas fa-home mr-3"></i> Beranda
                </a>
                
                <!-- Mobile Services Dropdown -->
                <div>
                    <button @click="servicesOpen = !servicesOpen" 
                            class="flex items-center justify-between w-full py-3 px-4 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors duration-300">
                        <div class="flex items-center">
                            <i class="fas fa-plane mr-3"></i> Layanan Penerbangan
                        </div>
                        <i class="fas fa-chevron-down transition-transform duration-300" :class="{ 'rotate-180': servicesOpen }"></i>
                    </button>
                    
                    <div x-show="servicesOpen" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 -translate-y-2"
                         class="ml-8 mt-2 space-y-2"
                         style="display: none;">
                        <a href="{{ route('bookings.index') }}" class="block py-2 text-gray-600 hover:text-primary">Reservasi Tiket</a>
                        <a href="{{ route('checkin.index') }}" class="block py-2 text-gray-600 hover:text-primary">Check-in Online</a>
                    </div>
                </div>
                
                <!-- Mobile Info Dropdown -->
                <div>
                    <button @click="infoOpen = !infoOpen" 
                            class="flex items-center justify-between w-full py-3 px-4 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors duration-300">
                        <div class="flex items-center">
                            <i class="fas fa-info-circle mr-3"></i> Informasi & Tips
                        </div>
                        <i class="fas fa-chevron-down transition-transform duration-300" :class="{ 'rotate-180': infoOpen }"></i>
                    </button>
                    
                    <div x-show="infoOpen" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 -translate-y-2"
                         class="ml-8 mt-2 space-y-2"
                         style="display: none;">
                        <a href="{{ route('blogs.index') }}" class="block py-2 text-gray-600 hover:text-primary">Blog Perjalanan</a>
                        <a href="{{ route('infographics') }}" class="block py-2 text-gray-600 hover:text-primary">Statistik</a>
                    </div>
                </div>
                
                <a href="#footer" class="block py-3 px-4 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors duration-300">
                    <i class="fas fa-phone-alt mr-3"></i> Hubungi Kami
                </a>
                
                @auth
                    <div class="border-t border-gray-100 pt-4 mt-4">
                        <a href="{{ route('profile.edit') }}" class="block py-3 px-4 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors duration-300">
                            <i class="fas fa-user mr-3"></i> Profil Saya
                        </a>
                        <a href="{{ route('bookings.my-bookings') }}" class="block py-3 px-4 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors duration-300">
                            <i class="fas fa-ticket-alt mr-3"></i> Riwayat Pemesanan
                        </a>
                    </div>
                @else
                    <div class="border-t border-gray-100 pt-4 mt-4 space-y-3">
                        <a href="{{ route('login') }}" 
                           class="block py-3 px-4 text-center text-primary border border-primary rounded-lg hover:bg-primary hover:text-white transition-colors duration-300">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" 
                           class="block py-3 px-4 text-center bg-gradient-to-r from-primary to-secondary text-white rounded-lg hover:shadow-lg transition-all duration-300">
                            Daftar
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>