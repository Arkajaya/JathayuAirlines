@extends('layouts.app')

@section('title', 'Reset Password - Jathayu Airlines')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-primary/10 via-white to-accent/10 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-2xl font-semibold text-gray-900">Reset Password</h2>
            <p class="mt-2 text-center text-sm text-gray-600">Masukkan password baru Anda.</p>
        </div>

        <form class="mt-8 space-y-6" method="POST" action="{{ route('password.store') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="rounded-md shadow-sm -space-y-px">
                <div>
                    <label for="email" class="sr-only">Email</label>
                    <input id="email" name="email" type="email" autocomplete="email" required 
                           class="appearance-none rounded-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-primary focus:border-primary focus:z-10 sm:text-sm"
                           placeholder="Alamat Email" value="{{ old('email', $request->email) }}">
                    @if($errors->has('email'))
                        <p class="mt-2 text-sm text-rose-600">{{ $errors->first('email') }}</p>
                    @endif
                </div>

                <div class="mt-4">
                    <label for="password" class="sr-only">Password</label>
                    <input id="password" name="password" type="password" required autocomplete="new-password"
                           class="appearance-none rounded-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm"
                           placeholder="Password baru">
                    @if($errors->has('password'))
                        <p class="mt-2 text-sm text-rose-600">{{ $errors->first('password') }}</p>
                    @endif
                </div>

                <div class="mt-4">
                    <label for="password_confirmation" class="sr-only">Konfirmasi Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                           class="appearance-none rounded-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-primary focus:border-primary sm:text-sm"
                           placeholder="Konfirmasi password">
                    @if($errors->has('password_confirmation'))
                        <p class="mt-2 text-sm text-rose-600">{{ $errors->first('password_confirmation') }}</p>
                    @endif
                </div>
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-primary to-secondary hover:from-secondary hover:to-primary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all duration-300">
                    Reset Password
                </button>
            </div>
        </form>

        <div class="text-center text-sm text-gray-600">
            <a href="{{ route('login') }}" class="font-medium text-primary hover:text-secondary">Kembali ke Login</a>
        </div>
    </div>
</div>
@endsection
