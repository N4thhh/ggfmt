@extends('layouts.app')
@section('content')
<div class="min-h-screen bg-[#197B40] flex items-center justify-center p-6">
    
    <div class="bg-white rounded-4xl shadow-2xl flex flex-col md:flex-row w-full max-w-5xl overflow-hidden">
        
        <div class="w-full md:w-1/2 bg-gray-50 flex items-center justify-center p-12 border-b md:border-b-0 md:border-r border-gray-100">
            <img src="{{ asset('Pina - Say Hi.png') }}" alt="Pina - Say Hi" class="max-w-full h-auto object-contain">
        </div>
        
        <div class="w-full md:w-1/2 p-10 md:p-16 flex flex-col justify-center bg-white">
            
            <div class="flex justify-center mb-6">
                <img src="{{ asset('GGF Green.png') }}" alt="GGF Logo" class="h-16 object-contain">
            </div>
            
            <div class="text-center mb-10">
                <h2 class="text-3xl font-extrabold text-[#197B40] mb-2 tracking-tight">Welcome Back</h2>
                <p class="text-gray-500 text-sm">Sign in to access your training dashboard</p>
            </div>
            
            <form method="POST" action="{{ route('login.submit') }}" class="flex flex-col gap-6">
                @csrf
                
                <div>
                    <label for="email" class="block text-sm font-bold text-gray-900 mb-2">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#197B40] focus:border-transparent transition text-sm" required>
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-bold text-gray-900 mb-2">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#197B40] focus:border-transparent transition text-sm" required>
                </div>
                
                @if ($errors->any())
                <div class="text-red-500 text-sm -mt-2.5">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
                @endif

                <button type="submit" class="w-full mt-2 bg-[#fba919] hover:bg-orange-500 text-white font-bold text-lg py-3.5 rounded-xl shadow-sm transition duration-300">
                    Sign In
                </button>
            </form>
            
            <div class="mt-8 text-center text-sm text-gray-500">
                Forgot password? <a href="#" class="text-[#197B40] font-bold hover:underline">click here</a>
            </div>
            
        </div>
    </div>
    
</div>
@endsection