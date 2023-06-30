<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="min-h-screen flex flex-col">
<header class="py-8 px-4 border-b-2 border-black sm:px-20">
    <nav class="flex flex-col font-bold justify-between w-full sm:flex-row">
        <div class="flex flex-col sm:flex-row">
            <a class="text-5xl mr-4 font-serif font-thin" href="{{ route('home') }}">MPBank</a>
            <div class="flex flex-col items-baseline sm:flex-row sm:items-center">
                @if (Auth::check())
                    <x-custom-link href="{{ route('accounts') }}">My Accounts</x-custom-link>
                    @if(auth()->user()->accounts()->where('type', 'debit')->count() > 0)
                        <x-custom-link href="{{ route('transfer.create') }}">Make a transfer</x-custom-link>
                    @endif
                    @if(auth()->user()->accounts()->where('type', 'investment')->count() > 0)
                        <x-custom-link href="{{ route('investments') }}">Purchase investments</x-custom-link>
                    @endif
                @endif
            </div>
        </div>


        <div class="flex flex-col items-baseline sm:flex-row sm:items-center">
            @if (Auth::check())
                <x-custom-link href="{{ route('profile') }}">Profile</x-custom-link>
                <x-custom-link href="{{ route('logout') }}">Logout</x-custom-link>
            @else
                <x-custom-link href="{{ route('register.form') }}">Register</x-custom-link>
                <x-custom-link href="{{ route('login.form') }}">Login</x-custom-link>
            @endif
        </div>
    </nav>
</header>

<div class="content">
    @yield('content')
</div>

<footer class="mt-auto text-center border-t-2 py-2 text-gray-700">
    Laravel - MPBank - Matīss Porietis
</footer>
</body>
</html>
