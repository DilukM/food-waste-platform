<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Donor Dashboard - FoodShare</title>

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
                        <a href="{{ url('/') }}" class="text-xl font-bold text-gray-900">🌱 FoodShare</a>
                    </div>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <!-- Navigation simplified for donor dashboard -->
                    </div>
                </div>

                <!-- Auth Links -->
                <div class="flex items-center space-x-4">
                    <!-- View as Recipient Button -->
                    <a href="{{ route('donations.index') }}"
                        class="glass-card hover:bg-white hover:bg-opacity-80 text-green-600 hover:text-blue-700 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 backdrop-blur-md border border-white border-opacity-30 shadow-lg inline-flex items-center">

                        View as Recipient
                    </a>

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
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">Donor Dashboard 📦</h1>
                        <p class="text-gray-600">Manage your food donations and requests</p>
                    </div>
                    <div class="mt-4 sm:mt-0">
                        <a href="{{ route('donations.create') }}"
                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors inline-flex items-center">
                            <span class="mr-2">+</span>
                            Add New Donation
                        </a>
                    </div>
                </div>
            </div>

            <!-- Donations Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                @forelse($donations as $donation)
                    <div class="glass-card rounded-xl shadow-xl p-6">
                        <!-- Donation Header -->
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-xl font-bold text-gray-900">{{ $donation->title }}</h3>
                            <span
                                class="inline-flex items-center px-3 py-1 text-sm font-semibold rounded-full
                                {{ $donation->status === 'available'
                                    ? 'bg-green-100 text-green-800'
                                    : ($donation->status === 'claimed'
                                        ? 'bg-yellow-100 text-yellow-800'
                                        : 'bg-blue-100 text-blue-800') }}">
                                {{ ucfirst($donation->status) }}
                            </span>
                        </div>

                        <!-- Donation Details -->
                        <div class="space-y-3 mb-4">
                            <div class="flex items-center text-sm text-gray-600">
                                <span class="mr-2">📦</span>
                                <span>{{ $donation->category }} • {{ $donation->quantity }}</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <span class="mr-2">⏰</span>
                                <span>Expires: {{ $donation->expires_at->format('M j, Y') }}</span>
                            </div>
                            <p class="text-gray-700 text-sm">{{ Str::limit($donation->description, 100) }}</p>
                        </div>

                        <!-- Request Stats -->
                        @if ($donation->requests->count() > 0)
                            <div class="mb-4 p-3 bg-blue-50 bg-opacity-50 rounded-lg">
                                <h4 class="font-semibold text-sm text-blue-800 mb-2">Requests
                                    ({{ $donation->requests->count() }})
                                </h4>
                                <div class="space-y-1">
                                    @foreach ($donation->requests->take(3) as $request)
                                        <div class="flex justify-between items-center text-xs">
                                            <span class="text-gray-700">{{ $request->user->name }}</span>
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-full text-xs
                                                {{ $request->status === 'pending'
                                                    ? 'bg-yellow-100 text-yellow-800'
                                                    : ($request->status === 'approved'
                                                        ? 'bg-green-100 text-green-800'
                                                        : 'bg-red-100 text-red-800') }}">
                                                {{ ucfirst($request->status) }}
                                            </span>
                                        </div>
                                    @endforeach
                                    @if ($donation->requests->count() > 3)
                                        <p class="text-xs text-gray-500">+{{ $donation->requests->count() - 3 }} more
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="flex gap-2">
                            <a href="{{ route('donations.show', $donation) }}"
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg text-sm font-medium transition-colors text-center">
                                👁️ View
                            </a>
                            @if ($donation->status === 'available')
                                <a href="{{ route('donations.edit', $donation) }}"
                                    class="flex-1 bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg text-sm font-medium transition-colors text-center">
                                    ✏️ Edit
                                </a>
                                <form method="POST" action="{{ route('donations.destroy', $donation) }}"
                                    class="flex-1"
                                    onsubmit="return confirm('Are you sure you want to delete this donation?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-full bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg text-sm font-medium transition-colors">
                                        🗑️ Delete
                                    </button>
                                </form>
                            @else
                                <div
                                    class="flex-1 bg-gray-400 text-white px-3 py-2 rounded-lg text-sm font-medium text-center">
                                    🔒 Locked
                                </div>
                                <div
                                    class="flex-1 bg-gray-400 text-white px-3 py-2 rounded-lg text-sm font-medium text-center">
                                    🔒 Locked
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="lg:col-span-3 xl:col-span-3">
                        <div class="glass-card rounded-xl shadow-xl p-12 text-center">
                            <div class="mb-6">
                                <span class="text-6xl">📦</span>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-4">No Donations Yet</h3>
                            <p class="text-gray-600 mb-8">You haven't created any donations yet. Start sharing food
                                with your community!</p>
                            <a href="{{ route('donations.create') }}"
                                class="bg-green-600 hover:bg-green-700 text-white px-8 py-4 rounded-lg font-semibold transition-colors inline-flex items-center">
                                <span class="mr-2">🍎</span>
                                Create Your First Donation
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Quick Stats -->
            @if ($donations->count() > 0)
                <div class="mt-8 glass-card rounded-xl shadow-xl p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">📊 Quick Stats</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">{{ $donations->count() }}</div>
                            <div class="text-sm text-gray-600">Total Donations</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600">
                                {{ $donations->where('status', 'available')->count() }}</div>
                            <div class="text-sm text-gray-600">Available</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-yellow-600">
                                {{ $donations->where('status', 'claimed')->count() }}</div>
                            <div class="text-sm text-gray-600">Claimed</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-purple-600">
                                {{ $donations->sum(fn($d) => $d->requests->count()) }}</div>
                            <div class="text-sm text-gray-600">Total Requests</div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
</body>

</html>
