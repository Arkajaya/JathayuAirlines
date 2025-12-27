@extends('layouts.app')

@section('title', 'Daftar - Jathayu Airlines')

@section('content')
<div class="min-h-screen flex space-x-9 justify-center bg-gradient-to-br from-primary/10 via-white to-accent/10 py-12 px-4 sm:px-6 lg:px-8">
    <div class=" max-w-md w-[70%] space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Buat Akun Baru
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-medium text-primary hover:text-secondary">
                    Masuk di sini
                </a>
            </p>
        </div>
        
        <form class="mt-8 space-y-6" action="{{ route('register') }}" method="POST">
            @csrf
            <div class="rounded-md shadow-sm space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input id="name" name="name" type="text" autocomplete="name" required 
                           class="appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-primary focus:border-primary sm:text-sm"
                           placeholder="Nama lengkap Anda">
                </div>
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input id="email" name="email" type="email" autocomplete="email" required 
                           class="appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-primary focus:border-primary sm:text-sm"
                           placeholder="Alamat email aktif">
                </div>
                
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                    <input id="phone" name="phone" type="tel" autocomplete="tel" 
                           class="appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-primary focus:border-primary sm:text-sm"
                           placeholder="08xxxxxxxxxx">
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input id="password" name="password" type="password" autocomplete="new-password" required 
                           class="appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-primary focus:border-primary sm:text-sm"
                           placeholder="Minimal 8 karakter">
                </div>
                
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required 
                           class="appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-primary focus:border-primary sm:text-sm"
                           placeholder="Ulangi password Anda">
                </div>
            </div>

            <div class="flex items-center">
                <input id="terms" name="terms" type="checkbox" required 
                       class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                <label for="terms" class="ml-2 block text-sm text-gray-900">
                    Saya menyetujui 
                    <a href="#" class="text-primary hover:text-secondary">Syarat & Ketentuan</a>
                    dan 
                    <a href="#" class="text-primary hover:text-secondary">Kebijakan Privasi</a>
                </label>
            </div>

            <div>
                <button type="submit" 
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-primary to-secondary hover:from-secondary hover:to-primary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all duration-300">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <i class="fas fa-user-plus text-white"></i>
                    </span>
                    Daftar Sekarang
                </button>
            </div>
            
            <div class="text-center">
                <p class="text-xs text-gray-500">
                    Dengan mendaftar, Anda akan mendapatkan akses ke:
                </p>
                <ul class="text-xs text-gray-500 mt-2 space-y-1">
                    <li class="flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                        Riwayat pemesanan tiket
                    </li>
                    <li class="flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                        Check-in online yang mudah
                    </li>
                    <li class="flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                        Notifikasi promo dan diskon
                    </li>
                </ul>
            </div>
        </form>
    </div>
     <div class="flex justify-center w-[38%] relative">
        <img src="{{ asset('logo.png') }}" alt="Jathayu Airlines" class="h-[38rem] absolute top-20 bg-sky-600/10 shadow-lg ">
    </div>
</div>
@endsection