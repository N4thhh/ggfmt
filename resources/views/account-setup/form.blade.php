@extends('layouts.app')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center p-4">
    <div class="w-full max-w-md flex flex-col gap-4">
        
        <div class="bg-[#197B40] rounded-4xl p-8 shadow-md flex flex-col items-center text-center border border-[#146032]">
            <div class="w-14 h-14 bg-[#fba919] rounded-full flex items-center justify-center text-white mb-4 shadow-sm">
                <i data-lucide="user-check" class="w-7 h-7"></i>
            </div>
            <h2 class="text-2xl font-black text-white mb-1">Welcome, {{ $user->name }}!</h2>
            <p class="text-sm font-semibold text-white/80">Please set up your account password</p>
        </div>

        <div class="bg-white rounded-4xlx p-8 shadow-xl border border-gray-100">
            <form method="POST" action="{{ route('account-setup.store', $token) }}" class="flex flex-col gap-5">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-600 text-sm font-semibold p-4 rounded-xl mb-2">
                        <ul class="list-disc list-inside flex flex-col gap-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="flex flex-col gap-1.5">
                    <label for="password" class="text-xs font-extrabold text-gray-500 uppercase tracking-wide">New Password</label>
                    <div class="relative">
                        <i data-lucide="lock" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                        <input type="password" id="password" name="password" required placeholder="Enter new password"
                               class="w-full pl-11 pr-4 py-3 border-2 border-gray-100 rounded-xl text-sm font-semibold text-gray-800 focus:outline-none focus:border-[#197B40] transition-colors bg-gray-50">
                    </div>
                </div>

                <div class="flex flex-col gap-1.5">
                    <label for="password_confirmation" class="text-xs font-extrabold text-gray-500 uppercase tracking-wide">Confirm Password</label>
                    <div class="relative">
                        <i data-lucide="lock-keyhole" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                        <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Confirm new password"
                               class="w-full pl-11 pr-4 py-3 border-2 border-gray-100 rounded-xl text-sm font-semibold text-gray-800 focus:outline-none focus:border-[#197B40] transition-colors bg-gray-50">
                    </div>
                </div>

                <button type="submit" class="w-full bg-[#197B40] hover:bg-[#146032] text-white font-extrabold py-3.5 rounded-xl transition-all shadow-md mt-2 tracking-wide">
                    Save Password & Login
                </button>
            </form>
        </div>

    </div>
</div>
@endsection