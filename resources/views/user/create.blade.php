@extends('layouts.app')

@section('content')
<div class="bg-white flex items-center justify-center min-h-[calc(100vh-7rem)] px-6 py-2">
    
    <div class="bg-white rounded-4xl shadow-xl border-2 border-[#fba919] flex flex-col md:flex-row w-full max-w-5xl overflow-hidden my-auto">
        
        <div class="w-full md:w-1/2 bg-gray-50 flex items-center justify-center p-8 border-b md:border-b-0 md:border-r border-gray-100">
            <img src="{{ asset('Pina - Say Hi.png') }}" alt="Pina - Say Hi" class="max-w-full max-h-100 object-contain">
        </div>
        
        <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center bg-white">
            
            <div class="text-center mb-6">
                <h2 class="text-3xl font-extrabold text-[#197B40] mb-1 tracking-tight">Create User</h2>
                <p class="text-gray-500 text-sm">Add a new member to the system</p>
            </div>
            
            <form method="POST" action="{{ route('user.store') }}" enctype="multipart/form-data" class="flex flex-col gap-4">
                @csrf
                
                <div>
                    <label for="name" class="block text-sm font-bold text-gray-900 mb-1.5">Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter full name" 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#fba919] focus:border-transparent transition text-sm" required>
                </div>
                
                <div>
                    <label for="email" class="block text-sm font-bold text-gray-900 mb-1.5">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter email address" 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#fba919] focus:border-transparent transition text-sm" required>
                </div>
                
                <div>
                    <label for="role" class="block text-sm font-bold text-gray-900 mb-1.5">Role</label>
                    <select id="role" name="role" 
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#fba919] focus:border-transparent transition text-sm cursor-pointer appearance-none bg-white" required>
                        <option value="mt">Management Trainee</option>
                        <option value="panelist">Panelist</option>
                        <option value="coach">Coach</option>
                    </select>
                </div>

                @if ($errors->any())
                <div class="text-red-500 text-sm">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
                @endif

                <button type="submit" class="w-full mt-2 bg-[#fba919] hover:bg-orange-500 text-white font-bold text-base py-3 rounded-xl shadow-sm transition duration-300">
                    Create User
                </button>
            </form>
            
        </div>
    </div>
    
</div>
@endsection