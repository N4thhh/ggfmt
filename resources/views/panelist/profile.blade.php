@extends('layouts.app')
@section('content')
<div class="grid grid-cols-3 md:grid-cols-5 auto-rows-min gap-2 md:gap-2 m-4">  <div class="col-start-1 row-start-1 col-span-3 md:col-start-1 md:row-start-1 md:col-span-5 md:row-span-2 bg-[#197B40] rounded-md p-10">
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

  <div class="col-start-1 row-start-3 col-span-3 md:col-start-1 md:row-start-3 md:col-span-5 bg-gray-100 rounded-md p-6">
    
    <div class="flex gap-4 mb-4">
        <button onclick="showFilter('pending')">Pending</button>
        <button onclick="showFilter('scored')">Scored</button>
    </div>

    <div id="pending" class="tab-content" style="display: block;">
        <div class="flex flex-wrap gap-4">
          @foreach ($pendingAccess as $access)
            <div class="bg-white rounded-md p-4 shadow w-64">
              <p class="font-bold">{{ $access->assignment->managementTrainee->user->name }}</p>
              <p>{{ $access->assignment->phase }}</p>
              <p>{{ $access->assignment->title }}</p>
              <p>Uploaded: {{ $access->assignment->uploaded_at ?? 'Not yet' }}</p>
              <a href="{{ route('scoring.adminShow', $access->assignment) }}" class="text-blue-500">Score</a>
            </div>
          @endforeach
        </div>
    </div>

    <div id="scored" class="tab-content" style="display: none;">
        <div class="flex flex-wrap gap-4">
          @foreach ($scoredAccess as $access)
            <div class="bg-white rounded-md p-4 shadow w-64">
              <p class="font-bold">{{ $access->assignment->managementTrainee->user->name }}</p>
              <p>{{ $access->assignment->phase }}</p>
              <p>{{ $access->assignment->title }}</p>
              <p>Uploaded: {{ $access->assignment->uploaded_at }}</p>
              <a href="{{ route('mt.show', $access->assignment->managementTrainee) . '?phase=' . urlencode($access->assignment->phase) }}" class="text-blue-500">View</a>            
            </div>
          @endforeach
        </div>
    </div>
</div>

<script>
    function showFilter(filter) {
        document.querySelectorAll('.tab-content').forEach(el => {
            el.style.display = 'none';
        });
        document.getElementById(filter).style.display = 'block';
    }
</script>

@endsection