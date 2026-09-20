@extends('layouts.app')
@section('content')
<div class="grid grid-cols-3 md:grid-cols-5 grid-rows-6 md:grid-rows-6 gap-2 md:gap-2 m-4">
  <div class="col-start-1 row-start-1 col-span-3 md:col-start-1 md:row-start-1 md:col-span-5 md:row-span-2 bg-[#197B40] rounded-md p-10">
    <div class="flex flex-row items-center justify-between w-full">
        <div class="flex flex-row items-center gap-6 -mt-5 -mb-5 -ml-4">
        <img src="{{ asset('Pina - Info.png') }}" alt="Pina Info" class="w-24">
        
        <div class="space-y-0.5 text-left">
          <p class="text-xs font-thin text-white">PANELIST</p>
          <p class="text-lg font-black text-white">{{$panelist->user->name}}</p>
        </div>
      </div>
    </div>
  </div>
  
  <div class="col-start-1 row-start-2 col-span-3 md:col-start-1 md:row-start-3 md:col-span-1 md:row-span-4 bg-gray-300 rounded-md p-10">


  </div>
      
</div>
@endsection