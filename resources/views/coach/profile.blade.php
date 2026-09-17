@extends('layouts.app')
@section('content')
<div class="grid grid-cols-3 md:grid-cols-5 grid-rows-6 md:grid-rows-6 gap-2 md:gap-2 m-4">
  <div class="col-start-1 row-start-1 col-span-3 md:col-start-1 md:row-start-1 md:col-span-5 md:row-span-2 bg-[#197B40] rounded-md p-10">
    <div class="flex flex-row items-center justify-between w-full">
        <div class="flex flex-row items-center gap-6 -mt-5 -mb-5 -ml-4">
        <img src="{{ asset('Pina - Info.png') }}" alt="Pina Info" class="w-24">
        
        <div class="space-y-0.5 text-left">
          <p class="text-xs font-thin text-white">COACH</p>
          <p class="text-lg font-black text-white">{{$coach->user->name}}</p>
        </div>
      </div>
      <div>
        <p class="font-bold text-white text-2xl text-right">
          {{ count($coach->coachHistory()->where('ended_at', null)->get() )}}
        </p>
        <p class="text-white">#of MTs</p>
      </div>
    </div>
  </div>
  
  <div class="col-start-1 row-start-2 col-span-3 md:col-start-1 md:row-start-3 md:col-span-1 md:row-span-4 bg-gray-300 rounded-md p-10">
    <div class="flex flex-col gap-4">
      <div class="tab-buttons">
        <button onclick="showList('current')">Current</button>
        <button onclick="showList('history')">History</button>
      </div>

      <div id="current" class="tab-content" style="display: block;">
        @foreach ($coach->coachHistory()->where('ended_at', null)->get() as $coachHistory)
          <div class="flex flex-row gap-4" onclick="showMtNotes('{{ $coachHistory->id }}')">
            @if($coachHistory->managementTrainee->profile_picture)
              <img src="{{ asset('storage/' . $coachHistory->managementTrainee->profile_picture) }}" alt="Profile" class="avatar-circle">
            @else
              <div class="w-8 h-8 bg-[#FF9A02] flex items-center justify-center font-bold text-sm rounded-full shrink-0">
                  {{ strtoupper(substr($coachHistory->managementTrainee->user->name, 0, 1)) }} 
              </div>
              @endif
              <div>
                <p> {{ $coachHistory->managementTrainee->user->name }}</p>
              </div>
          </div>
        @endforeach
      </div>

      <div id="history" class="tab-content" style="display: none;">
        @foreach ($coach->coachHistory()->where('ended_at', '!=', null)->get() as $coachHistory)
          <div class="flex flex-row gap-4" onclick="showMtNotes('{{ $coachHistory->id }}')">
            @if($coachHistory->managementTrainee->profile_picture)
              <img src="{{ asset('storage/' . $coachHistory->managementTrainee->profile_picture) }}" alt="Profile" class="avatar-circle">
            @else
              <div class="w-8 h-8 bg-[#FF9A02] flex items-center justify-center font-bold text-sm rounded-full shrink-0">
                  {{ strtoupper(substr($coachHistory->managementTrainee->user->name, 0, 1)) }} 
              </div>
              @endif
              <div>
                <p> {{ $coachHistory->managementTrainee->user->name }}</p>
              </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
  
  <div class="col-start-1 row-start-3 col-span-3 row-span-4 md:col-start-2 md:row-start-3 md:col-span-4 md:row-span-4 bg-gray-300 rounded-md p-10">
    @foreach ($coach->coachHistory()->get() as $coachHistory)
      <div class="notes-panel" style="display: none;" id="coach-history-{{ $coachHistory->id }}">

        <div class="date-dropdown">
          <label for="coach-date-select">Coaching Date:</label>
          <select id="coach-date-select" onchange="showCoachNote(this.value)">
              @foreach ($coachHistory->managementTrainee->coachNote as $coachNote)
                  <option value="{{ $coachNote->created_at }}">{{ $coachNote->created_at }}</option>
              @endforeach
          </select>
        </div>

        @foreach ($coachHistory->managementTrainee->coachNote as $coachNote)
        <div id="date-{{ $coachNote->created_at }}" class="note-content" style="display: none;">
            <p><strong>Comments:</strong> {{ $coachNote->comments }} </p> 
        </div>
        @endforeach
      </div>
    @endforeach


  </div>
      
</div>
@endsection

<script>
    function showList(list) {
        document.querySelectorAll('.tab-content').forEach(el => {
            el.style.display = 'none';
        });
        document.getElementById(list).style.display = 'block';
    }

    function showMtNotes(id) {
        document.querySelectorAll('.notes-panel').forEach(el => {
            el.style.display = 'none';
        });
        document.getElementById('coach-history-' + id).style.display = 'block';
    }

        function showCoachNote(created_at) {
            document.querySelectorAll('.note-content').forEach(el => {
                el.style.display = 'none';
            });
            document.getElementById('date-' + created_at).style.display = 'block';
        }
</script>