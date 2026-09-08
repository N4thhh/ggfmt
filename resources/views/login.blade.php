@extends('layouts.app')
@section('content')
<div class="grid grid-cols-4 md:grid-cols-4 grid-rows-4 md:grid-rows-5 gap-2 md:gap-2 m-4">
    <div class="hidden md:block md:col-start-1 md:row-start-1 md:col-span-2 md:row-span-5 bg-gray-300 rounded-md p-10">
        <!--image-->
    </div>
  
    <div class="col-start-1 row-start-1 col-span-4 row-span-4 md:col-start-3 md:row-start-1 md:col-span-2 md:row-span-5 bg-gray-300 rounded-md p-10">
        <form method="POST" action="{{ route('login.submit') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-bold mb-2">Email:</label>
                <input type="email" id="email" name="email" class="w-full p-2 border border-gray-300 rounded">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-bold mb-2">Password:</label>
                <input type="password" id="password" name="password" class="w-full p-2 border border-gray-300 rounded">
            </div>
            
            <div class="text-red-500 mb-4">
                @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
                @endforeach
            </div>

            <div class="mb-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Login
                </button>
            </div>
        </form>
        
    </div>
</div>
@endsection