<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Jathayu Airlines</title>
    
    <!-- Tailwind CSS + Alpine.js -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js untuk dropdown -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3674B5',
                        secondary: '#578FCA',
                        accent: '#A1E3F9',
                        light: '#D1F8EF',
                        dark: '#2C3E50',
                    },
                    fontFamily: {
                        'poppins': ['Poppins', 'sans-serif'],
                    },
                    animation: {
                        'float': 'float 3s ease-in-out infinite',
                        'bounce-slow': 'bounce 2s infinite',
                    }
                }
            }
        }
    </script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
            
        /* Enable smooth scrolling for the whole website */
        html {
            scroll-behavior: smooth !important;
        }
        
        /* Override any other scroll behaviors */
        * {
            scroll-behavior: smooth !important;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #3674B5;
            border-radius: 5px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #578FCA;
        }
        
        /* Float animation */
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gradient-to-b from-gray-50 to-white min-h-screen flex flex-col font-poppins">
    
    <!-- Include Navbar -->
    @include('components.navbar')
    
   <!-- Main Content -->
<main class="flex-grow">
    @yield('content')
</main>

<!-- Footer -->
@include('components.footer-tailwind')

<!-- Scroll to Top Button -->
@include('components.scroll-top')

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // CSRF setup
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    // SweetAlert2
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    });
    
    @if(session('success'))
        Toast.fire({
            icon: 'success',
            title: '{{ session('success') }}'
        });
    @endif
    
    @if(session('error'))
        Toast.fire({
            icon: 'error',
            title: '{{ session('error') }}'
        });
    @endif
</script>

@stack('scripts')
</body>
</html>