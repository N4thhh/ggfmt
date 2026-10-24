@extends('layouts.app')

@section('content')

@if(session('success'))
<div class="mx-6 mt-6 bg-green-50 border border-green-200 text-green-700 text-sm font-semibold px-4 py-3 rounded-xl">
    {{ session('success') }}
</div>
@endif

<div class="mx-6 my-6 grid grid-cols-1 md:grid-cols-12 grid-rows-6 gap-4 items-stretch h-full min-h-[80vh]">

  <div class="col-start-1 col-span-1 md:col-start-1 md:col-span-12 row-span-1 bg-[#197B40] rounded-4xl p-8 md:p-10 shadow-md flex items-center justify-between border border-[#146032]">
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

  <div class="col-start-1 col-span-1 md:col-start-1 md:col-span-4 row-span-5 bg-white rounded-4xl shadow-md border border-gray-300 overflow-hidden flex flex-col h-150 md:h-auto">

    <div class="flex flex-wrap items-center gap-2 p-5 border-b-2 border-gray-200 shrink-0 bg-gray-50">
      <button id="btn-list-current" onclick="showList('current')" class="list-tab-btn px-4 py-2 rounded-lg font-bold text-xs transition-all duration-200 bg-[#fba919] text-white shadow-md flex-1">
        Current
      </button>
      <button id="btn-list-history" onclick="showList('history')" class="list-tab-btn px-4 py-2 rounded-lg font-bold text-xs transition-all duration-200 bg-gray-200 text-gray-700 hover:bg-gray-300 flex-1">
        History
      </button>
      @if(auth()->user()->role === 'admin' || auth()->user()->role === 'hr')
      <a href="#" onclick="openModal('modal-assign-mt'); return false;" class="p-2 rounded-lg bg-[#197B40] text-white hover:bg-[#146032] transition shrink-0" title="Assign MT">
          <i data-lucide="plus" class="w-4 h-4"></i>
      </a>
      @endif
    </div>

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
          @if(auth()->user()->role === 'admin' || auth()->user()->role === 'hr')
          <a href="#" onclick="openModal('modal-assign-mt'); return false;" class="flex flex-col items-center justify-center border-2 border-dashed border-gray-300 rounded-xl p-6 min-h-30 text-gray-400 hover:text-[#197B40] hover:border-[#197B40] hover:bg-[#197B40]/5 transition-all cursor-pointer group shadow-sm">
              <i data-lucide="plus" class="w-8 h-8 mb-2 group-hover:scale-110 transition-transform duration-200"></i>
              <span class="text-sm font-bold tracking-wide">Assign MT</span>
          </a>
          @else
          <p class="text-sm font-semibold text-gray-400 text-center py-6 italic">Belum ada MT yang dibimbing.</p>
          @endif
        @endforelse
      </div>
    </div>

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
              <p class="text-[10px] text-gray-400 font-semibold">
                  {{ \Carbon\Carbon::parse($coachHistory->started_at)->format('d M Y') }}
                  &ndash;
                  {{ \Carbon\Carbon::parse($coachHistory->ended_at)->format('d M Y') }}
              </p>
            </div>
            <i data-lucide="chevron-right" class="w-4 h-4 text-gray-500 group-hover:text-[#197B40] transition-colors"></i>
          </div>
        @empty
          <p class="text-sm font-semibold text-gray-500 text-center py-6 italic">No history records.</p>
        @endforelse
      </div>
    </div>
  </div>

  <div class="col-start-1 col-span-1 md:col-start-5 md:col-span-8 row-span-5 bg-white rounded-4xl shadow-md border border-gray-300 overflow-hidden flex flex-col h-150 md:h-auto">

    @php
        $hasCurrentMt = $coach->coachHistory()->whereNull('ended_at')->exists();
        $isOwnCoachProfile = auth()->check()
            && auth()->user()->role === 'coach'
            && auth()->user()->coach
            && auth()->user()->coach->id === $coach->id;
    @endphp

    <div id="initial-notes-state" class="flex flex-col h-full items-center justify-center p-6 text-gray-500 flex-1 bg-gray-100">
        @if(!$hasCurrentMt)
            <i data-lucide="user-x" class="w-16 h-16 mb-4 opacity-40"></i>
            <p class="text-base font-bold tracking-wide text-center">Coach ini belum memiliki Management Trainee saat ini.</p>
        @else
            <i data-lucide="inbox" class="w-16 h-16 mb-4 opacity-40"></i>
            <p class="text-base font-bold tracking-wide">Select a Management Trainee to view notes</p>
        @endif
    </div>

    @foreach ($coach->coachHistory()->get() as $coachHistory)
      @php
          $isCurrent = is_null($coachHistory->ended_at);
          $canEdit = $isOwnCoachProfile && $isCurrent;

          // penting: notes di-scope per PERIODE coaching ini (coach_history_id),
          // bukan per MT doang -- biar periode lama & baru tidak ketuker
          $notes = $coachHistory->coachNotes()->orderByDesc('created_at')->get();
      @endphp
      <div class="notes-panel flex flex-col h-full w-full" style="display: none;" id="coach-history-{{ $coachHistory->id }}">

        <div class="bg-[#197B40] px-6 py-4 flex flex-col md:flex-row justify-between items-start md:items-center shrink-0 gap-3 border-b border-[#146032]">
          <div class="min-w-0">
            <h3 class="text-white font-extrabold text-base md:text-lg truncate tracking-wide">Notes: {{ $coachHistory->managementTrainee->user->name }}</h3>
            @unless($isCurrent)
                <p class="text-xs text-white/70 font-semibold">
                    Periode: {{ \Carbon\Carbon::parse($coachHistory->started_at)->format('d M Y') }}
                    &ndash; {{ \Carbon\Carbon::parse($coachHistory->ended_at)->format('d M Y') }}
                </p>
            @endunless
          </div>

          <div class="flex items-center gap-2 shrink-0">
            @if($canEdit)
              <button type="button" onclick="newNote('{{ $coachHistory->id }}')" class="bg-white/20 hover:bg-[#fba919] text-white text-xs font-bold px-3 py-1.5 rounded-lg transition-colors flex items-center gap-1">
                  <i data-lucide="plus" class="w-3.5 h-3.5"></i> Note Baru
              </button>
            @endif
            <div class="flex items-center gap-2 bg-white/10 p-1.5 rounded-xl">
              <label for="note-select-{{ $coachHistory->id }}" class="text-xs text-white font-bold ml-1">Date:</label>
              <select id="note-select-{{ $coachHistory->id }}"
                      onchange="loadNote('{{ $coachHistory->id }}')"
                      class="bg-white border-2 border-gray-300 text-gray-900 text-sm rounded-lg px-3 py-1.5 outline-none cursor-pointer font-bold shadow-sm">
                  @forelse ($notes as $coachNote)
                      <option value="{{ $coachNote->id }}" data-comments="{{ htmlspecialchars($coachNote->comments) }}">
                          {{ \Carbon\Carbon::parse($coachNote->created_at)->format('d M Y - H:i') }}
                      </option>
                  @empty
                      <option value="">No Data</option>
                  @endforelse
              </select>
            </div>
          </div>
        </div>

        <div class="flex-1 flex flex-col p-6 bg-gray-200 shadow-inner min-h-0">
          @if($canEdit)
              <form id="note-form-{{ $coachHistory->id }}" method="POST"
                    action="{{ $notes->isNotEmpty() ? '/coach-notes/' . $notes->first()->id : route('coach.storeNote', $coachHistory->managementTrainee) }}"
                    data-store-url="{{ route('coach.storeNote', $coachHistory->managementTrainee) }}"
                    class="flex-1 flex flex-col min-h-0">
                  @csrf
                  <input type="hidden" id="note-method-{{ $coachHistory->id }}" name="_method" value="{{ $notes->isNotEmpty() ? 'PATCH' : '' }}">

                  <textarea id="note-textarea-{{ $coachHistory->id }}" name="comments" required
                            class="flex-1 w-full bg-white p-6 rounded-xl border border-gray-300 shadow-md text-gray-800 text-base leading-relaxed resize-none focus:outline-none focus:border-[#197B40] transition-colors"
                            placeholder="Tulis catatan coaching untuk MT ini...">{{ $notes->first()->comments ?? '' }}</textarea>

                  <button type="submit" id="note-submit-{{ $coachHistory->id }}" class="mt-4 self-end bg-[#197B40] hover:bg-[#146032] text-white text-sm font-bold px-6 py-2.5 rounded-xl transition-colors shadow-sm shrink-0">
                      Simpan Note
                  </button>
              </form>
          @else
              {{-- read-only: admin/hr, atau coach tapi periode sudah berakhir --}}
              @if($notes->isNotEmpty())
                  <select id="note-view-select-{{ $coachHistory->id }}" onchange="showViewNote('{{ $coachHistory->id }}')" class="mb-3 bg-white border-2 border-gray-300 text-gray-900 text-sm rounded-lg px-3 py-1.5 outline-none cursor-pointer font-bold shadow-sm self-start">
                      @foreach ($notes as $coachNote)
                          <option value="{{ $coachNote->id }}" data-comments="{{ htmlspecialchars($coachNote->comments) }}">
                              {{ \Carbon\Carbon::parse($coachNote->created_at)->format('d M Y - H:i') }}
                          </option>
                      @endforeach
                  </select>
                  <div id="note-view-{{ $coachHistory->id }}" class="flex-1 bg-white p-6 rounded-xl border border-gray-300 shadow-md text-gray-800 text-base whitespace-pre-line leading-relaxed overflow-y-auto custom-scrollbar">
                      {{ $notes->first()->comments }}
                  </div>
              @else
                  <div class="flex-1 flex items-center justify-center bg-white p-6 rounded-xl border border-gray-300 shadow-md text-gray-500 italic text-base font-medium">
                      No coaching notes available for this period.
                  </div>
              @endif

              @if($isOwnCoachProfile && !$isCurrent)
                  <div class="bg-gray-50 border border-gray-200 text-gray-400 text-xs font-semibold px-4 py-3 rounded-xl text-center shrink-0 mt-4">
                      MT ini sudah tidak lagi menjadi bimbingan Anda, tidak bisa mengubah note.
                  </div>
              @endif
          @endif
        </div>

      </div>
    @endforeach

  </div>
</div>

@include('coach.modal-assignmt')

<script>
    function showList(list) {
        document.querySelectorAll('.tab-content').forEach(el => {
            el.style.display = 'none';
        });
        document.getElementById(list).style.display = 'block';

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
            loadNote(historyId);
            showViewNote(historyId);
        }
    }

    // mode edit/create (coach sendiri, periode masih aktif)
    function loadNote(historyId) {
        const select = document.getElementById('note-select-' + historyId);
        const textarea = document.getElementById('note-textarea-' + historyId);
        const methodField = document.getElementById('note-method-' + historyId);
        const form = document.getElementById('note-form-' + historyId);
        const submitBtn = document.getElementById('note-submit-' + historyId);

        if (!select || !textarea || !form) return;

        const selectedOption = select.options[select.selectedIndex];
        if (!selectedOption || !selectedOption.value) return;

        const noteId = selectedOption.value;
        const comments = selectedOption.getAttribute('data-comments') || '';

        textarea.value = comments;
        form.action = '/coach-notes/' + noteId;
        methodField.value = 'PATCH';
        submitBtn.textContent = 'Update Note';
    }

    // tombol "+ Note Baru" -- reset textarea & form ke mode create
    function newNote(historyId) {
        const textarea = document.getElementById('note-textarea-' + historyId);
        const methodField = document.getElementById('note-method-' + historyId);
        const form = document.getElementById('note-form-' + historyId);
        const submitBtn = document.getElementById('note-submit-' + historyId);
        const select = document.getElementById('note-select-' + historyId);

        if (!textarea || !form) return;

        textarea.value = '';
        form.action = form.dataset.storeUrl;
        methodField.value = '';
        submitBtn.textContent = 'Simpan Note';
        if (select) select.selectedIndex = -1;
        textarea.focus();
    }

    // mode read-only (admin/hr atau periode sudah berakhir)
    function showViewNote(historyId) {
        const select = document.getElementById('note-view-select-' + historyId);
        const viewDiv = document.getElementById('note-view-' + historyId);
        if (!select || !viewDiv) return;

        const selectedOption = select.options[select.selectedIndex];
        if (selectedOption) {
            viewDiv.textContent = selectedOption.getAttribute('data-comments') || '';
        }
    }

    function openModal(id) {
        const el = document.getElementById(id);
        el.classList.remove('hidden');
        el.style.display = 'flex';
        el.style.alignItems = 'center';
        el.style.justifyContent = 'center';
    }

    function closeModal(id) {
        const el = document.getElementById(id);
        el.classList.add('hidden');
        el.style.display = 'none';
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