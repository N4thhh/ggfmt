<div class="grid grid-cols-4 md:grid-cols-5 grid-rows-4 md:grid-rows-6 gap-2 md:gap-2 m-4">
    
    <div class="col-start-1 row-start-1 col-span-4 md:col-start-2 md:row-start-2 md:col-span-3 md:row-span-1 bg-gray-300 rounded-md p-10">
        <p>Welcome, <strong>{{ $user->name }}</strong></p>
        <p>Please set up your account</p>
    </div>
    
    <div class="col-start-1 row-start-2 col-span-4 row-span-3 md:col-start-2 md:row-start-3 md:col-span-3 md:row-span-3 bg-gray-300 rounded-md p-10">
        <form method="POST" action="{{ route('account-setup.store', $token) }}">
            @csrf
            @if ($errors->any())
            <div class="text-red-500 mb-4">
                @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
                @endforeach
            </div>
            @endif
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-bold mb-2">Password:</label>
                <input type="password" id="password" name="password" class="w-full p-2 border border-gray-300 rounded">
            </div>
            <div class="mb-4">
                <label for="password_confirmation" class="block text-gray-700 font-bold mb-2">Confirm Password:</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="w-full p-2 border border-gray-300 rounded">
            </div>
            <div class="mb-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Submit
                </button>
            </div>
    </div>
      
</div>