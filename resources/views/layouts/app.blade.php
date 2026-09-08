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
            <a href="{{ route('mt.index') }}" class="text-white no-underline text-sm font-semibold opacity-80 transition whitespace-nowrap {{ request()->routeIs('mt.*') ? 'active' : '' }}">Management Trainees</a>
            <a href="{{ route('user.index') }}" class="text-white no-underline text-sm font-semibold opacity-80 transition whitespace-nowrap {{ request()->routeIs('user.*') ? 'active' : '' }}">Users</a>
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('user.create') }}" class="text-white no-underline text-sm font-semibold opacity-80 transition whitespace-nowrap {{ request()->routeIs('user.*') ? 'active' : '' }}">Create Account</a>
            @endif
        </div>
        <div class="flex items-center gap-5">
            <div class="flex items-center gap-4 text-white">
                @if(Auth::user()->managementTrainee?->profile_picture)
                <img src="{{ asset('storage/' . Auth::user()->managementTrainee->profile_picture) }}" alt="Profile" class="avatar-circle">
                <p><strong> {{ Str::title(Auth::user()->name) }}</strong></p>
                @else
                <div class="w-8 h-8 bg-[#FF9A02] flex items-center justify-center font-bold text-sm rounded-full shrink-0">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }} 
                </div>
                <p><strong> {{ Str::title(Auth::user()->name) }}</strong></p>   

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