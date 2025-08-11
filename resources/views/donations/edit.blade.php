<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Donation - FoodShare</title>

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
                            <img src="{{ asset('logo.svg') }}" alt="FoodShare Logo" class="h-8 w-auto">
                        </a>
                    </div>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="{{ route('donations.manage') }}"
                            class="text-gray-900 hover:text-green-700 px-3 py-2 rounded-md text-sm font-medium transition-colors">Manage
                            Donations</a>
                    </div>
                </div>

                <!-- Auth Links -->
                <div class="flex items-center space-x-4">
                    @auth
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

    <!-- Main Content -->
    <section class="relative min-h-screen gradient-bg hero-pattern">
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-12">


            <!-- Main Card -->
            <div class="glass-card rounded-2xl shadow-xl p-8">
                <!-- Header -->
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Edit Donation</h1>
                    <p class="text-gray-600">{{ $donation->title }}</p>
                </div>

                <!-- Donation Details -->
                <div class="mb-8">
                    <h3 class="text-xl font-bold mb-4 text-gray-900">Current Status</h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p><span class="font-semibold">Current Status:</span>
                            <span
                                class="px-2 py-1 rounded-full text-xs font-medium
                                @if ($donation->status === 'available') bg-green-100 text-green-800
                                @elseif($donation->status === 'claimed') bg-yellow-100 text-yellow-800
                                @elseif($donation->status === 'delivered') bg-blue-100 text-blue-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($donation->status) }}
                            </span>
                        </p>
                        <p class="text-sm text-gray-600 mt-2">Created on
                            {{ $donation->created_at->format('M j, Y \a\t g:i A') }}</p>
                    </div>
                </div>

                <!-- Edit Donation Form or Read-Only View -->
                @if ($donation->status === 'available')
                    <!-- Edit Donation Form -->
                    <div class="mb-8">
                        <h4 class="text-lg font-bold mb-4 text-gray-900">Edit Donation Details</h4>
                        <form method="POST" action="{{ route('donations.update', $donation) }}" class="space-y-6">
                            @csrf
                            @method('PATCH')

                            <!-- Title -->
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                                <input type="text" id="title" name="title"
                                    value="{{ old('title', $donation->title) }}" required
                                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500 transition-colors">
                                @error('title')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="description"
                                    class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                <textarea id="description" name="description" rows="4" required
                                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500 transition-colors">{{ old('description', $donation->description) }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Quantity -->
                            <div>
                                <label for="quantity"
                                    class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                                <input type="number" id="quantity" name="quantity"
                                    value="{{ old('quantity', $donation->quantity) }}" min="1" required
                                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500 transition-colors">
                                @error('quantity')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Expiration Date -->
                            <div>
                                <label for="expires_at" class="block text-sm font-medium text-gray-700 mb-2">Expiration
                                    Date
                                    & Time</label>
                                <input type="datetime-local" id="expires_at" name="expires_at"
                                    value="{{ old('expires_at', $donation->expires_at ? $donation->expires_at->format('Y-m-d\TH:i') : '') }}"
                                    required
                                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500 transition-colors">
                                @error('expires_at')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Location -->
                            <div>
                                <label for="location"
                                    class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                                <input type="text" id="location" name="location"
                                    value="{{ old('location', $donation->location) }}" required
                                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500 transition-colors">
                                @error('location')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Category -->
                            <div>
                                <label for="category"
                                    class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                                <select id="category" name="category" required
                                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500 transition-colors">
                                    <option value="fruits"
                                        {{ old('category', $donation->category) === 'fruits' ? 'selected' : '' }}>🍎
                                        Fruits
                                    </option>
                                    <option value="vegetables"
                                        {{ old('category', $donation->category) === 'vegetables' ? 'selected' : '' }}>
                                        🥕
                                        Vegetables</option>
                                    <option value="dairy"
                                        {{ old('category', $donation->category) === 'dairy' ? 'selected' : '' }}>🥛
                                        Dairy
                                    </option>
                                    <option value="meat"
                                        {{ old('category', $donation->category) === 'meat' ? 'selected' : '' }}>🥩 Meat
                                        &
                                        Poultry</option>
                                    <option value="bakery"
                                        {{ old('category', $donation->category) === 'bakery' ? 'selected' : '' }}>🍞
                                        Bakery
                                        Items</option>
                                    <option value="pantry"
                                        {{ old('category', $donation->category) === 'pantry' ? 'selected' : '' }}>🥫
                                        Pantry
                                        Staples</option>
                                    <option value="prepared"
                                        {{ old('category', $donation->category) === 'prepared' ? 'selected' : '' }}>🍽️
                                        Prepared Meals</option>
                                    <option value="other"
                                        {{ old('category', $donation->category) === 'other' ? 'selected' : '' }}>📦
                                        Other
                                    </option>
                                </select>
                                @error('category')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit"
                                class="w-full bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold text-lg transition-all shadow-lg">
                                🔄 Update Donation
                            </button>
                        </form>
                    </div>
                @else
                    <!-- Read-Only Donation Details -->
                    <div class="mb-8">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-lg font-bold text-gray-900">Donation Details</h4>
                            <div class="flex items-center text-sm text-amber-600 bg-amber-50 px-3 py-1 rounded-full">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Editing locked - Donation has been claimed
                            </div>
                        </div>
                        <div class="bg-gray-50 p-6 rounded-lg space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                                <p class="text-gray-900">{{ $donation->title }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                <p class="text-gray-900">{{ $donation->description }}</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                                    <p class="text-gray-900">{{ $donation->quantity }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                                    <p class="text-gray-900">
                                        @switch($donation->category)
                                            @case('fruits')
                                                🍎 Fruits
                                            @break

                                            @case('vegetables')
                                                🥕 Vegetables
                                            @break

                                            @case('dairy')
                                                🥛 Dairy
                                            @break

                                            @case('meat')
                                                🥩 Meat & Poultry
                                            @break

                                            @case('bakery')
                                                🍞 Bakery Items
                                            @break

                                            @case('pantry')
                                                🥫 Pantry Staples
                                            @break

                                            @case('prepared')
                                                🍽️ Prepared Meals
                                            @break

                                            @default
                                                📦 Other
                                        @endswitch
                                    </p>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                                <p class="text-gray-900">{{ $donation->location }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Expiration Date</label>
                                <p class="text-gray-900">{{ $donation->expires_at->format('M j, Y \a\t g:i A') }}</p>
                            </div>
                        </div>

                        <div class="mt-4 p-4 bg-blue-50 rounded-lg border border-blue-200">
                            <p class="text-sm text-blue-800">
                                <strong>Note:</strong> This donation cannot be edited because it has been
                                {{ $donation->status }}.
                                @if ($donation->status === 'claimed')
                                    A recipient has claimed this donation.
                                @elseif($donation->status === 'delivered')
                                    This donation has been delivered.
                                @elseif($donation->status === 'completed')
                                    This donation has been completed.
                                @endif
                            </p>
                        </div>
                    </div>
                @endif

                <!-- Requests Section -->
                <div>
                    <h4 class="text-lg font-bold mb-4 text-gray-900">Requests ({{ $donation->requests->count() }})
                    </h4>
                    @forelse ($donation->requests as $request)
                        <div class="mb-4 p-4 border border-gray-200 rounded-lg bg-white">
                            <div class="flex justify-between items-start mb-2">
                                <p class="font-semibold text-gray-900">{{ $request->user->name }}</p>
                                <span
                                    class="px-2 py-1 rounded-full text-xs font-medium
                                    @if ($request->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($request->status === 'approved') bg-green-100 text-green-800
                                    @elseif($request->status === 'claimed') bg-blue-100 text-blue-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($request->status) }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-600">{{ $request->message }}</p>
                            <p class="text-xs text-gray-500 mt-2">Requested on
                                {{ $request->created_at->format('M j, Y \a\t g:i A') }}</p>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <p class="text-gray-500">No requests for this donation yet.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
</body>

</html>
