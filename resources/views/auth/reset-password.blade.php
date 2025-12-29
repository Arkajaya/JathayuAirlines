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

                <div class="mt-4 relative">
                    <label for="password" class="sr-only">Password</label>
                    <input id="password" name="password" type="password" required autocomplete="new-password"
                           class="appearance-none rounded-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm"
                           placeholder="Password baru" data-password-toggle="true">
                    <button type="button" id="toggleResetPassword" aria-label="Toggle password visibility" class="absolute right-2 top-3 text-gray-500 hover:text-gray-700">
                        <svg id="resetEyeOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 3C6 3 2.73 5.11 1 8.5 2.73 11.89 6 14 10 14s7.27-2.11 9-5.5C17.27 5.11 14 3 10 3zM10 12a2 2 0 110-4 2 2 0 010 4z" />
                        </svg>
                        <svg id="resetEyeClosed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M3.172 3.172a4 4 0 015.656 0L10 4.343l1.172-1.171a4 4 0 115.656 5.656L10 16.657 3.172 9.83a4 4 0 010-5.657z" />
                        </svg>
                    </button>
                    @if($errors->has('password'))
                        <p class="mt-2 text-sm text-rose-600">{{ $errors->first('password') }}</p>
                    @endif
                </div>

                <div class="mt-4 relative">
                    <label for="password_confirmation" class="sr-only">Konfirmasi Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                           class="appearance-none rounded-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-primary focus:border-primary sm:text-sm"
                           placeholder="Konfirmasi password" data-password-toggle="true">
                    <button type="button" id="toggleResetPasswordConfirm" aria-label="Toggle password visibility" class="absolute right-2 top-3 text-gray-500 hover:text-gray-700">
                        <svg id="resetConfirmEyeOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 3C6 3 2.73 5.11 1 8.5 2.73 11.89 6 14 10 14s7.27-2.11 9-5.5C17.27 5.11 14 3 10 3zM10 12a2 2 0 110-4 2 2 0 010 4z" />
                        </svg>
                        <svg id="resetConfirmEyeClosed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M3.172 3.172a4 4 0 015.656 0L10 4.343l1.172-1.171a4 4 0 115.656 5.656L10 16.657 3.172 9.83a4 4 0 010-5.657z" />
                        </svg>
                    </button>
                    @if($errors->has('password_confirmation'))
                        <p class="mt-2 text-sm text-rose-600">{{ $errors->first('password_confirmation') }}</p>
                    @endif
                </div>
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-primary to-secondary hover:from-secondary hover:to-primary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all duration-300">
                    Reset Password
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        function attachToggle(buttonId, openId, closedId, targetId) {
                            var btn = document.getElementById(buttonId);
                            var input = document.getElementById(targetId);
                            if (!btn || !input) return;
                            var open = document.getElementById(openId);
                            var closed = document.getElementById(closedId);
                            btn.addEventListener('click', function () {
                                if (input.type === 'password') {
                                    input.type = 'text';
                                    if (open) open.classList.add('hidden');
                                    if (closed) closed.classList.remove('hidden');
                                } else {
                                    input.type = 'password';
                                    if (open) open.classList.remove('hidden');
                                    if (closed) closed.classList.add('hidden');
                                }
                            });
                        }
                        attachToggle('toggleResetPassword', 'resetEyeOpen', 'resetEyeClosed', 'password');
                        attachToggle('toggleResetPasswordConfirm', 'resetConfirmEyeOpen', 'resetConfirmEyeClosed', 'password_confirmation');
                    });
                </script>
            @endsection
