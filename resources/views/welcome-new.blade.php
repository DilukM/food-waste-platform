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

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #10b981 0%, #059669 50%, #047857 100%);
        }

        .glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
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
                        <a href="#features"
                            class="text-white hover:text-green-200 px-3 py-2 rounded-md text-sm font-medium transition-colors">Features</a>
                        <a href="{{ route('donations.index') }}"
                            class="text-white hover:text-green-200 px-3 py-2 rounded-md text-sm font-medium transition-colors">Browse
                            Donations</a>
                    </div>
                </div>

                <!-- Auth Links -->
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="bg-white text-green-600 hover:bg-green-50 px-4 py-2 rounded-lg text-sm font-medium transition-colors">Dashboard</a>
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
        <!-- Background decorations -->
        <div class="absolute inset-0 overflow-hidden">
            <div
                class="absolute top-1/4 left-10 w-72 h-72 bg-white opacity-5 rounded-full mix-blend-multiply filter blur-xl floating">
            </div>
            <div
                class="absolute top-1/3 right-10 w-72 h-72 bg-green-200 opacity-10 rounded-full mix-blend-multiply filter blur-xl floating">
            </div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold text-white mb-6 leading-tight">
                    Reduce Food Waste,<br>
                    <span class="text-green-200">Share Abundance</span>
                </h1>
                <p class="text-xl md:text-2xl text-green-100 mb-8 max-w-3xl mx-auto">
                    Connect food donors with those in need. Transform surplus into sustenance and build a more
                    sustainable community together.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center mb-12">
                    <a href="{{ route('donations.index') }}"
                        class="bg-white text-green-600 hover:bg-green-50 px-8 py-4 rounded-lg text-lg font-semibold transition-all hover-scale shadow-lg">
                        🍎 Browse Available Food
                    </a>
                    @guest
                        <a href="{{ route('register') }}"
                            class="glass text-white hover:bg-white hover:bg-opacity-20 px-8 py-4 rounded-lg text-lg font-semibold transition-all hover-scale">
                            ✨ Join the Movement
                        </a>
                    @else
                        <a href="{{ route('donations.create') }}"
                            class="glass text-white hover:bg-white hover:bg-opacity-20 px-8 py-4 rounded-lg text-lg font-semibold transition-all hover-scale">
                            📦 Donate Food
                        </a>
                    @endguest
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto">
                    <div class="glass rounded-xl p-6 text-center hover-scale transition-transform duration-300">
                        <div class="text-3xl font-bold text-white mb-2">40%</div>
                        <div class="text-green-200">of food is wasted globally</div>
                    </div>
                    <div class="glass rounded-xl p-6 text-center hover-scale transition-transform duration-300">
                        <div class="text-3xl font-bold text-white mb-2">828M</div>
                        <div class="text-green-200">people face hunger worldwide</div>
                    </div>
                    <div class="glass rounded-xl p-6 text-center hover-scale transition-transform duration-300">
                        <div class="text-3xl font-bold text-white mb-2">Together</div>
                        <div class="text-green-200">we can make a difference</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">How FoodShare Works</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Simple, effective, and impactful. Join thousands of
                    donors and recipients creating a more sustainable food system.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white rounded-xl p-8 shadow-lg hover-scale transition-transform duration-300">
                    <div class="w-16 h-16 bg-green-100 rounded-lg flex items-center justify-center mb-6">
                        <span class="text-2xl">📱</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Easy Listing</h3>
                    <p class="text-gray-600">Post your surplus food with photos, descriptions, and pickup details in
                        just a few clicks.</p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white rounded-xl p-8 shadow-lg hover-scale transition-transform duration-300">
                    <div class="w-16 h-16 bg-green-100 rounded-lg flex items-center justify-center mb-6">
                        <span class="text-2xl">🔍</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Smart Discovery</h3>
                    <p class="text-gray-600">Find available food near you with our location-based search and real-time
                        updates.</p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white rounded-xl p-8 shadow-lg hover-scale transition-transform duration-300">
                    <div class="w-16 h-16 bg-green-100 rounded-lg flex items-center justify-center mb-6">
                        <span class="text-2xl">🤝</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Direct Connection</h3>
                    <p class="text-gray-600">Connect directly with donors and recipients to coordinate pickups and build
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
                        class="bg-green-600 hover:bg-green-700 text-white px-8 py-4 rounded-lg text-lg font-semibold transition-all hover-scale shadow-lg">
                        🚀 Start Sharing Today
                    </a>
                    <a href="{{ route('donations.index') }}"
                        class="border border-gray-600 text-white hover:bg-gray-800 px-8 py-4 rounded-lg text-lg font-semibold transition-all hover-scale">
                        👀 Browse Without Signing Up
                    </a>
                @else
                    <a href="{{ route('donations.create') }}"
                        class="bg-green-600 hover:bg-green-700 text-white px-8 py-4 rounded-lg text-lg font-semibold transition-all hover-scale shadow-lg">
                        📦 Donate Food Now
                    </a>
                    <a href="{{ route('donations.index') }}"
                        class="border border-gray-600 text-white hover:bg-gray-800 px-8 py-4 rounded-lg text-lg font-semibold transition-all hover-scale">
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
                    <p class="text-gray-400 mb-4">Connecting communities to reduce food waste and share abundance. Every
                        meal shared is a step towards a more sustainable future.</p>
                </div>

                <div>
                    <h4 class="text-white font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('donations.index') }}"
                                class="text-gray-400 hover:text-white transition-colors">Browse Donations</a></li>
                        @guest
                            <li><a href="{{ route('register') }}"
                                    class="text-gray-400 hover:text-white transition-colors">Sign Up</a></li>
                            <li><a href="{{ route('login') }}"
                                    class="text-gray-400 hover:text-white transition-colors">Login</a></li>
                        @else
                            <li><a href="{{ route('dashboard') }}"
                                    class="text-gray-400 hover:text-white transition-colors">Dashboard</a></li>
                            <li><a href="{{ route('donations.create') }}"
                                    class="text-gray-400 hover:text-white transition-colors">Donate Food</a></li>
                        @endguest
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-700 pt-8 mt-8 text-center">
                <p class="text-gray-400">&copy; {{ date('Y') }} FoodShare. Built with ❤️ for a sustainable future.
                </p>
            </div>
        </div>
    </footer>

    <script>
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
    </script>
</body>

</html>
