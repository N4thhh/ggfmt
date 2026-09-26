@extends('layouts.app')
@section('content')
<div class="grid grid-cols-3 md:grid-cols-3 grid-rows-4 md:grid-rows-4 gap-2 md:gap-2 m-4">
  
  {{-- Row 1: Count cards --}}
  <div class="col-start-1 row-start-1 md:col-start-1 md:row-start-1 md:col-span-1 md:row-span-1 bg-[#197B40] rounded-md p-6 text-white">
    <p class="text-sm font-thin">Management Trainees</p>
    <p class="text-4xl font-black">{{ $total }}</p>
  </div>
  <div class="col-start-2 row-start-1 md:col-start-2 md:row-start-1 md:col-span-1 md:row-span-1 bg-[#197B40] rounded-md p-6 text-white">
    <p class="text-sm font-thin">Coaches</p>
    <p class="text-4xl font-black">{{ $totalCoaches }}</p>
  </div>
  <div class="col-start-3 row-start-1 md:col-start-3 md:row-start-1 md:col-span-1 md:row-span-1 bg-[#197B40] rounded-md p-6 text-white">
    <p class="text-sm font-thin">Panelists</p>
    <p class="text-4xl font-black">{{ $totalPanelists }}</p>
  </div>

  {{-- Rate cards stacked in column 3, rows 2-4 --}}
  <div class="col-start-1 row-start-4 md:col-start-3 md:row-start-2 md:col-span-1 md:row-span-1 bg-white rounded-md p-6 shadow">
    <p class="text-sm font-semibold text-gray-500">Success Rate</p>
    <p class="text-4xl font-black">{{ $successRate }}%</p>
    <p class="text-xs text-gray-500 mt-2">{{ $graduate }} out of {{ $total }} MTs graduated</p>
  </div>
  <div class="col-start-2 row-start-4 md:col-start-3 md:row-start-3 md:col-span-1 md:row-span-1 bg-white rounded-md p-6 shadow">
    <p class="text-sm font-semibold text-gray-500">Retention Rate</p>
    <p class="text-4xl font-black">{{ $retentionRate }}%</p>
    <p class="text-xs text-gray-500 mt-2">{{ $active }} out of {{ $total }} MTs still active</p>
  </div>
  <div class="col-start-3 row-start-4 md:col-start-3 md:row-start-4 md:col-span-1 md:row-span-1 bg-white rounded-md p-6 shadow">
    <p class="text-sm font-semibold text-gray-500">Average Success Rate</p>
    <p class="text-4xl font-black">{{ $avgSuccessRate }}%</p>
    <p class="text-xs text-gray-500 mt-2">{{ $graduate + $active }} out of {{ $total }} MTs graduated or active</p>
  </div>

  {{-- Big graph div: column 1-2, rows 2-4 --}}
  <div class="col-start-1 row-start-2 col-span-3 row-span-2 md:col-start-1 md:row-start-2 md:col-span-2 md:row-span-3 bg-white rounded-md p-6 shadow">
    
    {{-- Filter form inside graph div --}}
    <form method="GET" action="{{ route('dashboard') }}" class="flex gap-6 items-start mb-6">
      <div>
        <label class="block text-xs font-semibold mb-1">Program</label>
        <select name="program" class="border rounded p-1 text-sm">
          <option value="">All</option>
          @foreach($programs as $program)
            <option value="{{ $program }}" {{ request('program') === $program ? 'selected' : '' }}>
              {{ $program }}
            </option>
          @endforeach
        </select>
      </div>
      <div>
        <label class="block text-xs font-semibold mb-1">Batch</label>
        <div class="flex flex-wrap gap-2">
          @foreach($batches as $batch)
            <label class="flex items-center gap-1 text-xs">
              <input type="checkbox" name="batch[]" value="{{ $batch }}"
                {{ in_array($batch, request('batch', [])) ? 'checked' : '' }}>
              {{ $batch }}
            </label>
          @endforeach
        </div>
      </div>
      <div class="self-end">
        <button type="submit" class="bg-[#197B40] text-white px-3 py-1 rounded text-sm font-semibold">Apply</button>
      </div>
    </form>

    {{-- Chart --}}
    <p class="font-bold text-lg mb-4">MT Pipeline</p>
    <div class="flex items-end gap-6 h-48">
      <div class="flex flex-col items-center">
        <p class="font-bold">{{ $total }}</p>
        <div class="bg-[#FF9A02] w-16" style="height: {{ $total > 0 ? ($total / $total) * 160 : 0 }}px"></div>
        <p class="text-xs mt-2">Hired</p>
      </div>
      <div class="flex flex-col items-center">
        <p class="font-bold">{{ $graduate }}</p>
        <div class="bg-[#197B40] w-16" style="height: {{ $total > 0 ? ($graduate / $total) * 160 : 0 }}px"></div>
        <p class="text-xs mt-2">Graduate</p>
      </div>
      <div class="flex flex-col items-center">
        <p class="font-bold">{{ $withdraw }}</p>
        <div class="bg-yellow-400 w-16" style="height: {{ $total > 0 ? ($withdraw / $total) * 160 : 0 }}px"></div>
        <p class="text-xs mt-2">Withdraw</p>
      </div>
      <div class="flex flex-col items-center">
        <p class="font-bold">{{ $failed }}</p>
        <div class="bg-red-500 w-16" style="height: {{ $total > 0 ? ($failed / $total) * 160 : 0 }}px"></div>
        <p class="text-xs mt-2">Failed</p>
      </div>
      <div class="flex flex-col items-center">
        <p class="font-bold">{{ $active }}</p>
        <div class="bg-blue-500 w-16" style="height: {{ $total > 0 ? ($active / $total) * 160 : 0 }}px"></div>
        <p class="text-xs mt-2">Active</p>
      </div>
    </div>

  </div>

</div>
@endsection