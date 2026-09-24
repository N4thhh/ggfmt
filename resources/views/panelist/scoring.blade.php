@extends('layouts.app')

@section('content')
<div class="grid grid-cols-3 md:grid-cols-4 grid-rows-6 md:grid-rows-6 gap-2 md:gap-2 m-4">
      
    <div class="col-start-1 row-start-1 col-span-3 md:col-start-1 md:row-start-1 md:col-span-5 md:row-span-2 bg-[#197B40] rounded-md p-10">
        <!-- hero profile card -->
    </div>
      
    <div class="col-start-1 row-start-3 col-span-3 row-span-3 md:col-start-1 md:row-start-3 md:col-span-3 md:row-span-3 bg-gray-300 rounded-md p-10">
        <!-- iframe for pdf -->
    </div>
      
    <div class="col-start-1 row-start-6 md:col-start-4 md:row-start-3 md:col-span-1 md:row-span-1 bg-gray-300 rounded-md p-10">
        <!-- score thingy -->
    </div>
      
    <div class="col-start-2 row-start-6 col-span-2 md:col-start-4 md:row-start-4 md:col-span-1 md:row-span-2 bg-gray-300 rounded-md p-10">
        <!-- comments thingy -->
    </div>
      
    </div>
@endsection