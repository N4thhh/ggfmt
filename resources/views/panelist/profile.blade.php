@extends('layouts.app')

@section('content')
<div class="mx-6 my-6 flex flex-col gap-4 h-full min-h-[80vh]">

  <div class="bg-[#197B40] rounded-4xl p-8 md:p-10 shadow-md flex items-center justify-between border border-[#146032] shrink-0">
    <div class="flex flex-row items-center gap-6">
      <img src="{{ asset('Pina - Info.png') }}" alt="Pina Info" class="w-20 md:w-24 drop-shadow-md">
      
      <div class="space-y-0.5 text-left">
        <p class="text-xs md:text-sm font-bold text-white/80 uppercase tracking-widest">PANELIST</p>
        <p class="text-2xl md:text-3xl font-black text-white">{{ $panelist->user->name }}</p>
      </div>
    </div>
  </div>

  <div class="bg-white rounded-4xl shadow-md border border-gray-300 overflow-hidden flex flex-col flex-1">
    
    <div class="flex flex-wrap gap-2 p-5 border-b-2 border-gray-200 shrink-0 bg-gray-50">
      <button id="btn-filter-pending" onclick="showFilter('pending')" class="filter-tab-btn px-6 py-2 rounded-lg font-bold text-sm transition-all duration-200 bg-[#fba919] text-white shadow-md flex-1 md:flex-none">
        Pending
      </button>
      <button id="btn-filter-scored" onclick="showFilter('scored')" class="filter-tab-btn px-6 py-2 rounded-lg font-bold text-sm transition-all duration-200 bg-gray-200 text-gray-700 hover:bg-gray-300 flex-1 md:flex-none">
        Scored
      </button>
    </div>

    <div class="flex-1 overflow-y-auto custom-scrollbar p-6 bg-gray-100/50">
      
      <div id="pending" class="tab-content" style="display: block;">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 items-stretch">
          
          @foreach ($pendingAccess as $access)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 hover:shadow-lg transition-all flex flex-col group h-full overflow-hidden">
              
              <div class="bg-[#197B40] p-5 flex flex-col gap-2 relative overflow-hidden shrink-0">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-white/10 rounded-full blur-xl group-hover:scale-125 transition-transform duration-500"></div>
                
                <h4 class="font-black text-white text-xl truncate z-10" title="{{ $access->assignment->managementTrainee->user->name }}">
                  {{ $access->assignment->managementTrainee->user->name }}
                </h4>
                <span class="self-start inline-block bg-[#fba919] text-white text-[10px] font-extrabold px-2.5 py-1 rounded-md uppercase tracking-widest shadow-sm z-10">
                  {{ $access->assignment->phase }}
                </span>
              </div>
              
              <div class="p-5 flex flex-col flex-1">
                <p class="text-sm font-bold text-gray-700 mb-3 line-clamp-2" title="{{ $access->assignment->title }}">
                  {{ $access->assignment->title }}
                </p>
                
                <p class="text-xs font-semibold text-gray-500 mb-6 flex items-center gap-1.5">
                  <i data-lucide="clock" class="w-4 h-4 text-[#fba919]"></i> 
                  {{ $access->assignment->uploaded_at ?? 'Not uploaded yet' }}
                </p>
                
                <div class="mt-auto pt-4 border-t border-gray-100">
                  <a href="{{ route('scoring.adminShow', $access->assignment) }}" class="flex items-center justify-center w-full bg-[#197B40] hover:bg-[#146032] text-white text-sm font-extrabold py-2.5 rounded-xl transition-all shadow-sm gap-2">
                    <i data-lucide="edit-3" class="w-4 h-4"></i> Score Assignment
                  </a>
                </div>
              </div>
            </div>
          @endforeach

          @if(auth()->user()->role === 'admin' || auth()->user()->role === 'hr')
            <div class="h-full">
                <a href="#" class="flex flex-col items-center justify-center p-6 text-gray-400 bg-white rounded-2xl border-2 border-dashed border-gray-300 hover:text-[#197B40] hover:border-[#197B40] hover:bg-[#197B40]/5 transition-all cursor-pointer group shadow-sm h-full min-h-62.5">
                    <i data-lucide="plus" class="w-10 h-10 mb-3 group-hover:scale-110 transition-transform duration-200"></i>
                    <span class="text-sm font-bold tracking-wide text-center">Assign MT Assignment</span>
                </a>
            </div>
          @elseif($pendingAccess->isEmpty())
            <div class="col-span-full flex flex-col items-center justify-center p-10 text-gray-400 bg-white rounded-2xl border border-dashed border-gray-300 min-h-50">
              <i data-lucide="check-circle" class="w-12 h-12 mb-3 opacity-40"></i>
              <p class="text-base font-bold tracking-wide">All caught up! No pending assignments.</p>
            </div>
          @endif

        </div>
      </div>


      <div id="scored" class="tab-content" style="display: none;">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 items-stretch">
          @forelse ($scoredAccess as $access)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 hover:shadow-lg transition-all flex flex-col group h-full overflow-hidden">
              
              <div class="bg-[#197B40] p-5 flex flex-col gap-2 relative overflow-hidden shrink-0">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-white/10 rounded-full blur-xl group-hover:scale-125 transition-transform duration-500"></div>
                
                <h4 class="font-black text-white text-xl truncate z-10" title="{{ $access->assignment->managementTrainee->user->name }}">
                  {{ $access->assignment->managementTrainee->user->name }}
                </h4>
                <span class="self-start inline-block bg-[#fba919] text-white text-[10px] font-extrabold px-2.5 py-1 rounded-md uppercase tracking-widest shadow-sm z-10">
                  {{ $access->assignment->phase }}
                </span>
              </div>
              
              <div class="p-5 flex flex-col flex-1">
                <p class="text-sm font-bold text-gray-700 mb-3 line-clamp-2" title="{{ $access->assignment->title }}">
                  {{ $access->assignment->title }}
                </p>
                
                <p class="text-xs font-semibold text-gray-500 mb-6 flex items-center gap-1.5">
                  <i data-lucide="check-circle" class="w-4 h-4 text-[#197B40]"></i> 
                  Uploaded: {{ $access->assignment->uploaded_at ?? 'N/A' }}
                </p>
                
                <div class="mt-auto pt-4 border-t border-gray-100">
                  <a href="{{ route('mt.show', $access->assignment->managementTrainee) . '?phase=' . urlencode($access->assignment->phase) }}" class="flex items-center justify-center w-full bg-[#fba919]/10 hover:bg-[#fba919] text-[#c77f00] hover:text-white text-sm font-extrabold py-2.5 rounded-xl transition-all shadow-sm gap-2">
                    <i data-lucide="eye" class="w-4 h-4"></i> View Details
                  </a>
                </div>
              </div>
            </div>
          @empty
            <div class="col-span-full flex flex-col items-center justify-center p-10 text-gray-400 bg-white rounded-2xl border border-dashed border-gray-300 min-h-50">
              <i data-lucide="inbox" class="w-12 h-12 mb-3 opacity-40"></i>
              <p class="text-base font-bold tracking-wide">No scored assignments yet.</p>
            </div>
          @endforelse
        </div>
      </div>

    </div>
  </div>
</div>

<script>
    function showFilter(filter) {
        document.querySelectorAll('.tab-content').forEach(el => {
            el.style.display = 'none';
        });
        
        document.getElementById(filter).style.display = 'block';

        document.querySelectorAll('.filter-tab-btn').forEach(btn => {
            btn.classList.remove('bg-[#fba919]', 'text-white', 'shadow-md');
            btn.classList.add('bg-gray-200', 'text-gray-700', 'hover:bg-gray-300');
        });
        
        let activeBtn = document.getElementById('btn-filter-' + filter);
        if(activeBtn) {
            activeBtn.classList.remove('bg-gray-200', 'text-gray-700', 'hover:bg-gray-300');
            activeBtn.classList.add('bg-[#fba919]', 'text-white', 'shadow-md');
        }
    }
</script>

<style>
.custom-scrollbar::-webkit-scrollbar {
    width: 8px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent; 
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #94a3b8; 
}
</style>
@endsection