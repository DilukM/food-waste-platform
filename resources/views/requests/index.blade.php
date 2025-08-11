<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Requests - FoodShare</title>

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
                            class="text-gray-900 hover:text-green-700 px-3 py-2 rounded-md text-sm font-medium transition-colors">Browse
                            Donations</a>
                        <a href="{{ route('my-requests') }}"
                            class="text-gray-900 hover:text-green-700 px-3 py-2 rounded-md text-sm font-medium transition-colors">My
                            Requests</a>
                    </div>
                </div>

                <!-- Auth Links -->
                <div class="flex items-center space-x-4">
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
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
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

            <!-- Header -->
            <div class="glass-card rounded-xl shadow-xl p-8 mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">🙏 My Donation Requests</h1>
                        <p class="text-gray-600">Track the status of your food donation requests</p>
                    </div>
                    <div class="mt-4 sm:mt-0">
                        <a href="{{ route('donations.index') }}"
                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors inline-flex items-center">
                            <span class="mr-2">🔍</span>
                            Browse Donations
                        </a>
                    </div>
                </div>
            </div>

            <!-- Requests List -->
            <div class="glass-card rounded-xl shadow-xl p-8">
                @forelse($requests as $request)
                    <div class="mb-6 p-6 border border-gray-200 rounded-lg bg-gray-50 bg-opacity-50">
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between mb-4">
                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $request->donation->title }}</h3>
                                <div class="flex items-center text-sm text-gray-600 mb-2">
                                    <span class="mr-4">👤 From: {{ $request->donation->user->name }}</span>
                                    <span class="mr-4">📦 {{ $request->donation->category }}</span>
                                    <span>📊 {{ $request->donation->quantity }}</span>
                                </div>
                                <p class="text-gray-700 mb-3">{{ Str::limit($request->donation->description, 120) }}
                                </p>

                                @if ($request->message)
                                    <div class="bg-blue-50 rounded-lg p-3 mb-3">
                                        <p class="text-sm text-blue-800"><strong>Your message:</strong>
                                            "{{ $request->message }}"</p>
                                    </div>
                                @endif

                                <p class="text-xs text-gray-500">Requested {{ $request->created_at->diffForHumans() }}
                                </p>
                            </div>

                            <div class="mt-4 sm:mt-0 sm:ml-6">
                                <span
                                    class="inline-flex items-center px-3 py-1 text-sm font-semibold rounded-full
                                    {{ $request->status === 'pending'
                                        ? 'bg-yellow-100 text-yellow-800'
                                        : ($request->status === 'approved'
                                            ? 'bg-green-100 text-green-800'
                                            : ($request->status === 'claimed'
                                                ? 'bg-blue-100 text-blue-800'
                                                : ($request->status === 'rejected'
                                                    ? 'bg-red-100 text-red-800'
                                                    : 'bg-gray-100 text-gray-800'))) }}">
                                    @switch($request->status)
                                        @case('pending')
                                            ⏳ Pending
                                        @break

                                        @case('approved')
                                            ✅ Approved
                                        @break

                                        @case('claimed')
                                            🎯 Claimed
                                        @break

                                        @case('rejected')
                                            ❌ Rejected
                                        @break

                                        @case('completed')
                                            🎉 Completed
                                        @break

                                        @default
                                            {{ ucfirst($request->status) }}
                                    @endswitch
                                </span>
                            </div>
                        </div>

                        <!-- Status Information -->
                        <div class="border-t pt-4">
                            @switch($request->status)
                                @case('pending')
                                    <div class="flex items-center text-yellow-700 bg-yellow-50 rounded-lg p-3">
                                        <span class="text-lg mr-2">⏳</span>
                                        <p class="text-sm">Your request is being reviewed by the donor. Please wait for their
                                            response.</p>
                                    </div>
                                @break

                                @case('approved')
                                    <div class="flex items-center text-green-700 bg-green-50 rounded-lg p-3">
                                        <span class="text-lg mr-2">🎉</span>
                                        <p class="text-sm">Great news! Your request has been approved. You can now coordinate
                                            with the donor for pickup.</p>
                                    </div>
                                @break

                                @case('claimed')
                                    <div class="flex items-center text-blue-700 bg-blue-50 rounded-lg p-3">
                                        <span class="text-lg mr-2">🎯</span>
                                        <p class="text-sm">Congratulations! You were the first to request this donation and it
                                            has been automatically claimed for you. Contact the donor to arrange pickup.</p>
                                    </div>
                                @break

                                @case('rejected')
                                    <div class="flex items-center text-red-700 bg-red-50 rounded-lg p-3">
                                        <span class="text-lg mr-2">😔</span>
                                        <p class="text-sm">Unfortunately, your request was not approved. Don't worry, there are
                                            many other donations available!</p>
                                    </div>
                                @break

                                @case('completed')
                                    <div class="flex items-center text-blue-700 bg-blue-50 rounded-lg p-3">
                                        <span class="text-lg mr-2">🏆</span>
                                        <p class="text-sm">This donation has been completed successfully. Thank you for helping
                                            reduce food waste!</p>
                                    </div>
                                @break
                            @endswitch
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-3 mt-4">
                            <a href="{{ route('donations.show', ['donation' => $request->donation, 'from' => 'recipient']) }}"
                                class="text-green-600 hover:text-green-700 text-sm font-medium transition-colors">
                                View Donation Details
                            </a>
                        </div>
                    </div>
                    @empty
                        <div class="text-center py-12">
                            <div class="text-6xl mb-4">🔍</div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">No Requests Yet</h3>
                            <p class="text-gray-600 mb-6">You haven't made any donation requests yet. Start browsing
                                available donations to make your first request!</p>
                            <a href="{{ route('donations.index') }}"
                                class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors inline-flex items-center">
                                <span class="mr-2">🍎</span>
                                Browse Available Donations
                            </a>
                        </div>
                    @endforelse

                    <!-- Pagination -->
                    @if ($requests->hasPages())
                        <div class="mt-8">
                            {{ $requests->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </body>

    </html>
