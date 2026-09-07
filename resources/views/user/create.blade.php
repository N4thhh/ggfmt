    <div class="grid grid-cols-4 md:grid-cols-4 grid-rows-4 md:grid-rows-5 gap-2 md:gap-2 m-4">
    <div class="hidden md:block md:col-start-1 md:row-start-1 md:col-span-2 md:row-span-5 bg-gray-300 rounded-md p-10">
        <!--image-->
    </div>
  
    <div class="col-start-1 row-start-1 col-span-4 row-span-4 md:col-start-3 md:row-start-1 md:col-span-2 md:row-span-5 bg-gray-300 rounded-md p-10">
        <form method="POST" action="{{ route('user.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-bold mb-2">Name:</label>
                <input type="text" id="name" name="name" class="w-full p-2 border border-gray-300 rounded">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-bold mb-2">Email:</label>
                <input type="email" id="email" name="email" class="w-full p-2 border border-gray-300 rounded">
            </div>
            <div class="mb-4">
                <label for="role" class="block text-gray-700 font-bold mb-2">Role:</label>
                <select id="role" name="role" class="w-full p-2 border border-gray-300 rounded">
                    <option value="mt">Management Trainee</option>
                    <option value="panelist">Panelist</option>
                    <option value="coach">Coach</option>
                </select>
            </div>

            <div class="mb-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Create User
                </button>
            </div>
        </form>
        
    </div>
</div>