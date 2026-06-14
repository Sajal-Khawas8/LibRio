<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('logo.png') }}" type="image/x-icon">
    <title>LibRio Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex gap-0 h-screen">
    @if (session()->has('success'))
    <x-shared.message type='success' />
    @elseif (session()->has('error'))
    <x-shared.message type='error' />
    @endif

    <aside class="w-64 h-full px-3 py-2.5 text-lg space-y-7 hidden lg:block">
        <header class="mx-auto my-3 w-fit">
            <a href="/admin" class="flex items-center">
                <img src="{{ asset("logo.png") }}" alt="LibRio Logo" class="h-12 w-12 object-cover">
                <span class="text-red-800 font-medium text-2xl px-3">LibRio</span>
            </a>
        </header>
        <nav>
            <ul class="space-y-7">
                <li class="flex items-center relative">
                    <x-icons.home class="w-7 h-7 mx-4" />
                    <span>Home</span>
                    <a href="{{ route('admin.dashboard') }}" class="absolute inset-0"></a>
                </li>
                <li class="flex items-center">
                    <h3 class="text-indigo-600 font-semibold">General</h3>
                </li>
                <li class="flex items-center relative">
                    <x-icons.book-stack class="w-7 h-7 mx-4" />
                    <span>Books</span>
                    <a href="{{ route('admin.books.index') }}" class="absolute inset-0"></a>
                </li>
                <li class="flex items-center relative">
                    <x-icons.user-flat class="w-7 h-7 mx-4" />
                    <span>Readers</span>
                    <a href="{{ route('admin.readers.index') }}" class="absolute inset-0"></a>
                </li>
                <li class="flex items-center relative">
                    <x-icons.books class="w-7 h-7 mx-4" />
                    <span>Rented Books</span>
                    <a href="{{ route('admin.books.rented') }}" class="absolute inset-0"></a>
                </li>
                <li class="flex items-center relative">
                    <x-icons.category class="w-7 h-7 mx-4" />
                    <span>Book Categories</span>
                    <a href="{{ route('admin.categories.index') }}" class="absolute inset-0"></a>
                </li>
                <li class="flex items-center relative">
                    <x-icons.payment class="w-7 h-7 mx-4" />
                    <span>Payments</span>
                    <a href="{{ route('admin.payments') }}" class="absolute inset-0"></a>
                </li>
                <li class="flex items-center">
                    <h3 class="text-indigo-600 font-semibold">Others</h3>
                </li>
                <li class="flex items-center relative">
                    <x-icons.admin class="w-7 h-7 mx-4" />
                    <span>Admins</span>
                    <a href="{{ route('admin.team.index') }}" class="absolute inset-0"></a>
                </li>
                <li class="flex items-center relative">
                    <x-icons.settings class="w-7 h-7 mx-4" />
                    <span>Settings</span>
                    <a href="{{ route('admin.settings.profile.show') }}" class="absolute inset-0"></a>
                </li>
            </ul>
        </nav>
        <footer class="font-semibold leading-9 rounded-md bg-indigo-600 text-white hover:bg-indigo-800">
            <form action="/logout" method="post">
                @csrf
                <button name="logout" id="logout" class="flex items-center w-full">
                    <x-icons.logout class="w-7 h-7 mx-4" />
                    <span>Log Out</span>
                </button>
            </form>
        </footer>
    </aside>

    <main class="flex-1 bg-gray-100 overflow-y-hidden flex flex-col relative">
        <header class="flex justify-between items-center text-sm py-2.5 px-6">
            <h3 class="text-lg font-medium">Welcome, {{ auth()->user()->name }}</h3>
            @empty(auth()->user()->image)
            <x-icons.user-circle class="w-10 h-10 text-indigo-500" />
            @else
            <div class="w-10 h-10 rounded-full">
                <img src="{{ auth()->user()->image }}" alt="{{ auth()->user()->name }}"
                    class="w-full h-full object-cover rounded-full">
            </div>
            @endempty
        </header>
        <section class="flex-1 flex flex-col space-y-5 overflow-y-hidden">
            @yield("admin")
        </section>
    </main>
</body>

</html>