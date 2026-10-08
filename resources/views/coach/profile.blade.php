@extends('layouts.app')

@section('content')
<div class="mx-6 my-6 grid grid-cols-1 md:grid-cols-12 grid-rows-6 gap-4 items-stretch h-full min-h-[80vh]">
  
  <!-- ========================================== -->
  <!-- 1. HEADER COACH (Atas, Lebar Penuh)        -->
  <!-- ========================================== -->
  <div class="col-start-1 col-span-1 md:col-start-1 md:col-span-12 row-span-1 bg-[#197B40] rounded-[2rem] p-8 md:p-10 shadow-md flex items-center justify-between border border-[#146032]">
    <div class="flex flex-row items-center gap-6">
      <img src="{{ asset('Pina - Info.png') }}" alt="Pina Info" class="w-20 md:w-24 drop-shadow-md">
      
      <div class="space-y-0.5 text-left">
        <p class="text-xs md:text-sm font-bold text-white/80 uppercase tracking-widest">COACH</p>
        <p class="text-2xl md:text-3xl font-black text-white">{{ $coach->user->name }}</p>
      </div>
    </div>
    <div class="text-right">
      <p class="font-black text-white text-3xl md:text-5xl drop-shadow-sm">
        {{ count($coach->coachHistory()->where('ended_at', null)->get()) }}
      </p>
      <p class="text-white/90 text-sm md:text-base font-medium tracking-wide uppercase"># of MTs</p>
    </div>
  </div>
  
  <!-- ========================================== -->
  <!-- 2. DAFTAR MT (Kiri, Current/History)       -->
  <!-- ========================================== -->
  <div class="col-start-1 col-span-1 md:col-start-1 md:col-span-4 row-span-5 bg-white rounded-[2rem] shadow-md border border-gray-300 overflow-hidden flex flex-col h-[600px] md:h-auto">
    
    <!-- Tab Buttons -->
    <div class="flex flex-wrap gap-2 p-5 border-b-2 border-gray-200 shrink-0 bg-gray-50">
      <button id="btn-list-current" onclick="showList('current')" class="list-tab-btn px-4 py-2 rounded-lg font-bold text-xs transition-all duration-200 bg-[#fba919] text-white shadow-md flex-1">
        Current
      </button>
      <button id="btn-list-history" onclick="showList('history')" class="list-tab-btn px-4 py-2 rounded-lg font-bold text-xs transition-all duration-200 bg-gray-200 text-gray-700 hover:bg-gray-300 flex-1">
        History
      </button>
    </div>

    <!-- Tab Content: CURRENT -->
    <div id="current" class="tab-content flex-1 overflow-y-auto custom-scrollbar p-3" style="display: block;">
      <div class="flex flex-col gap-3 h-full">
        @forelse ($coach->coachHistory()->where('ended_at', null)->get() as $coachHistory)
          <div class="flex flex-row items-center gap-4 p-3 rounded-xl bg-gray-50 border border-gray-200 hover:border-[#197B40] hover:bg-[#197B40]/5 cursor-pointer transition-all group shadow-sm" onclick="showMtNotes('{{ $coachHistory->id }}')">
            @if($coachHistory->managementTrainee->profile_picture)
              <img src="{{ asset('storage/' . $coachHistory->managementTrainee->profile_picture) }}" alt="Profile" class="w-10 h-10 rounded-full object-cover shadow-sm group-hover:scale-105 transition-transform">
            @else
              <div class="w-10 h-10 bg-[#fba919] flex items-center justify-center text-white font-bold text-sm rounded-full shadow-sm shrink-0 group-hover:scale-105 transition-transform">
                  {{ strtoupper(substr($coachHistory->managementTrainee->user->name, 0, 1)) }} 
              </div>
            @endif
            <div class="flex-1 min-w-0">
              <p class="font-bold text-gray-900 text-sm truncate group-hover:text-[#197B40] transition-colors"> {{ $coachHistory->managementTrainee->user->name }}</p>
            </div>
            <i data-lucide="chevron-right" class="w-4 h-4 text-gray-500 group-hover:text-[#197B40] transition-colors"></i>
          </div>
        @empty
          <!-- TOMBOL ASSIGN MT PENGGANTI PLACEHOLDER -->
          <a href="#" class="flex flex-col items-center justify-center border-2 border-dashed border-gray-300 rounded-xl p-6 min-h-[120px] text-gray-400 hover:text-[#197B40] hover:border-[#197B40] hover:bg-[#197B40]/5 transition-all cursor-pointer group shadow-sm">
              <i data-lucide="plus" class="w-8 h-8 mb-2 group-hover:scale-110 transition-transform duration-200"></i>
              <span class="text-sm font-bold tracking-wide">Assign MT</span>
          </a>
        @endforelse
      </div>
    </div>

    <!-- Tab Content: HISTORY -->
    <div id="history" class="tab-content flex-1 overflow-y-auto custom-scrollbar p-3" style="display: none;">
      <div class="flex flex-col gap-3">
        @forelse ($coach->coachHistory()->where('ended_at', '!=', null)->get() as $coachHistory)
          <div class="flex flex-row items-center gap-4 p-3 rounded-xl bg-gray-50 border border-gray-200 hover:border-[#197B40] hover:bg-[#197B40]/5 cursor-pointer transition-all group shadow-sm" onclick="showMtNotes('{{ $coachHistory->id }}')">
            @if($coachHistory->managementTrainee->profile_picture)
              <img src="{{ asset('storage/' . $coachHistory->managementTrainee->profile_picture) }}" alt="Profile" class="w-10 h-10 rounded-full object-cover shadow-sm grayscale group-hover:grayscale-0 transition-all">
            @else
              <div class="w-10 h-10 bg-gray-500 flex items-center justify-center text-white font-bold text-sm rounded-full shadow-sm shrink-0 group-hover:bg-[#fba919] transition-colors">
                  {{ strtoupper(substr($coachHistory->managementTrainee->user->name, 0, 1)) }} 
              </div>
            @endif
            <div class="flex-1 min-w-0">
              <p class="font-bold text-gray-700 text-sm truncate group-hover:text-[#197B40] transition-colors"> {{ $coachHistory->managementTrainee->user->name }}</p>
            </div>
            <i data-lucide="chevron-right" class="w-4 h-4 text-gray-500 group-hover:text-[#197B40] transition-colors"></i>
          </div>
        @empty
          <p class="text-sm font-semibold text-gray-500 text-center py-6 italic">No history records.</p>
        @endforelse
      </div>
    </div>
  </div>
  
  <!-- ========================================== -->
  <!-- 3. COACHING NOTES PANNEL (Kanan)           -->
  <!-- ========================================== -->
  <div class="col-start-1 col-span-1 md:col-start-5 md:col-span-8 row-span-5 bg-white rounded-[2rem] shadow-md border border-gray-300 overflow-hidden flex flex-col h-[600px] md:h-auto">
    
    <div id="initial-notes-state" class="flex flex-col h-full items-center justify-center p-6 text-gray-500 flex-1 bg-gray-100">
        <i data-lucide="inbox" class="w-16 h-16 mb-4 opacity-40"></i>
        <p class="text-base font-bold tracking-wide">Select a Management Trainee to view notes</p>
    </div>

    @foreach ($coach->coachHistory()->get() as $coachHistory)
      <div class="notes-panel flex flex-col h-full w-full" style="display: none;" id="coach-history-{{ $coachHistory->id }}">

        <div class="bg-[#197B40] px-6 py-4 flex flex-col md:flex-row justify-between items-start md:items-center shrink-0 gap-3 border-b border-[#146032]">
          <div class="min-w-0">
            <h3 class="text-white font-extrabold text-base md:text-lg truncate tracking-wide">Notes: {{ $coachHistory->managementTrainee->user->name }}</h3>
          </div>
          
          <div class="flex items-center gap-2 shrink-0 bg-white/10 p-1.5 rounded-xl">
            <label for="coach-date-select-{{ $coachHistory->id }}" class="text-xs text-white font-bold ml-1">Date:</label>
            @if($coachHistory->managementTrainee->coachNote->isNotEmpty())
              <select id="coach-date-select-{{ $coachHistory->id }}" onchange="showSpecificNote('{{ $coachHistory->id }}', this.value)" class="bg-white border-2 border-gray-300 text-gray-900 text-sm rounded-lg px-3 py-1.5 outline-none cursor-pointer font-bold shadow-sm">
                  @foreach ($coachHistory->managementTrainee->coachNote as $coachNote)
                      <option value="{{ $coachNote->id }}">
                          {{ \Carbon\Carbon::parse($coachNote->created_at)->format('d M Y - H:i') }}
                      </option>
                  @endforeach
              </select>
            @else
              <span class="bg-white/20 text-white text-sm px-3 py-1.5 rounded-lg font-bold">No Data</span>
            @endif
          </div>
        </div>

        <div class="flex-1 flex flex-col p-6 bg-gray-200 shadow-inner min-h-0">
          @forelse ($coachHistory->managementTrainee->coachNote as $index => $coachNote)
            <div id="note-{{ $coachHistory->id }}-{{ $coachNote->id }}" class="note-content-{{ $coachHistory->id }} flex-1 overflow-y-auto custom-scrollbar bg-white p-6 rounded-xl border border-gray-300 shadow-md text-gray-800 text-base whitespace-pre-line leading-relaxed" style="display: {{ $index === 0 ? 'block' : 'none' }};">
                {{ $coachNote->comments }}
            </div>
          @empty
            <div class="flex-1 flex items-center justify-center bg-white p-6 rounded-xl border border-gray-300 shadow-md text-gray-500 italic text-base font-medium">
                No coaching notes available for this trainee.
            </div>
          @endforelse
        </div>

      </div>
    @endforeach

  </div>
</div>

<script>
    function showList(list) {
        document.querySelectorAll('.tab-content').forEach(el => {
            el.style.display = 'none';
        });
        document.getElementById(list).style.display = 'block';

        // Update warna tab
        document.querySelectorAll('.list-tab-btn').forEach(btn => {
            btn.classList.remove('bg-[#fba919]', 'text-white', 'shadow-md');
            btn.classList.add('bg-gray-200', 'text-gray-700', 'hover:bg-gray-300');
        });
        
        let activeBtn = document.getElementById('btn-list-' + list);
        if(activeBtn) {
            activeBtn.classList.remove('bg-gray-200', 'text-gray-700', 'hover:bg-gray-300');
            activeBtn.classList.add('bg-[#fba919]', 'text-white', 'shadow-md');
        }
    }

    function showMtNotes(historyId) {
        let initialState = document.getElementById('initial-notes-state');
        if(initialState) initialState.style.display = 'none';

        document.querySelectorAll('.notes-panel').forEach(el => {
            el.style.display = 'none';
            el.classList.remove('flex');
        });
        
        let targetPanel = document.getElementById('coach-history-' + historyId);
        if(targetPanel) {
            targetPanel.style.display = 'flex';
            
            let selectBox = document.getElementById('coach-date-select-' + historyId);
            if(selectBox && selectBox.value) {
                showSpecificNote(historyId, selectBox.value);
            }
        }
    }

    function showSpecificNote(historyId, noteId) {
        document.querySelectorAll('.note-content-' + historyId).forEach(el => {
            el.style.display = 'none';
        });
        
        let targetNote = document.getElementById('note-' + historyId + '-' + noteId);
        if(targetNote) {
            targetNote.style.display = 'block';
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