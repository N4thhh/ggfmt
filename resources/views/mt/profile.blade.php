@extends('layouts.app')

@section('content')
<div class="mx-6 my-6 grid grid-cols-1 lg:grid-cols-12 lg:grid-rows-6 gap-4 items-stretch">

    <div class="lg:col-start-1 lg:row-start-1 lg:col-span-3 lg:row-span-6 flex flex-col gap-4 h-full">
        
        <div class="bg-white rounded-4xl shadow-sm border border-gray-100 p-4 shrink-0 flex flex-col h-70">
            <div class="w-full flex-1 bg-gray-100 rounded-3xl overflow-hidden flex items-center justify-center">
                <img src="{{ asset('images/mt-profile.jpg') }}" alt="Profile Image" class="w-full h-full object-cover" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($managementTrainee->user->name ?? 'MT') }}&background=197B40&color=fff&size=300'">
            </div>
        </div>

        <div class="bg-[#197B40] rounded-2xl shadow-sm px-4 py-2 flex justify-between items-center w-full shrink-0">
            <span class="bg-white text-[#197B40] px-4 py-1.5 rounded-xl font-extrabold text-sm md:text-base uppercase tracking-wider shadow-sm flex-1 text-center mr-3">
                {{ $managementTrainee->status }}
            </span>
            <a href="#" class="bg-white/20 p-2 rounded-xl text-white hover:bg-[#fba919] transition shrink-0" title="Edit Status">
                <i data-lucide="edit-3" class="w-4 h-4"></i>
            </a>
        </div>

        <div class="bg-white rounded-4xl shadow-sm border border-gray-100 overflow-hidden flex flex-col shrink-0">
            <div class="bg-[#197B40] px-5 py-4 flex justify-between items-center">
                <h3 class="text-white font-bold text-base uppercase">COACH</h3>
                <a href="#" class="bg-white/20 p-1.5 rounded-lg text-white hover:bg-[#fba919] transition" title="Assign Coach">
                    <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                </a>
            </div>
            <div class="p-5 flex items-center justify-center bg-gray-50/30">
                <span class="font-extrabold text-gray-900 text-sm md:text-base text-center">
                    {{ $managementTrainee->coachHistory()->where('ended_at', null)->first()?->coach?->user?->name ?? 'Unassigned' }}
                </span>
            </div>
        </div>

        <div class="bg-white rounded-4xl shadow-sm border border-gray-100 overflow-hidden flex flex-col flex-1 min-h-0">
            <div class="bg-[#197B40] px-5 py-4 flex justify-between items-center shrink-0">
                <h3 class="text-white font-bold text-base">MT Data</h3>
                <a href="#" class="bg-white/20 p-1.5 rounded-lg text-white hover:bg-[#fba919] transition">
                    <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                </a>
            </div>
            <div class="p-5 flex flex-col justify-between flex-1 text-xs gap-1 overflow-y-auto custom-scrollbar">
                <div class="flex justify-between items-center py-1.5 border-b border-gray-50"><span class="text-gray-500">Index Number</span> <span class="font-bold text-gray-900">{{ $managementTrainee->index_number }}</span></div>
                <div class="flex justify-between items-center py-1.5 border-b border-gray-50"><span class="text-gray-500">Batch</span> <span class="font-bold text-gray-900">{{ $managementTrainee->batch }}</span></div>
                <div class="flex justify-between items-center py-1.5 border-b border-gray-50"><span class="text-gray-500">MBTI</span> <span class="font-bold text-gray-900">{{ $managementTrainee->mbti }}</span></div>
                <div class="flex justify-between items-center py-1.5 border-b border-gray-50"><span class="text-gray-500">Major</span> <span class="font-bold text-gray-900">{{ $managementTrainee->major }}</span></div>
                <div class="flex justify-between items-center py-1.5 border-b border-gray-50"><span class="text-gray-500">University</span> <span class="font-bold text-gray-900">{{ $managementTrainee->university }}</span></div>
                <div class="flex justify-between items-center py-1.5 border-b border-gray-50"><span class="text-gray-500">Degree</span> <span class="font-bold text-gray-900">{{ $managementTrainee->education_degree }}</span></div>
                <div class="flex justify-between items-center py-1.5 border-b border-gray-50"><span class="text-gray-500">Placement</span> <span class="font-bold text-gray-900">{{ $managementTrainee->placement }}</span></div>
                <div class="flex justify-between items-center py-1.5 border-b border-gray-50"><span class="text-gray-500">Prog. Ldr</span> <span class="font-bold text-gray-900">{{ $managementTrainee->program_leader }}</span></div>
                <div class="flex justify-between items-center py-1.5 border-b border-gray-50"><span class="text-gray-500">Assign Ldr</span> <span class="font-bold text-gray-900">{{ $managementTrainee->assignment_leader }}</span></div>
                <div class="flex justify-between items-center py-1.5"><span class="text-gray-500">Program</span> <span class="font-bold text-[#197B40]">{{ $managementTrainee->mtProgram->name ?? 'N/A' }}</span></div>
            </div>
        </div>
    </div>

    <div class="lg:col-start-4 lg:row-start-1 lg:col-span-6 lg:row-span-3 bg-white rounded-4xl shadow-sm border border-gray-100 p-6 flex flex-col overflow-hidden">
        
        <div class="flex flex-wrap gap-2 mb-4 border-b border-gray-100 pb-4 shrink-0">
            @foreach ($managementTrainee->assignment as $index => $assignment)
                <button id="btn-phase-{{ $assignment->phase }}" 
                        onclick="showAssignment('{{ $assignment->phase }}')" 
                        class="tab-btn px-4 py-1.5 rounded-lg font-bold text-xs transition-all duration-200 {{ $index === 0 ? 'bg-[#fba919] text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    {{ $assignment->phase }}
                </button>
            @endforeach
        </div>

        <div class="assignment-title-container mb-3 shrink-0">
            @foreach ($managementTrainee->assignment as $index => $assignment)
                <h2 id="title-{{ $assignment->phase }}" class="text-2xl font-bold text-gray-900 assignment-title wrap-break-word" style="display: {{ $index === 0 ? 'block' : 'none' }};">
                    {{ $assignment->title }}
                </h2>
            @endforeach
        </div>

        @foreach ($managementTrainee->assignment as $index => $assignment)
        <div id="assignment-{{ $assignment->phase }}" class="assignment-content flex-1 flex flex-col min-h-0" style="display: {{ $index === 0 ? 'flex' : 'none' }};">
            
            <p class="text-xs text-gray-500 mb-2 flex items-center gap-1 shrink-0">
                <i data-lucide="clock" class="w-3 h-3"></i> {{ $assignment->uploaded_at ?? 'N/A' }}
            </p>
            
            <div class="bg-gray-100 rounded-xl overflow-hidden w-full flex-1 min-h-0 relative flex items-center justify-center">
                @if($assignment->file_path)
                    <iframe src="{{ asset('storage/' . $assignment->file_path) }}" class="absolute inset-0 w-full h-full border-0"></iframe>
                @else
                    <div class="text-gray-400 flex flex-col items-center">
                        <i data-lucide="image" class="w-10 h-10 mb-2 opacity-50"></i>
                        <span class="text-sm font-semibold tracking-wider">No Document Uploaded</span>
                    </div>
                @endif
            </div>

        </div>
        @endforeach
    </div>

    <div class="lg:col-start-10 lg:row-start-1 lg:col-span-3 lg:row-span-1 bg-white rounded-4xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
        <div class="bg-[#197B40] px-4 py-3 text-center shrink-0">
            <h3 class="font-bold text-white text-xs tracking-wider uppercase">Score</h3>
        </div>
        
        @foreach ($managementTrainee->assignment as $index => $assignment)
        <div id="score-{{ $assignment->phase }}" class="score-content flex-1 p-4 flex flex-col" style="display: {{ $index === 0 ? 'flex' : 'none' }};">
            <div class="flex flex-col gap-2 flex-1">
                @forelse ($assignment->score as $score)
                    <div class="flex justify-between items-center p-2 border border-gray-100 rounded-lg bg-gray-50 text-xs shadow-sm">
                        <span class="font-bold text-gray-700 truncate mr-2">{{ $score->panelist->user->name ?? 'N/A' }}</span>
                        <span class="font-bold text-[#fba919]">{{ $score->score ?? '-' }}</span>
                    </div>
                @empty
                    <a href="#" class="flex flex-col items-center justify-center border-2 border-dashed border-gray-300 rounded-xl p-4 flex-1 text-gray-400 hover:text-[#197B40] hover:border-[#197B40] hover:bg-gray-50 transition-all cursor-pointer group">
                        <i data-lucide="plus" class="w-6 h-6 mb-1 group-hover:scale-110 transition-transform duration-200"></i>
                        <span class="text-xs font-bold tracking-wide">Assign Panelist</span>
                    </a>
                @endforelse
            </div>
            
            @if($assignment->score->isNotEmpty())
            <div class="mt-2 flex justify-between items-center p-2.5 border-2 border-[#197B40] rounded-lg bg-[#197B40]/5 shrink-0">
                <span class="text-xs font-extrabold text-[#197B40]">Final Score</span>
                <span class="font-extrabold text-[#197B40] text-sm">{{ $assignment->score->avg('score') ? number_format($assignment->score->avg('score'), 1) : '-' }}</span>
            </div>
            @endif
        </div>
        @endforeach
    </div>

    <div class="lg:col-start-10 lg:row-start-2 lg:col-span-3 lg:row-span-2 bg-white rounded-4xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
        <div class="bg-[#197B40] px-4 py-3 text-center shrink-0">
            <h3 class="font-bold text-white text-xs tracking-wider uppercase">Comments</h3>
        </div>
        
        @foreach ($managementTrainee->assignment as $index => $assignment)
        <div id="comment-{{ $assignment->phase }}" class="comment-content overflow-y-auto p-4 custom-scrollbar" style="display: {{ $index === 0 ? 'block' : 'none' }};">
            <div class="flex flex-col gap-3">
                @forelse ($assignment->score as $score)
                    @if($score->comments)
                        <div class="bg-gray-50 p-3 rounded-lg text-xs text-gray-700 border border-gray-100">
                            <span class="font-bold block text-gray-900 mb-1">{{ $score->panelist->user->name ?? 'Panelist' }}:</span>
                            {{ $score->comments }}
                        </div>
                    @endif
                @empty
                    <p class="text-xs text-gray-400 text-center py-2">No comments</p>
                @endforelse
            </div>
        </div>
        @endforeach
    </div>

    <div class="lg:col-start-4 lg:row-start-4 lg:col-span-9 lg:row-span-3 bg-white rounded-4xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
        
        <div class="bg-[#197B40] px-6 py-4 flex justify-between items-center shrink-0">
            <h3 class="text-white font-bold text-base">Coaching Notes</h3>
            <div class="flex items-center gap-2">
                <label for="coach-date-select" class="text-xs text-white/90 font-medium">Coaching Date:</label>
                
                @if($managementTrainee->coachNote->isNotEmpty())
                    <select id="coach-date-select" onchange="showCoachNote(this.value)" class="bg-white border border-gray-200 text-gray-900 text-xs rounded-lg px-3 py-1.5 outline-none cursor-pointer font-bold shadow-sm">
                        @foreach ($managementTrainee->coachNote as $coachNote)
                            <option value="{{ $coachNote->id }}">
                                {{ \Carbon\Carbon::parse($coachNote->created_at)->format('d M Y - H:i') }}
                            </option>
                        @endforeach
                    </select>
                @else
                    <span class="bg-white/20 text-white text-xs px-3 py-1.5 rounded-lg font-bold">No Data</span>
                @endif
            </div>
        </div>
        
        <div class="flex-1 overflow-y-auto p-6 bg-gray-50 custom-scrollbar">
            @forelse ($managementTrainee->coachNote as $index => $coachNote)
                <div id="note-{{ $coachNote->id }}" class="coach-note-content bg-white p-5 rounded-xl border border-gray-200 shadow-sm text-gray-700 text-sm whitespace-pre-line leading-relaxed" style="display: {{ $index === 0 ? 'block' : 'none' }};">
                    {{ $coachNote->comments }}
                </div>
            @empty
                <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm text-gray-400 italic text-sm text-center">
                    No coaching notes available.
                </div>
            @endforelse
        </div>
    </div>

</div>


<script>
    function showAssignment(phase) {
        document.querySelectorAll('.assignment-content, .score-content, .comment-content').forEach(el => {
            el.style.display = 'none';
        });
        document.querySelectorAll('.assignment-title').forEach(el => {
            el.style.display = 'none';
        });
        
        document.getElementById('assignment-' + phase).style.display = 'flex';
        document.getElementById('title-' + phase).style.display = 'block';
        document.getElementById('score-' + phase).style.display = 'flex';
        document.getElementById('comment-' + phase).style.display = 'block';

        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('bg-[#fba919]', 'text-white', 'shadow-sm');
            btn.classList.add('bg-gray-100', 'text-gray-600', 'hover:bg-gray-200');
        });
        let activeBtn = document.getElementById('btn-phase-' + phase);
        if(activeBtn) {
            activeBtn.classList.remove('bg-gray-100', 'text-gray-600', 'hover:bg-gray-200');
            activeBtn.classList.add('bg-[#fba919]', 'text-white', 'shadow-sm');
        }
    }
    
    function showCoachNote(noteId) {
        document.querySelectorAll('.coach-note-content').forEach(el => {
            el.style.display = 'none';
        });
        let targetNote = document.getElementById('note-' + noteId);
        if(targetNote) {
            targetNote.style.display = 'block';
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        const urlParams = new URLSearchParams(window.location.search);
        const preselectedPhase = urlParams.get('phase');
        if (preselectedPhase) {
            showAssignment(preselectedPhase);
        }
        
        const coachDropdown = document.getElementById('coach-date-select');
        if(coachDropdown && coachDropdown.value) {
            showCoachNote(coachDropdown.value);
        }
    });
</script>

<style>
.custom-scrollbar::-webkit-scrollbar {
    width: 5px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent; 
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #e5e7eb; 
    border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #d1d5db; 
}
</style>
@endsection