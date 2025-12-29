@extends('layouts.app')

@section('title', 'Lupa Password - Jathayu Airlines')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-primary/10 via-white to-accent/10 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-2xl font-semibold text-gray-900">Lupa Password</h2>
            <p class="mt-2 text-center text-sm text-gray-600">Masukkan email Anda untuk menerima tautan reset password.</p>
        </div>

        @if(session('status'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded">
                {{ session('status') }}
            </div>
        @endif

        <form class="mt-8 space-y-6" method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="rounded-md shadow-sm -space-y-px">
                <div>
                    <label for="email" class="sr-only">Email</label>
                    <input id="email" name="email" type="email" autocomplete="email" required 
                           class="appearance-none rounded-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-primary focus:border-primary focus:z-10 sm:text-sm"
                           placeholder="Alamat Email" value="{{ old('email') }}">
                    @if($errors->has('email'))
                        <p class="mt-2 text-sm text-rose-600">{{ $errors->first('email') }}</p>
                    @endif
                </div>
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-primary to-secondary hover:from-secondary hover:to-primary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all duration-300">
                    Kirim Tautan Reset
                </button>
            </div>
        </form>

        <div class="text-center text-sm text-gray-600">
            <a href="{{ route('login') }}" class="font-medium text-primary hover:text-secondary">Kembali ke Login</a>
        </div>
    </div>
</div>
@endsection
