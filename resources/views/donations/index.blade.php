<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Available Donations - FoodShare</title>

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

        .glass {
            background: rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.8);
        }

        .hover-scale:hover {
            transform: scale(1.02);
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
                        <a href="{{ url('/') }}" class="flex items-center">
                            <img src="{{ asset('logo.png') }}" alt="FoodShare Logo" class="h-8 w-auto">
                        </a>
                    </div>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="{{ url('/') }}"
                            class="text-gray-900 hover:text-green-700 px-3 py-2 rounded-md text-sm font-medium transition-colors">Home</a>
                        <a href="{{ route('donations.index') }}"
                            class="text-green-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium transition-colors">Browse
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
                            <!-- Pure Donor Navigation - Only show Go Back button -->
                            <a href="{{ route('donations.manage') }}"
                                class="glass-card hover:bg-white hover:bg-opacity-80 text-green-600 hover:text-blue-700 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 backdrop-blur-md border border-white border-opacity-30 shadow-lg">
                                Go Back to Donor View
                            </a>
                            {{-- @else
                            <!-- Regular Navigation for Recipients and Both -->
                            @if (Auth::user()->canReceive())
                                <a href="{{ route('my-requests') }}"
                                    class="text-gray-900 hover:text-green-700 px-3 py-2 rounded-md text-sm font-medium transition-colors">My
                                    Requests</a>
                            @endif --}}
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
                            class="text-gray-900 hover:text-green-700 px-3 py-2 rounded-md text-sm font-medium transition-colors">Login</a>
                        <a href="{{ route('register') }}"
                            class="bg-white text-green-600 hover:bg-green-50 px-4 py-2 rounded-lg text-sm font-medium transition-colors">Get
                            Started</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative min-h-screen gradient-bg hero-pattern">
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-12">
            <!-- Header -->
            <div class="text-center mb-12 pt-8">
                <h1 class="text-4xl md:text-5xl font-bold text-black mb-4 drop-shadow-lg">
                    Available Donations
                </h1>
                <p class="text-xl text-gray-900 max-w-3xl mx-auto drop-shadow-md font-medium">
                    Discover fresh food donations from generous community members. Every meal shared makes a difference!
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center mb-12">
                @auth
                    @if (Auth::user()->canDonate())
                        <a href="{{ route('donations.create') }}"
                            class="bg-white text-green-700 hover:bg-gray-100 px-8 py-4 rounded-lg text-lg font-bold transition-all hover-scale shadow-xl border-2 border-white">
                            📦 Create New Donation
                        </a>
                    @endif
                @else
                    <div class="glass-card rounded-xl p-6 text-center max-w-2xl mx-auto">
                        <p class="text-gray-800 mb-4">
                            <a href="{{ route('login') }}"
                                class="font-bold text-green-600 hover:text-green-700 underline">Log in</a>
                            or
                            <a href="{{ route('register') }}"
                                class="font-bold text-green-600 hover:text-green-700 underline">register</a>
                            to create donations and request food items.
                        </p>
                    </div>
                @endauth
            </div>

            <!-- Donations Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($donations as $donation)
                    <div class="glass-card rounded-xl p-6 shadow-xl hover-scale transition-all duration-300">
                        <div class="mb-4">
                            <span
                                class="inline-block px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">
                                {{ $donation->category }}
                            </span>
                        </div>

                        <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $donation->title }}</h3>

                        <p class="text-gray-700 mb-4 line-clamp-3">{{ Str::limit($donation->description, 120) }}</p>

                        <div class="mb-4">
                            <div class="flex items-center text-sm text-gray-600 mb-2">
                                <span class="mr-2">⏰</span>
                                <span>Expires: {{ $donation->expires_at->format('M j, Y') }}</span>
                            </div>
                        </div>

                        <a href="{{ route('donations.show', ['donation' => $donation, 'from' => 'recipient']) }}"
                            class="w-full bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 text-center block">
                            View Details & Request →
                        </a>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="glass-card rounded-xl p-12 text-center max-w-2xl mx-auto">
                            <div class="text-6xl mb-6">🍽️</div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">No Donations Available</h3>
                            <p class="text-gray-700 mb-6">
                                There are currently no food donations available. Be the first to share and help build
                                our community!
                            </p>
                            @auth
                                @if (Auth::user()->canDonate())
                                    <a href="{{ route('donations.create') }}"
                                        class="bg-green-600 hover:bg-green-700 text-white px-8 py-4 rounded-lg text-lg font-semibold transition-all hover-scale shadow-lg">
                                        📦 Create First Donation
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('register') }}"
                                    class="bg-green-600 hover:bg-green-700 text-white px-8 py-4 rounded-lg text-lg font-semibold transition-all hover-scale shadow-lg">
                                    🚀 Join to Start Sharing
                                </a>
                            @endauth
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="col-span-1 md:col-span-2">
                    <h3 class="text-lg font-semibold text-white mb-4">🌱 FoodShare</h3>
                    <p class="text-gray-300 mb-4">Connecting communities to reduce food waste and share abundance. Every
                        meal shared is a step towards a more sustainable future.</p>
                </div>

                <div>
                    <h4 class="text-white font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ url('/') }}"
                                class="text-gray-300 hover:text-white transition-colors">Home</a></li>
                        <li><a href="{{ route('donations.index') }}"
                                class="text-gray-300 hover:text-white transition-colors">Browse Donations</a></li>
                        @guest
                            <li><a href="{{ route('register') }}"
                                    class="text-gray-300 hover:text-white transition-colors">Sign Up</a></li>
                            <li><a href="{{ route('login') }}"
                                    class="text-gray-300 hover:text-white transition-colors">Login</a></li>
                        @else
                            <li><a href="{{ route('donations.create') }}"
                                    class="text-gray-300 hover:text-white transition-colors">Donate Food</a></li>
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
</body>

</html>
