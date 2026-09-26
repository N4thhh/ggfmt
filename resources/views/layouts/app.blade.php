<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'GGP MT System')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @if(Auth::check())
    <nav class=" mx-6 flex items-center justify-between px-8 h-16 rounded-b-[25px] shadow-md sticky top-0 z-50 bg-[#197B40]">
        <div><img class="h-9 mb-2" src="{{ asset('GGF White.png') }}" alt="GGF Logo"></div>
            <div class="items-center gap-8 flex">
                @if(Auth::user()->role === 'admin' || Auth::user()->role === 'hr')
                    <a href="{{ route('dashboard') }}" class="text-white no-underline text-sm font-semibold opacity-80 transition whitespace-nowrap {{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
                    <a href="{{ route('mt.index') }}" class="text-white no-underline text-sm font-semibold opacity-80 transition whitespace-nowrap {{ request()->routeIs('mt.*') ? 'active' : '' }}">Management Trainees</a>
                    <a href="{{ route('coach.index') }}" class="text-white no-underline text-sm font-semibold opacity-80 transition whitespace-nowrap {{ request()->routeIs('coach.*') ? 'active' : '' }}">Coach</a>
                    <a href="{{ route('panelist.index') }}" class="text-white no-underline text-sm font-semibold opacity-80 transition whitespace-nowrap {{ request()->routeIs('panelist.*') ? 'active' : '' }}">Panelist</a>
                    <a href="{{ route('user.index') }}" class="text-white no-underline text-sm font-semibold opacity-80 transition whitespace-nowrap {{ request()->routeIs('user.*') ? 'active' : '' }}">Users</a>
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('user.create') }}" class="text-white no-underline text-sm font-semibold opacity-80 transition whitespace-nowrap {{ request()->routeIs('user.create') ? 'active' : '' }}">Create Account</a>
                    @endif
                @endif

                @if(Auth::user()->role === 'coach')
                    <a href="{{ route('coach.show', Auth::user()->coach) }}" class="text-white no-underline text-sm font-semibold opacity-80 transition whitespace-nowrap {{ request()->routeIs('coach.*') ? 'active' : '' }}">My Profile</a>
                @endif
            </div>
                <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-[#D32F2F] text-white text-sm py-2 px-4 font-bold rounded-full whitespace-nowrap transition hover:bg-[#b71c1c]">
                    Logout
                </button>
            </form>
        </div>
    </nav>
    @endif
    @yield('content')
</body>
</html>