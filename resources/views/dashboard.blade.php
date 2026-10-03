@extends('layouts.app')
@section('content')
<div class="mx-6 my-4 flex flex-col gap-5">
  
  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="bg-[#197B40] rounded-xl p-4 shadow-sm flex justify-between items-center text-white">
      <div>
        <p class="text-sm font-medium text-white/90">Management Trainees</p>
        <p class="text-3xl font-bold mt-1">{{ $total }}</p>
      </div>
      <div class="bg-[#fba919] p-2.5 rounded-xl text-white">
        <i data-lucide="graduation-cap" class="w-8 h-8"></i>
      </div>
    </div>
    
    <div class="bg-[#197B40] rounded-xl p-4 shadow-sm flex justify-between items-center text-white">
      <div>
        <p class="text-sm font-medium text-white/90">Coaches</p>
        <p class="text-3xl font-bold mt-1">{{ $totalCoaches }}</p>
      </div>
      <div class="bg-[#fba919] p-2.5 rounded-xl text-white">
        <i data-lucide="user-check" class="w-8 h-8"></i>
      </div>
    </div>
    
    <div class="bg-[#197B40] rounded-xl p-4 shadow-sm flex justify-between items-center text-white">
      <div>
        <p class="text-sm font-medium text-white/90">Panelists</p>
        <p class="text-3xl font-bold mt-1">{{ $totalPanelists }}</p>
      </div>
      <div class="bg-[#fba919] p-2.5 rounded-xl text-white">
        <i data-lucide="users" class="w-8 h-8"></i>
      </div>
    </div>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 items-stretch">
    @foreach($programStats as $stat)
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 flex flex-col overflow-hidden">
      
      <div class="bg-[#197B40] text-white text-center py-2 px-3 font-bold text-xs h-10 flex items-center justify-center leading-tight">
        {{ $stat['name'] }}
      </div>

      <div class="p-4 flex flex-col flex-1">
        <p class="text-center text-[11px] text-gray-500 mb-4 font-semibold leading-tight">
          Talent Pipeline to Develop <br> 
          <span class="text-gray-800">GGF Future {{ $stat['subtitle'] }}</span>
        </p>

        @php
           $max = max($stat['hired'], $stat['graduate'], $stat['resign'], $stat['failed'], $stat['active']);
           $max = $max > 0 ? $max : 1; 
        @endphp
        
        <div class="flex gap-2 items-end justify-between w-full h-52 border-b-2 border-gray-100 pb-1 mt-auto">       
          <div class="flex flex-col items-center flex-1 h-full justify-end group">
            <span class="text-[11px] font-bold text-gray-600 mb-1">{{ $stat['hired'] }}</span>
            <div class="bg-[#ed7d31] w-full max-w-[24px] rounded-t-sm transition-all" style="height: {{ ($stat['hired'] / $max) * 100 }}%; min-height: 4px;"></div>
          </div>
          <div class="flex flex-col items-center flex-1 h-full justify-end group">
            <span class="text-[11px] font-bold text-gray-600 mb-1">{{ $stat['graduate'] }}</span>
            <div class="bg-[#1f4e78] w-full max-w-[24px] rounded-t-sm transition-all" style="height: {{ ($stat['graduate'] / $max) * 100 }}%; min-height: 4px;"></div>
          </div>
          <div class="flex flex-col items-center flex-1 h-full justify-end group">
            <span class="text-[11px] font-bold text-gray-600 mb-1">{{ $stat['resign'] }}</span>
            <div class="bg-[#2e75b6] w-full max-w-[24px] rounded-t-sm transition-all" style="height: {{ ($stat['resign'] / $max) * 100 }}%; min-height: 4px;"></div>
          </div>
          <div class="flex flex-col items-center flex-1 h-full justify-end group">
            <span class="text-[11px] font-bold text-gray-600 mb-1">{{ $stat['failed'] }}</span>
            <div class="bg-[#70ad47] w-full max-w-[24px] rounded-t-sm transition-all" style="height: {{ ($stat['failed'] / $max) * 100 }}%; min-height: 4px;"></div>
          </div>
          <div class="flex flex-col items-center flex-1 h-full justify-end group">
            <span class="text-[11px] font-bold text-gray-600 mb-1">{{ $stat['active'] }}</span>
            <div class="bg-[#a9d18e] w-full max-w-[24px] rounded-t-sm transition-all" style="height: {{ ($stat['active'] / $max) * 100 }}%; min-height: 4px;"></div>
          </div>
        </div>

        <div class="flex justify-between w-full mt-2 text-[9px] text-center text-gray-500 font-bold">
          <div class="flex-1">Hired</div>
          <div class="flex-1">Graduated</div>
          <div class="flex-1">Resign</div>
          <div class="flex-1">Failed</div>
          <div class="flex-1">Active</div>
        </div>
      </div>
    </div>
    @endforeach
  </div>

  <div class="bg-[#197B40] rounded-xl px-5 py-2.5 shadow-sm w-full relative z-10">
    <form method="GET" action="{{ route('dashboard') }}" class="flex flex-row items-center justify-between w-full gap-4">
      
      <div class="flex items-center gap-6">
        <div class="flex items-center gap-2">
          <label class="text-[11px] font-bold text-white/90 uppercase whitespace-nowrap">Program:</label>
          <select name="program" class="bg-white text-gray-800 border-none rounded-md px-3 py-1.5 text-xs outline-none focus:ring-2 focus:ring-[#fba919] transition cursor-pointer">
            <option value="">All Programs</option>
            @foreach($programs as $program)
              <option value="{{ $program }}" {{ request('program') === $program ? 'selected' : '' }}>
                {{ $program }}
              </option>
            @endforeach
          </select>
        </div>
        
        <div class="h-6 w-px bg-white/30"></div>

        <div class="flex items-center gap-2 relative">
          <label class="text-[11px] font-bold text-white/90 uppercase whitespace-nowrap">Batch:</label>
          
          <details class="group">
            <summary class="bg-white text-gray-800 border-none rounded-md px-3 py-1.5 text-xs outline-none focus:ring-2 focus:ring-[#fba919] cursor-pointer list-none flex items-center justify-between gap-4 min-w-[120px] marker-hidden">
              <span>Select Batch</span>
              <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform group-open:rotate-180"><path d="m6 9 6 6 6-6"/></svg>
            </summary>
            
            <div class="absolute top-full mt-1 left-10 bg-white border border-gray-200 rounded-md shadow-lg p-3 flex flex-col gap-2 min-w-[150px] z-50 max-h-48 overflow-y-auto">
              @foreach($batches as $batch)
                <label class="flex items-center gap-2 text-xs text-gray-700 cursor-pointer hover:bg-gray-50 p-1 rounded transition">
                  <input type="checkbox" name="batch[]" value="{{ $batch }}" class="rounded text-[#197B40] focus:ring-[#197B40] w-3.5 h-3.5" {{ in_array($batch, request('batch', [])) ? 'checked' : '' }}> 
                  Batch {{ $batch }}
                </label>
              @endforeach
            </div>
          </details>
        </div>
      </div>
      
      <div>
        <button type="submit" class="bg-[#fba919] text-white px-6 py-1.5 rounded-md text-xs font-bold shadow-sm hover:bg-orange-500 transition whitespace-nowrap">
          Apply Filter
        </button>
      </div>
      
    </form>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    
    <div class="bg-white rounded-xl p-4 border border-gray-300 flex flex-col justify-center">
      <div class="flex items-center gap-2 mb-2">
        <div class="bg-gray-100 p-1.5 rounded-lg text-gray-600">
          <i data-lucide="target" class="w-4 h-4"></i>
        </div>
        <h3 class="text-gray-700 font-medium text-xs">Success Rate</h3>
      </div>
      <div class="bg-slate-50 rounded-xl p-3 flex flex-row items-center justify-between gap-2">
        <span class="text-2xl font-semibold text-gray-900">{{ $successRate }}%</span>
        <span class="text-[10px] text-gray-500 text-right leading-tight">
          {{ $graduate }} out of {{ $total }}<br>
          <span class="font-semibold text-gray-700">Graduated Trainees</span>
        </span>
      </div>
    </div>

    <div class="bg-white rounded-xl p-4 border border-gray-300 flex flex-col justify-center">
      <div class="flex items-center gap-2 mb-2">
        <div class="bg-gray-100 p-1.5 rounded-lg text-gray-600">
          <i data-lucide="users" class="w-4 h-4"></i>
        </div>
        <h3 class="text-gray-700 font-medium text-xs">Retention Rate</h3>
      </div>
      <div class="bg-slate-50 rounded-xl p-3 flex flex-row items-center justify-between gap-2">
        <span class="text-2xl font-semibold text-gray-900">{{ $retentionRate }}%</span>
        <span class="text-[10px] text-gray-500 text-right leading-tight">
          {{ $active }} out of {{ $total }}<br>
          <span class="font-semibold text-gray-700">Active Trainees</span>
        </span>
      </div>
    </div>

    <div class="bg-white rounded-xl p-4 border border-gray-300 flex flex-col justify-center">
      <div class="flex items-center gap-2 mb-2">
        <div class="bg-gray-100 p-1.5 rounded-lg text-gray-600">
          <i data-lucide="trending-up" class="w-4 h-4"></i>
        </div>
        <h3 class="text-gray-700 font-medium text-xs">Avg Success Rate</h3>
      </div>
      <div class="bg-slate-50 rounded-xl p-3 flex flex-row items-center justify-between gap-2">
        <span class="text-2xl font-semibold text-gray-900">{{ $avgSuccessRate }}%</span>
        <span class="text-[10px] text-gray-500 text-right leading-tight">
          {{ $graduate + $active }} out of {{ $total }}<br>
          <span class="font-semibold text-gray-700">Graduated / Active</span>
        </span>
      </div>
    </div>

  </div>

</div>
@endsection