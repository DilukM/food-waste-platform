<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FoodShare - Test</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-green-50">
    <div class="min-h-screen flex items-center justify-center">
        <div class="text-center">
            <div class="flex justify-center mb-4">
                <img src="{{ asset('logo.svg') }}" alt="FoodShare Logo" class="h-16 w-auto">
            </div>
            <p class="text-lg text-gray-600 mb-8">Reduce Food Waste, Share Abundance</p>

            <div class="space-x-4">
                <a href="{{ route('donations.index') }}"
                    class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700">
                    Browse Donations
                </a>

                @guest
                    <a href="{{ route('register') }}"
                        class="bg-white text-green-600 border border-green-600 px-6 py-3 rounded-lg hover:bg-green-50">
                        Get Started
                    </a>
                @else
                    <a href="{{ route('dashboard') }}"
                        class="bg-white text-green-600 border border-green-600 px-6 py-3 rounded-lg hover:bg-green-50">
                        Dashboard
                    </a>
                @endguest
            </div>
        </div>
    </div>
</body>

</html>
