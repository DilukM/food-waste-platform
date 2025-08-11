<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $donation->title }} - FoodShare</title>

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
                        @if (Auth::user() && Auth::user()->canDonate() && !Auth::user()->canReceive() && request()->get('from') !== 'recipient')
                            <!-- Donor view navbar - matches create donation page -->
                            <a href="{{ route('donations.manage') }}"
                                class="text-gray-900 hover:text-green-700 px-3 py-2 rounded-md text-sm font-medium transition-colors">Manage
                                Donations</a>
                        @else
                            <!-- Recipient view navbar -->
                            <a href="{{ url('/') }}"
                                class="text-gray-900 hover:text-green-700 px-3 py-2 rounded-md text-sm font-medium transition-colors">Home</a>
                            <a href="{{ route('donations.index') }}"
                                class="text-gray-900 hover:text-green-700 px-3 py-2 rounded-md text-sm font-medium transition-colors">Browse
                                Donations</a>
                        @endif
                    </div>
                </div>

                <!-- Auth Links -->
                <div class="flex items-center space-x-4">
                    @auth
                        @if (Auth::user()->canDonate() && !Auth::user()->canReceive() && request()->get('from') === 'recipient')
                            <!-- Only show Go Back button if they came from recipient view -->
                            <a href="{{ route('donations.index') }}"
                                class="glass-card hover:bg-white hover:bg-opacity-80 text-blue-600 hover:text-blue-700 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 backdrop-blur-md border border-white border-opacity-30 shadow-lg">
                                ← Go Back to Recipient View
                            </a>
                        @elseif (Auth::user()->canReceive() && !Auth::user()->canDonate())
                            <!-- Recipient-only navigation -->
                            <a href="{{ route('my-requests') }}"
                                class="text-gray-900 hover:text-green-700 px-3 py-2 rounded-md text-sm font-medium transition-colors">My
                                Requests</a>
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



            <!-- Success/Error Messages -->
            @if (session('status'))
                <div class="mb-6 glass-card rounded-xl p-4 border-l-4 border-green-500">
                    <div class="flex items-center">
                        <span class="text-2xl mr-3">✅</span>
                        <p class="text-green-800 font-medium">{{ session('status') }}</p>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 glass-card rounded-xl p-4 border-l-4 border-red-500">
                    <div class="flex items-center">
                        <span class="text-2xl mr-3">❌</span>
                        <p class="text-red-800 font-medium">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <!-- Main Content -->
            <div class="glass-card rounded-xl shadow-xl p-8">
                <!-- Header Section -->
                <div class="mb-8">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2 sm:mb-0">{{ $donation->title }}
                        </h1>
                        <span
                            class="inline-flex items-center px-3 py-1 text-sm font-semibold rounded-full
                            {{ $donation->status === 'available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst($donation->status) }}
                        </span>
                    </div>

                    <div class="inline-block px-4 py-2 text-sm font-semibold text-green-700 bg-green-100 rounded-full">
                        📦 {{ $donation->category }}
                    </div>
                </div>

                <!-- Details Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                    <!-- Main Description -->
                    <div class="lg:col-span-2">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Description</h3>
                        <p class="text-gray-700 text-lg leading-relaxed">{{ $donation->description }}</p>
                    </div>

                    <!-- Details Sidebar -->
                    <div class="glass-card rounded-lg p-6 bg-gray-50 bg-opacity-50">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Donation Details</h4>
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <span class="text-2xl mr-3">📊</span>
                                <div>
                                    <p class="text-sm text-gray-600">Quantity</p>
                                    <p class="font-semibold text-gray-900">{{ $donation->quantity }}</p>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <span class="text-2xl mr-3">⏰</span>
                                <div>
                                    <p class="text-sm text-gray-600">Expires On</p>
                                    <p class="font-semibold text-gray-900">
                                        {{ $donation->expires_at->format('M j, Y \a\t g:i A') }}</p>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <span class="text-2xl mr-3">👤</span>
                                <div>
                                    <p class="text-sm text-gray-600">Posted By</p>
                                    <p class="font-semibold text-gray-900">
                                        {{ $donation->user ? $donation->user->name : 'Anonymous' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Section -->
                @auth
                    @if (auth()->user()->id !== $donation->user_id && $donation->status === 'available')
                        @if (auth()->user()->canReceive())
                            <div class="glass-card rounded-xl p-6 bg-blue-50 bg-opacity-50">
                                <h4 class="text-xl font-semibold text-gray-900 mb-4">🤝 Request this Donation</h4>
                                <form method="POST" action="{{ route('donations.request', $donation) }}"
                                    class="space-y-4">
                                    @csrf
                                    <div>
                                        <label for="message" class="block text-gray-700 font-medium mb-2">Message
                                            (Optional)
                                        </label>
                                        <textarea id="message" name="message" rows="4"
                                            class="block w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500 transition-colors"
                                            placeholder="Tell the donor why you need this donation or how you plan to use it..."></textarea>
                                    </div>
                                    <button type="submit"
                                        class="w-full bg-green-600 hover:bg-green-700 text-white px-6 py-4 rounded-lg font-semibold text-lg transition-all hover-scale shadow-lg">
                                        📤 Submit Request
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="glass-card rounded-xl p-6 bg-orange-50 bg-opacity-50 border-l-4 border-orange-500">
                                <div class="flex items-center">
                                    <span class="text-3xl mr-4">⚠️</span>
                                    <div>
                                        <h4 class="text-lg font-semibold text-orange-800">Recipient Role Required</h4>
                                        <p class="text-orange-700">Only users with recipient role can request donations.
                                            Please update your profile role.</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @elseif(auth()->user()->id === $donation->user_id)
                        <div class="glass-card rounded-xl p-6 bg-yellow-50 bg-opacity-50 border-l-4 border-yellow-500">
                            <div class="flex items-center">
                                <span class="text-3xl mr-4">👑</span>
                                <div>
                                    <h4 class="text-lg font-semibold text-yellow-800">Your Donation</h4>
                                    <p class="text-yellow-700">This is your own donation. You cannot request it, but you
                                        can
                                        manage it from your dashboard.</p>
                                </div>
                            </div>
                        </div>
                    @elseif($donation->status !== 'available')
                        <div class="glass-card rounded-xl p-6 bg-red-50 bg-opacity-50 border-l-4 border-red-500">
                            <div class="flex items-center">
                                <span class="text-3xl mr-4">❌</span>
                                <div>
                                    <h4 class="text-lg font-semibold text-red-800">No Longer Available</h4>
                                    <p class="text-red-700">This donation is no longer available for requests.</p>
                                </div>
                            </div>
                        </div>
                    @endif
                @else
                    @if ($donation->status === 'available')
                        <div class="glass-card rounded-xl p-6 bg-blue-50 bg-opacity-50 border-l-4 border-blue-500">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <span class="text-3xl mr-4">🔐</span>
                                    <div>
                                        <h4 class="text-lg font-semibold text-blue-800">Login Required</h4>
                                        <p class="text-blue-700">Please log in or register to request this donation.</p>
                                    </div>
                                </div>
                                <div class="flex gap-3">
                                    <a href="{{ route('login') }}"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                        Login
                                    </a>
                                    <a href="{{ route('register') }}"
                                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                        Register
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="glass-card rounded-xl p-6 bg-red-50 bg-opacity-50 border-l-4 border-red-500">
                            <div class="flex items-center">
                                <span class="text-3xl mr-4">❌</span>
                                <div>
                                    <h4 class="text-lg font-semibold text-red-800">No Longer Available</h4>
                                    <p class="text-red-700">This donation is no longer available for requests.</p>
                                </div>
                            </div>
                        </div>
                    @endif
                @endauth
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
</body>

</html>
