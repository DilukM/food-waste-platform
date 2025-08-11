<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FoodShare - Reduce Food Waste, Share Abundance</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #0f766e 0%, #10b981 25%, #059669 50%, #047857 75%, #064e3b 100%);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            position: relative;
        }

        @keyframes gradientShift {

            0%,
            100% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }
        }

        /* Particle effect overlay */
        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            display: block;
            width: 4px;
            height: 4px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            animation: particleFloat 10s infinite linear;
        }

        @keyframes particleFloat {
            0% {
                opacity: 0;
                transform: translateY(100vh) scale(0);
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                opacity: 0;
                transform: translateY(-100px) scale(1);
            }
        }

        .glass {
            background: rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .glass-button {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.8);
            color: #047857;
        }

        .glass-button:hover {
            background: rgba(255, 255, 255, 1);
            border-color: rgba(255, 255, 255, 1);
        }

        .floating {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .floating-delayed {
            animation: float 6s ease-in-out infinite;
            animation-delay: -2s;
        }

        .floating-delayed-2 {
            animation: float 6s ease-in-out infinite;
            animation-delay: -4s;
        }

        .pulse-slow {
            animation: pulse-slow 4s ease-in-out infinite;
        }

        @keyframes pulse-slow {
            0%, 100% {
                opacity: 0.3;
                transform: scale(1);
            }
            50% {
                opacity: 0.8;
                transform: scale(1.1);
            }
        }

        .bounce-slow {
            animation: bounce-slow 3s ease-in-out infinite;
        }

        @keyframes bounce-slow {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
            }
            50% {
                transform: translateY(-15px) rotate(5deg);
            }
        }

        .rotate-slow {
            animation: rotate-slow 20s linear infinite;
        }

        @keyframes rotate-slow {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        .slide-diagonal {
            animation: slide-diagonal 15s ease-in-out infinite;
        }

        @keyframes slide-diagonal {
            0%, 100% {
                transform: translate(0, 0);
            }
            50% {
                transform: translate(30px, -30px);
            }
        }

        .food-icon {
            font-size: 2rem;
            opacity: 0.7;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .food-icon:hover {
            opacity: 1;
            filter: drop-shadow(0 0 20px rgba(255, 255, 255, 0.5));
        }

        /* Wave animation for hero background */
        .wave {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.03), transparent);
            animation: wave 8s ease-in-out infinite;
        }

        @keyframes wave {
            0%, 100% {
                transform: translateX(-100%);
            }
            50% {
                transform: translateX(100%);
            }
        }

        /* Breathing animation for main title */
        .breathe {
            animation: breathe 4s ease-in-out infinite;
        }

        @keyframes breathe {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.02);
            }
        }

        /* Glow effect for stats cards */
        .glow-on-hover {
            transition: all 0.3s ease;
        }

        .glow-on-hover:hover {
            box-shadow: 0 0 30px rgba(255, 255, 255, 0.3);
            transform: translateY(-5px) scale(1.05);
        }

        /* Twinkling stars effect */
        .twinkle {
            animation: twinkle 2s ease-in-out infinite alternate;
        }

        @keyframes twinkle {
            from {
                opacity: 0.3;
            }
            to {
                opacity: 1;
            }
        }

        /* Circular lines animations */
        .circular-line {
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.1);
            position: absolute;
            animation: spin-slow 20s linear infinite;
        }

        .circular-line-reverse {
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, 0.08);
            position: absolute;
            animation: spin-reverse 15s linear infinite;
        }

        .circular-line-pulse {
            border-radius: 50%;
            border: 3px solid rgba(255, 255, 255, 0.06);
            position: absolute;
            animation: circular-pulse 8s ease-in-out infinite;
        }

        @keyframes spin-slow {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes spin-reverse {
            from {
                transform: rotate(360deg);
            }
            to {
                transform: rotate(0deg);
            }
        }

        @keyframes circular-pulse {
            0%, 100% {
                transform: scale(1);
                opacity: 0.1;
            }
            50% {
                transform: scale(1.1);
                opacity: 0.3;
            }
        }

        /* Dashed circular lines */
        .circular-dashed {
            border-radius: 50%;
            border: 2px dashed rgba(255, 255, 255, 0.12);
            position: absolute;
            animation: dash-rotate 12s linear infinite;
        }

        @keyframes dash-rotate {
            from {
                transform: rotate(0deg);
                stroke-dashoffset: 0;
            }
            to {
                transform: rotate(360deg);
                stroke-dashoffset: 100;
            }
        }

        /* Gradient circular lines */
        .circular-gradient {
            border-radius: 50%;
            position: absolute;
            background: conic-gradient(from 0deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            animation: gradient-spin 10s linear infinite;
        }

        .circular-gradient::before {
            content: '';
            position: absolute;
            inset: 2px;
            border-radius: 50%;
            background: linear-gradient(135deg, #0f766e 0%, #10b981 25%, #059669 50%, #047857 75%, #064e3b 100%);
        }

        @keyframes gradient-spin {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        .hover-scale:hover {
            transform: scale(1.05);
        }

        .hero-pattern {
            background-image: radial-gradient(circle at 1px 1px, rgba(255, 255, 255, 0.15) 1px, transparent 0);
            background-size: 20px 20px;
        }
    </style>
</head>

<body class="antialiased overflow-x-hidden">
    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 glass">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <img src="{{ asset('logo.svg') }}" alt="FoodShare Logo" class="h-8 w-auto">
                    </div>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="{{ url('/') }}"
                            class="text-gray-900 hover:text-green-700 px-3 py-2 rounded-md text-sm font-medium transition-colors">Home</a>
                        <a href="{{ route('donations.index') }}"
                            class="text-gray-900 hover:text-green-700 px-3 py-2 rounded-md text-sm font-medium transition-colors">Browse
                            Donations</a>
                        <a href="{{ route('my-requests') }}"
                            class="text-gray-900 hover:text-green-700 px-3 py-2 rounded-md text-sm font-medium transition-colors">My
                            Requests</a>
                    </div>
                </div>

                <!-- Auth Links -->
                <div class="flex items-center space-x-4">
                    @auth
                        @if (Auth::user()->canDonate() && !Auth::user()->canReceive())
                            <!-- Pure Donor Navigation - Only show View as Recipient button -->
                            <a href="{{ route('donations.index') }}"
                                class="glass-card hover:bg-white hover:bg-opacity-80 text-blue-600 hover:text-blue-700 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 backdrop-blur-md border border-white border-opacity-30 shadow-lg inline-flex items-center">
                                
                                View as Recipient
                            </a>
                        @endif

                        <!-- Profile Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" @click.away="open = false"
                                class="flex items-center space-x-2 bg-white text-green-600 hover:bg-green-50 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                <span>👤</span>
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </button>

                            <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
                                <div class="py-1">
                                    <a href="{{ route('profile.edit') }}"
                                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-600 transition-colors">
                                        <span class="mr-3">✏️</span>
                                        Edit Profile
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors">
                                            <span class="mr-3">🚪</span>
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-white hover:text-green-200 px-3 py-2 rounded-md text-sm font-medium transition-colors">Login</a>
                        <a href="{{ route('register') }}"
                            class="bg-white text-green-600 hover:bg-green-50 px-4 py-2 rounded-lg text-sm font-medium transition-colors">Get
                            Started</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center gradient-bg hero-pattern">
        <!-- Wave Effect -->
        <div class="wave"></div>
        
        <!-- Particle Effect -->
        <div class="particles" id="particles"></div>

        <!-- Gradient Overlay -->
        {{-- <div class="absolute inset-0 bg-gradient-to-br from-transparent via-green-900/20 to-emerald-900/40"></div> --}}

        <!-- Background decorations -->
        <div class="absolute inset-0 overflow-hidden">
            <!-- Animated gradient circles -->
            <div
                class="absolute top-1/4 left-10 w-72 h-72 bg-white opacity-5 rounded-full mix-blend-multiply filter blur-xl floating">
            </div>
            <div
                class="absolute top-1/3 right-10 w-72 h-72 bg-green-200 opacity-10 rounded-full mix-blend-multiply filter blur-xl floating-delayed">
            </div>
            <div
                class="absolute bottom-1/4 left-1/3 w-48 h-48 bg-emerald-300 opacity-8 rounded-full mix-blend-multiply filter blur-xl floating-delayed-2">
            </div>

            <!-- Floating food icons -->
            <div class="absolute top-20 left-20 food-icon bounce-slow">🍎</div>
            <div class="absolute top-32 right-32 food-icon floating-delayed">🥖</div>
            <div class="absolute bottom-40 left-16 food-icon slide-diagonal">🥬</div>
            <div class="absolute top-1/2 right-20 food-icon floating">🍌</div>
            <div class="absolute bottom-20 right-1/4 food-icon bounce-slow">🥕</div>
            <div class="absolute top-40 left-1/2 food-icon floating-delayed-2">🍅</div>
            <div class="absolute bottom-1/3 left-1/4 food-icon slide-diagonal">🥔</div>
            <div class="absolute top-1/3 left-1/3 food-icon floating-delayed">🍊</div>

            <!-- Animated circles with different sizes -->
            <div class="absolute top-16 right-16 w-8 h-8 bg-green-400 opacity-20 rounded-full pulse-slow"></div>
            <div class="absolute bottom-32 left-32 w-12 h-12 bg-emerald-300 opacity-15 rounded-full pulse-slow" style="animation-delay: -1s;"></div>
            <div class="absolute top-1/2 left-16 w-6 h-6 bg-green-500 opacity-25 rounded-full pulse-slow" style="animation-delay: -2s;"></div>
            <div class="absolute bottom-16 right-40 w-10 h-10 bg-teal-400 opacity-20 rounded-full pulse-slow" style="animation-delay: -3s;"></div>

            <!-- Rotating decorative elements -->
            <div class="absolute top-24 right-1/4 w-16 h-16 border-2 border-green-300 opacity-20 rounded-full rotate-slow"></div>
            <div class="absolute bottom-24 left-1/3 w-20 h-20 border border-emerald-400 opacity-15 rounded-full rotate-slow" style="animation-delay: -10s; animation-direction: reverse;"></div>

            <!-- Additional geometric shapes -->
            <div class="absolute top-1/4 right-1/3 w-4 h-4 bg-green-400 opacity-30 transform rotate-45 floating"></div>
            <div class="absolute bottom-1/4 right-1/4 w-3 h-3 bg-emerald-500 opacity-25 transform rotate-45 floating-delayed"></div>
            <div class="absolute top-2/3 left-20 w-5 h-5 bg-teal-400 opacity-20 transform rotate-45 floating-delayed-2"></div>

            <!-- Twinkling stars -->
            <div class="absolute top-12 left-1/4 w-2 h-2 bg-white opacity-60 rounded-full twinkle"></div>
            <div class="absolute top-24 right-1/3 w-1 h-1 bg-white opacity-80 rounded-full twinkle" style="animation-delay: 0.5s;"></div>
            <div class="absolute bottom-32 left-1/2 w-1.5 h-1.5 bg-white opacity-70 rounded-full twinkle" style="animation-delay: 1s;"></div>
            <div class="absolute top-1/2 right-12 w-2 h-2 bg-white opacity-50 rounded-full twinkle" style="animation-delay: 1.5s;"></div>
            <div class="absolute bottom-16 left-12 w-1 h-1 bg-white opacity-90 rounded-full twinkle" style="animation-delay: 2s;"></div>

            <!-- Subtle Circular Lines (reduced) -->
            <div class="circular-line top-20 left-20 w-64 h-64"></div>
            <div class="circular-line-reverse bottom-20 right-20 w-48 h-48" style="animation-delay: -10s;"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold text-black mb-6 leading-tight breathe">
                    Reduce Food Waste,<br>
                    <span class="text-green-700">Share Abundance</span>
                </h1>
                <p class="text-xl md:text-2xl text-black mb-8 max-w-3xl mx-auto font-medium">
                    Connect food donors with those in need. Transform surplus into sustenance and build a more
                    sustainable community together.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center mb-12">
                    <a href="{{ route('donations.index') }}"
                        class="bg-white text-green-700 hover:bg-gray-100 px-8 py-4 rounded-lg text-lg font-bold transition-all hover-scale shadow-xl border-2 border-white">
                        🍎 Browse Available Food
                    </a>
                    @guest
                        <a href="{{ route('register') }}"
                            class="glass-button px-8 py-4 rounded-lg text-lg font-bold transition-all hover-scale shadow-xl">
                            ✨ Join the Movement
                        </a>
                    @else
                        @if (Auth::user()->canDonate())
                            <a href="{{ route('donations.create') }}"
                                class="glass-button px-8 py-4 rounded-lg text-lg font-bold transition-all hover-scale shadow-xl">
                                📦 Donate Food
                            </a>
                        @else
                            <a href="{{ route('donations.index') }}"
                                class="glass-button px-8 py-4 rounded-lg text-lg font-bold transition-all hover-scale shadow-xl">
                                🔍 Find Food Near You
                            </a>
                        @endif
                    @endguest
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto">
                    <div
                        class="bg-gradient-to-br from-green-500 to-green-700 backdrop-blur-md rounded-xl p-6 text-center hover-scale transition-transform duration-300 border border-white border-opacity-30 shadow-lg glow-on-hover">
                        <div class="text-3xl font-bold text-white mb-2">40%</div>
                        <div class="text-white">of food is wasted globally</div>
                    </div>
                    <div
                        class="bg-gradient-to-br from-green-600 to-green-800 backdrop-blur-md rounded-xl p-6 text-center hover-scale transition-transform duration-300 border border-white border-opacity-30 shadow-lg glow-on-hover">
                        <div class="text-3xl font-bold text-white mb-2">828M</div>
                        <div class="text-white">people face hunger worldwide</div>
                    </div>
                    <div
                        class="bg-gradient-to-br from-green-500 to-emerald-700 backdrop-blur-md rounded-xl p-6 text-center hover-scale transition-transform duration-300 border border-white border-opacity-30 shadow-lg glow-on-hover">
                        <div class="text-3xl font-bold text-white mb-2">Together</div>
                        <div class="text-white">we can make a difference</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">How FoodShare Works</h2>
                <p class="text-xl text-gray-700 max-w-3xl mx-auto">Simple, effective, and impactful. Join thousands of
                    donors and recipients creating a more sustainable food system.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div
                    class="bg-white rounded-xl p-8 shadow-xl hover-scale transition-transform duration-300 border border-gray-200">
                    <div class="w-16 h-16 bg-green-600 rounded-lg flex items-center justify-center mb-6">
                        <span class="text-2xl">📱</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Easy Listing</h3>
                    <p class="text-gray-700">Post your surplus food with photos, descriptions, and pickup details in
                        just a few clicks.</p>
                </div>

                <!-- Feature 2 -->
                <div
                    class="bg-white rounded-xl p-8 shadow-xl hover-scale transition-transform duration-300 border border-gray-200">
                    <div class="w-16 h-16 bg-green-600 rounded-lg flex items-center justify-center mb-6">
                        <span class="text-2xl">🔍</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Smart Discovery</h3>
                    <p class="text-gray-700">Find available food near you with our location-based search and real-time
                        updates.</p>
                </div>

                <!-- Feature 3 -->
                <div
                    class="bg-white rounded-xl p-8 shadow-xl hover-scale transition-transform duration-300 border border-gray-200">
                    <div class="w-16 h-16 bg-green-600 rounded-lg flex items-center justify-center mb-6">
                        <span class="text-2xl">🤝</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Direct Connection</h3>
                    <p class="text-gray-700">Connect directly with donors and recipients to coordinate pickups and
                        build
                        community.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gray-900">
        <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">Ready to Make a Difference?</h2>
            <p class="text-xl text-gray-300 mb-8">Join our community of food heroes and help create a world with less
                waste and more sharing.</p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @guest
                    <a href="{{ route('register') }}"
                        class="bg-green-600 hover:bg-green-700 text-white px-8 py-4 rounded-lg text-lg font-semibold transition-all hover-scale shadow-lg border-2 border-green-500">
                        🚀 Start Sharing Today
                    </a>
                    <a href="{{ route('donations.index') }}"
                        class="bg-white border-2 border-white text-gray-900 hover:bg-gray-100 px-8 py-4 rounded-lg text-lg font-semibold transition-all hover-scale shadow-lg">
                        👀 Browse Without Signing Up
                    </a>
                @else
                    @if (Auth::user()->canDonate())
                        <a href="{{ route('donations.create') }}"
                            class="bg-green-600 hover:bg-green-700 text-white px-8 py-4 rounded-lg text-lg font-semibold transition-all hover-scale shadow-lg border-2 border-green-500">
                            📦 Donate Food Now
                        </a>
                    @endif
                    <a href="{{ route('donations.index') }}"
                        class="bg-white border-2 border-white text-gray-900 hover:bg-gray-100 px-8 py-4 rounded-lg text-lg font-semibold transition-all hover-scale shadow-lg">
                        🔍 Find Food Near You
                    </a>
                @endguest
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="col-span-1 md:col-span-2">
                    <h3 class="text-lg font-semibold text-white mb-4">🌱 FoodShare</h3>
                    <p class="text-gray-300 mb-4">Connecting communities to reduce food waste and share abundance.
                        Every
                        meal shared is a step towards a more sustainable future.</p>
                </div>

                <div>
                    <h4 class="text-white font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('donations.index') }}"
                                class="text-gray-300 hover:text-white transition-colors">Browse Donations</a></li>
                        @guest
                            <li><a href="{{ route('register') }}"
                                    class="text-gray-300 hover:text-white transition-colors">Sign Up</a></li>
                            <li><a href="{{ route('login') }}"
                                    class="text-gray-300 hover:text-white transition-colors">Login</a></li>
                        @else
                            @if (Auth::user()->canDonate())
                                <li><a href="{{ route('donations.create') }}"
                                        class="text-gray-300 hover:text-white transition-colors">Donate Food</a></li>
                            @endif
                        @endguest
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-700 pt-8 mt-8 text-center">
                <p class="text-gray-300">&copy; {{ date('Y') }} FoodShare. Built with ❤️ for a sustainable future.
                </p>
            </div>
        </div>
    </footer>

    <script>
        // Particle System
        function createParticles() {
            const particlesContainer = document.getElementById('particles');
            const particleCount = 50;

            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');
                
                // Random horizontal position
                particle.style.left = Math.random() * 100 + '%';
                
                // Random animation delay
                particle.style.animationDelay = Math.random() * 10 + 's';
                
                // Random animation duration
                particle.style.animationDuration = (Math.random() * 10 + 10) + 's';
                
                // Random size
                const size = Math.random() * 3 + 2;
                particle.style.width = size + 'px';
                particle.style.height = size + 'px';
                
                particlesContainer.appendChild(particle);
            }
        }

        // Floating food icons interaction
        function addFoodIconInteraction() {
            const foodIcons = document.querySelectorAll('.food-icon');
            
            foodIcons.forEach(icon => {
                icon.addEventListener('mouseenter', () => {
                    icon.style.transform = 'scale(1.5) rotate(15deg)';
                    icon.style.transition = 'transform 0.3s ease';
                });
                
                icon.addEventListener('mouseleave', () => {
                    icon.style.transform = 'scale(1) rotate(0deg)';
                });
            });
        }

        // Parallax effect for background elements
        function addParallaxEffect() {
            window.addEventListener('scroll', () => {
                const scrolled = window.pageYOffset;
                const parallaxElements = document.querySelectorAll('.floating, .floating-delayed, .floating-delayed-2');
                
                parallaxElements.forEach((element, index) => {
                    const speed = 0.5 + (index * 0.1);
                    element.style.transform = `translateY(${scrolled * speed}px)`;
                });
            });
        }

        // Random color animation for geometric shapes
        function animateGeometricShapes() {
            const shapes = document.querySelectorAll('[class*="transform rotate-45"]');
            const colors = ['bg-green-400', 'bg-emerald-500', 'bg-teal-400', 'bg-green-500', 'bg-emerald-400'];
            
            setInterval(() => {
                shapes.forEach(shape => {
                    const randomColor = colors[Math.floor(Math.random() * colors.length)];
                    shape.className = shape.className.replace(/bg-\w+-\d+/, randomColor);
                });
            }, 3000);
        }

        // Interactive circular lines (simplified)
        function addCircularLinesInteraction() {
            const circularLines = document.querySelectorAll('.circular-line, .circular-line-reverse');
            
            // Simple opacity animation for circular lines
            setInterval(() => {
                circularLines.forEach(line => {
                    const randomOpacity = Math.random() * 0.15 + 0.05;
                    line.style.borderColor = `rgba(255, 255, 255, ${randomOpacity})`;
                });
            }, 4000);
        }

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Initialize all animations when page loads
        document.addEventListener('DOMContentLoaded', () => {
            createParticles();
            addFoodIconInteraction();
            addParallaxEffect();
            animateGeometricShapes();
            addCircularLinesInteraction();
        });
    </script>
</body>

</html>
