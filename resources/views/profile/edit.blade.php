@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="container mx-auto py-8 px-4 max-w-3xl">
    <h1 class="text-2xl font-semibold mb-6">Profil Saya</h1>

    <div class="space-y-6">
        <div class="bg-white shadow-sm rounded p-6">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="bg-white shadow-sm rounded p-6">
            @include('profile.partials.update-password-form')
        </div>

        <div class="bg-white shadow-sm rounded p-6">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>
@endsection
