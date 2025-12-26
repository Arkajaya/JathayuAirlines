@extends('layouts.app')

@section('title', 'Beranda - Jathayu Airlines')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-primary via-blue-600 to-cyan-500 text-white overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-72 h-72 bg-white rounded-full -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-white rounded-full translate-x-1/3 translate-y-1/3"></div>
    </div>

    <div class="container mx-auto px-20 py-20 md:py-32 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Left Content -->
            <div class="space-y-8">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight">
                    Terbang Lebih Tinggi dengan 
                    <span class="bg-gradient-to-r from-accent to-light bg-clip-text text-transparent">
                        Jathayu Airlines
                    </span>
                </h1>
                
                <p class="text-xl text-gray-100 leading-relaxed">
                    Pengalaman terbang terbaik ke berbagai destinasi di Indonesia dengan harga terjangkau dan layanan premium.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('bookings.index') }}" 
                       class="bg-white text-primary px-8 py-4 rounded-xl font-bold text-lg hover:bg-gray-100 hover:scale-105 transition-all duration-300 shadow-2xl flex items-center justify-center">
                        <i class="fas fa-plane-departure mr-3"></i>
                        Pesan Sekarang
                    </a>
                    
                    <a href="#search-flight" 
                       class="bg-transparent border-2 border-white text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-white/10 hover:scale-105 transition-all duration-300 flex items-center justify-center">
                        <i class="fas fa-search mr-3"></i>
                        Cari Penerbangan
                    </a>
                </div>
                
                <!-- Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 pt-8">
                    <div class="text-center">
                        <div class="text-3xl font-bold">500+</div>
                        <div class="text-gray-200 text-sm">Penerbangan/Minggu</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold">95%</div>
                        <div class="text-gray-200 text-sm">Ketepatan Waktu</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold">50+</div>
                        <div class="text-gray-200 text-sm">Destinasi</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold">1M+</div>
                        <div class="text-gray-200 text-sm">Penumpang</div>
                    </div>
                </div>
            </div>
            
            <!-- Right Content - Airplane Image -->
            <div class="relative">
                <div class="relative">
                    <img src="{{ asset('images/pesawat1.png') }}" 
                         alt="Jathayu Airlines Plane" 
                         class="transform hover:scale-105 transition-transform duration-500">
                    
                    <!-- Floating Badge -->
                    <div class="absolute -top-4 -right-4 bg-gradient-to-r from-yellow-400 to-orange-500 text-white px-6 py-3 rounded-xl shadow-2xl animate-float">
                        <div class="flex items-center">
                            <i class="fas fa-star text-lg mr-2"></i>
                            <div>
                                <div class="font-bold text-sm">RATING 4.8/5</div>
                                <div class="text-xs">Berdasarkan 10K+ review</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Wave Divider -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 200" class="w-full">
            <path fill="#ffffff" fill-opacity="1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,112C672,96,768,96,864,112C960,128,1056,160,1152,160C1248,160,1344,128,1392,112L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">
                Mengapa Memilih 
                <span class="text-primary">Jathayu?</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Kami memberikan pengalaman terbang terbaik untuk Anda
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Safety -->
            <div class="group bg-gradient-to-b from-white to-gray-50 p-8 rounded-2xl border border-gray-100 hover:border-primary hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                <div class="w-16 h-16 bg-gradient-to-br from-primary to-secondary rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-shield-alt text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Keamanan Terjamin</h3>
                <p class="text-gray-600 leading-relaxed">
                    Standar keamanan tinggi dengan pilot berpengalaman dan perawatan pesawat berkala.
                </p>
            </div>
            
            <!-- Punctuality -->
            <div class="group bg-gradient-to-b from-white to-gray-50 p-8 rounded-2xl border border-gray-100 hover:border-primary hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                <div class="w-16 h-16 bg-gradient-to-br from-primary to-secondary rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-clock text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Tepat Waktu</h3>
                <p class="text-gray-600 leading-relaxed">
                    Tingkat ketepatan waktu 95% dalam 6 bulan terakhir dengan sistem operasi terintegrasi.
                </p>
            </div>
            
            <!-- 24/7 Service -->
            <div class="group bg-gradient-to-b from-white to-gray-50 p-8 rounded-2xl border border-gray-100 hover:border-primary hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                <div class="w-16 h-16 bg-gradient-to-br from-primary to-secondary rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-headset text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Layanan 24/7</h3>
                <p class="text-gray-600 leading-relaxed">
                    Customer service siap membantu kapan saja melalui chat, telepon, dan email.
                </p>
            </div>
            
            <!-- Affordable -->
            <div class="group bg-gradient-to-b from-white to-gray-50 p-8 rounded-2xl border border-gray-100 hover:border-primary hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                <div class="w-16 h-16 bg-gradient-to-br from-primary to-secondary rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-tags text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Harga Terjangkau</h3>
                <p class="text-gray-600 leading-relaxed">
                    Harga kompetitif dengan fasilitas premium dan berbagai pilihan kelas penerbangan.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Flight Search Section -->
<section id="search-flight" class="py-20 bg-gradient-to-b from-gray-50 to-white">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row justify-between items-center mb-12">
            <div>
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Penerbangan Tersedia</h2>
                <p class="text-xl text-gray-600">Temukan penerbangan terbaik untuk perjalanan Anda</p>
            </div>
            <a href="{{ route('bookings.index') }}" 
               class="mt-4 lg:mt-0 bg-primary text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-secondary hover:scale-105 transition-all duration-300 flex items-center">
                Lihat Semua
                <i class="fas fa-arrow-right ml-3"></i>
            </a>
        </div>
        
        <!-- Flight Search Form -->
        <div class="bg-white rounded-2xl shadow-2xl p-8 mb-12">
            <form action="{{ route('bookings.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div>
                    <label class="block text-gray-700 mb-2 font-medium">Dari</label>
                    <div class="relative">
                        <i class="fas fa-plane-departure absolute left-4 top-4 text-gray-400"></i>
                        <select name="from" class="w-full pl-12 pr-4 py-4 border border-gray-300 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 focus:outline-none transition-all">
                            <option value="">Pilih Kota Asal</option>
                            <option value="Jakarta (CGK)">Jakarta (CGK)</option>
                            <option value="Denpasar (DPS)">Denpasar (DPS)</option>
                            <option value="Surabaya (SUB)">Surabaya (SUB)</option>
                            <option value="Medan (KNO)">Medan (KNO)</option>
                            <option value="Yogyakarta (YIA)">Yogyakarta (YIA)</option>
                        </select>
                    </div>
                </div>
                
                <div>
                    <label class="block text-gray-700 mb-2 font-medium">Ke</label>
                    <div class="relative">
                        <i class="fas fa-plane-arrival absolute left-4 top-4 text-gray-400"></i>
                        <select name="to" class="w-full pl-12 pr-4 py-4 border border-gray-300 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 focus:outline-none transition-all">
                            <option value="">Pilih Kota Tujuan</option>
                            <option value="Denpasar (DPS)">Denpasar (DPS)</option>
                            <option value="Jakarta (CGK)">Jakarta (CGK)</option>
                            <option value="Surabaya (SUB)">Surabaya (SUB)</option>
                            <option value="Medan (KNO)">Medan (KNO)</option>
                            <option value="Makassar (UPG)">Makassar (UPG)</option>
                        </select>
                    </div>
                </div>
                
                <div>
                    <label class="block text-gray-700 mb-2 font-medium">Tanggal Berangkat</label>
                    <div class="relative">
                        <i class="fas fa-calendar-alt absolute left-4 top-4 text-gray-400"></i>
                        <input type="date" 
                               name="date" 
                               class="w-full pl-12 pr-4 py-4 border border-gray-300 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 focus:outline-none transition-all"
                               value="{{ date('Y-m-d') }}">
                    </div>
                </div>
                
                <div>
                    <label class="block text-gray-700 mb-2 font-medium">Penumpang</label>
                    <div class="relative">
                        <i class="fas fa-users absolute left-4 top-4 text-gray-400"></i>
                        <select name="passengers" class="w-full pl-12 pr-4 py-4 border border-gray-300 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 focus:outline-none transition-all">
                            <option value="1">1 Penumpang</option>
                            <option value="2" selected>2 Penumpang</option>
                            <option value="3">3 Penumpang</option>
                            <option value="4">4 Penumpang</option>
                            <option value="5">5 Penumpang</option>
                            <option value="6">6+ Penumpang</option>
                        </select>
                    </div>
                </div>
                
                <div class="md:col-span-2 lg:col-span-4 flex justify-center mt-4">
                    <button type="submit" 
                            class="bg-gradient-to-r from-primary to-secondary text-white px-12 py-4 rounded-xl font-bold text-lg hover:shadow-xl hover:scale-105 transition-all duration-300 flex items-center">
                        <i class="fas fa-search mr-3"></i>
                        Cari Penerbangan
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Available Flights -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            @foreach($flights as $flight)
            <div class="bg-white rounded-2xl shadow-xl hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 border-l-4 border-primary">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $flight->departure_city }} → {{ $flight->arrival_city }}</h3>
                            <div class="flex items-center mt-2">
                                <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm font-medium mr-3">
                                    {{ $flight->flight_number }}
                                </span>
                                <span class="bg-blue-100 text-primary px-3 py-1 rounded-full text-sm font-medium">
                                    {{ strtoupper($flight->class) }}
                                </span>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-3xl font-bold text-primary">Rp {{ number_format($flight->price, 0, ',', '.') }}</div>
                            <div class="text-gray-500 text-sm">per orang</div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div>
                            <div class="text-gray-500 text-sm mb-1">Keberangkatan</div>
                            <div class="flex items-center">
                                <i class="fas fa-plane-departure text-primary mr-3"></i>
                                <div>
                                    <div class="font-bold text-gray-900">{{ $flight->departure_time->format('d M Y, H:i') }}</div>
                                    <div class="text-sm text-gray-500">{{ $flight->departure_city }}</div>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="text-gray-500 text-sm mb-1">Kedatangan</div>
                            <div class="flex items-center">
                                <i class="fas fa-plane-arrival text-primary mr-3"></i>
                                <div>
                                    <div class="font-bold text-gray-900">{{ $flight->arrival_time->format('d M Y, H:i') }}</div>
                                    <div class="text-sm text-gray-500">{{ $flight->arrival_city }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center pt-6 border-t border-gray-100">
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center">
                                <i class="fas fa-chair text-gray-400 mr-2"></i>
                                <span class="text-gray-700">{{ $flight->available_seats }} kursi tersedia</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-clock text-gray-400 mr-2"></i>
                                <span class="text-gray-700">{{ floor($flight->duration / 60) }}j {{ $flight->duration % 60 }}m</span>
                            </div>
                        </div>
                        
                        <a href="{{ route('bookings.index') }}?flight={{ $flight->id }}" 
                           class="bg-primary text-white px-6 py-3 rounded-xl font-medium hover:bg-secondary hover:scale-105 transition-all duration-300">
                            Pesan Sekarang
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Blog Section -->
<section class="py-20 bg-gradient-to-b from-white to-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Tips & Artikel Terbaru</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Informasi terbaru seputar perjalanan, tips penerbangan, dan promo menarik
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($blogs as $blog)
            <div class="bg-white rounded-2xl shadow-xl hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 overflow-hidden">
                <div class="h-48 bg-gradient-to-r from-primary to-secondary flex items-center justify-center">
                    <i class="fas fa-newspaper text-white text-5xl opacity-50"></i>
                </div>
                <div class="p-6">
                    <div class="flex items-center text-gray-500 text-sm mb-4">
                        <i class="fas fa-user-circle mr-2"></i>
                        {{ $blog->author }}
                        <span class="mx-2">•</span>
                        <i class="fas fa-calendar-alt mr-2"></i>
                        {{ $blog->created_at->format('d M Y') }}
                    </div>
                    
                    <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $blog->title }}</h3>
                    <p class="text-gray-600 mb-6">{{ Str::limit($blog->excerpt, 120) }}</p>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500 text-sm">
                            <i class="fas fa-eye mr-1"></i>
                            {{ $blog->views }} views
                        </span>
                        <a href="{{ route('blogs.show', $blog->slug) }}" 
                           class="text-primary font-medium hover:text-secondary transition-colors duration-300 flex items-center">
                            Baca Artikel
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-12">
            <a href="{{ route('blogs.index') }}" 
               class="inline-flex items-center bg-gradient-to-r from-primary to-secondary text-white px-8 py-4 rounded-xl font-bold text-lg hover:shadow-xl hover:scale-105 transition-all duration-300">
                Lihat Semua Artikel
                <i class="fas fa-arrow-right ml-3"></i>
            </a>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-20 bg-gradient-to-r from-primary via-blue-600 to-secondary text-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-4xl font-bold mb-6">Siap untuk Memulai Perjalanan Anda?</h2>
        <p class="text-xl mb-10 max-w-3xl mx-auto">
            Bergabung dengan ribuan penumpang yang telah mempercayakan perjalanan mereka kepada Jathayu Airlines
        </p>
        <div class="flex flex-col sm:flex-row gap-6 justify-center">
            <a href="{{ route('register') }}" 
               class="bg-white text-primary px-8 py-4 rounded-xl font-bold text-lg hover:bg-gray-100 hover:scale-105 transition-all duration-300">
                Daftar Sekarang
            </a>
            <a href="{{ route('bookings.index') }}" 
               class="bg-transparent border-2 border-white text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-white/10 hover:scale-105 transition-all duration-300">
                Pesan Tiket
            </a>
            <a href="{{ route('checkin.index') }}" 
               class="bg-transparent border-2 border-white text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-white/10 hover:scale-105 transition-all duration-300">
                Check-in Online
            </a>
        </div>
    </div>
</section>

<!-- Scroll to Top Button -->
@include('components.scroll-top')
@endsection