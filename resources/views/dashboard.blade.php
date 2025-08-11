<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - FoodShare</title>

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
                        <a href="{{ url('/') }}"
                            class="text-gray-900 hover:text-green-700 px-3 py-2 rounded-md text-sm font-medium transition-colors">Home</a>
                        <a href="{{ route('donations.index') }}"
                            class="text-gray-900 hover:text-green-700 px-3 py-2 rounded-md text-sm font-medium transition-colors">Browse
                            Donations</a>
                        <a href="{{ route('dashboard') }}"
                            class="bg-green-100 text-green-800 px-3 py-2 rounded-md text-sm font-medium">Dashboard</a>
                    </div>
                </div>

                <!-- Auth Links -->
                <div class="flex items-center space-x-4">
                    <!-- Profile Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false"
                            class="flex items-center space-x-2 bg-white text-green-600 hover:bg-green-50 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            <span>👤</span>
                            <span>{{ $user->name }}</span>
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
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">Welcome back, {{ $user->name }}! 👋</h1>
                        <p class="text-gray-600">Role: <span
                                class="font-semibold text-green-600">{{ $user->role_display }}</span></p>
                    </div>
                    <div class="mt-4 sm:mt-0">
                        @if ($user->canDonate())
                            <a href="{{ route('donations.create') }}"
                                class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors inline-flex items-center">
                                <span class="mr-2">🍎</span>
                                Donate Food
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Dashboard Content -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                <!-- Donor Section -->
                @if ($user->canDonate())
                    <!-- My Donations -->
                    <div class="glass-card rounded-xl shadow-xl p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                            <span class="mr-2">📦</span>
                            My Donations ({{ $donations->count() }})
                        </h2>

                        @forelse($donations as $donation)
                            <div class="mb-4 p-4 border border-gray-200 rounded-lg bg-gray-50 bg-opacity-50">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="font-semibold text-gray-900">{{ $donation->title }}</h3>
                                    <span
                                        class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full
                                        {{ $donation->status === 'available'
                                            ? 'bg-green-100 text-green-800'
                                            : ($donation->status === 'claimed'
                                                ? 'bg-yellow-100 text-yellow-800'
                                                : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($donation->status) }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 mb-2">{{ $donation->category }} •
                                    {{ $donation->quantity }}</p>
                                <p class="text-sm text-gray-700 mb-3">{{ Str::limit($donation->description, 100) }}</p>
                                <div class="flex gap-2">
                                    <a href="{{ route('donations.show', $donation) }}"
                                        class="text-green-600 hover:text-green-700 text-sm font-medium">View</a>
                                    <a href="{{ route('donations.edit', $donation) }}"
                                        class="text-blue-600 hover:text-blue-700 text-sm font-medium">Edit</a>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <p class="text-gray-500 mb-4">You haven't posted any donations yet.</p>
                                <a href="{{ route('donations.create') }}"
                                    class="text-green-600 hover:text-green-700 font-medium">Create your first
                                    donation</a>
                            </div>
                        @endforelse
                    </div>

                    <!-- Requests for My Donations -->
                    <div class="glass-card rounded-xl shadow-xl p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                            <span class="mr-2">📨</span>
                            Received Requests ({{ $received_requests->count() }})
                        </h2>

                        @forelse($received_requests as $request)
                            <div class="mb-4 p-4 border border-gray-200 rounded-lg bg-gray-50 bg-opacity-50">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <h4 class="font-semibold text-gray-900">{{ $request->donation->title }}</h4>
                                        <p class="text-sm text-gray-600">Requested by: {{ $request->user->name }}</p>
                                    </div>
                                    <span
                                        class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full
                                        {{ $request->status === 'pending'
                                            ? 'bg-yellow-100 text-yellow-800'
                                            : ($request->status === 'approved'
                                                ? 'bg-green-100 text-green-800'
                                                : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($request->status) }}
                                    </span>
                                </div>
                                @if ($request->message)
                                    <p class="text-sm text-gray-700 mb-3">"{{ $request->message }}"</p>
                                @endif
                                <p class="text-xs text-gray-500 mb-3">{{ $request->created_at->diffForHumans() }}</p>

                                @if ($request->status === 'pending')
                                    <div class="flex gap-2">
                                        <form method="POST" action="{{ route('requests.update-status', $request) }}"
                                            class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit"
                                                class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm transition-colors">
                                                ✅ Approve
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('requests.update-status', $request) }}"
                                            class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit"
                                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm transition-colors">
                                                ❌ Reject
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <p class="text-gray-500">No requests received yet.</p>
                            </div>
                        @endforelse
                    </div>
                @endif

                <!-- Recipient Section -->
                @if ($user->canReceive())
                    <div class="{{ $user->canDonate() ? '' : 'lg:col-span-2' }}">
                        <!-- My Requests -->
                        <div class="glass-card rounded-xl shadow-xl p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                                <span class="mr-2">🙏</span>
                                My Requests ({{ $requests->count() }})
                            </h2>

                            @forelse($requests as $request)
                                <div class="mb-4 p-4 border border-gray-200 rounded-lg bg-gray-50 bg-opacity-50">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <h4 class="font-semibold text-gray-900">{{ $request->donation->title }}
                                            </h4>
                                            <p class="text-sm text-gray-600">From:
                                                {{ $request->donation->user->name }}</p>
                                        </div>
                                        <span
                                            class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full
                                            {{ $request->status === 'pending'
                                                ? 'bg-yellow-100 text-yellow-800'
                                                : ($request->status === 'approved'
                                                    ? 'bg-green-100 text-green-800'
                                                    : 'bg-red-100 text-red-800') }}">
                                            {{ ucfirst($request->status) }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600 mb-2">{{ $request->donation->category }} •
                                        {{ $request->donation->quantity }}</p>
                                    @if ($request->message)
                                        <p class="text-sm text-gray-700 mb-2">Your message: "{{ $request->message }}"
                                        </p>
                                    @endif
                                    <p class="text-xs text-gray-500 mb-3">Requested
                                        {{ $request->created_at->diffForHumans() }}</p>
                                    <a href="{{ route('donations.show', ['donation' => $request->donation, 'from' => 'recipient']) }}"
                                        class="text-green-600 hover:text-green-700 text-sm font-medium">View
                                        Donation</a>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <p class="text-gray-500 mb-4">You haven't made any requests yet.</p>
                                    <a href="{{ route('donations.index') }}"
                                        class="text-green-600 hover:text-green-700 font-medium">Browse available
                                        donations</a>
                                </div>
                            @endforelse
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
</body>

</html>
