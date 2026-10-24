@extends('layouts.app')

@section('content')

@if(session('success'))
<div class="mx-6 mt-6 bg-green-50 border border-green-200 text-green-700 text-sm font-semibold px-4 py-3 rounded-xl flex items-center gap-2 shadow-sm">
    <i data-lucide="check-circle" class="w-4 h-4"></i>
    {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="mx-6 mt-6 bg-red-50 border border-red-200 text-red-600 text-sm font-semibold px-4 py-3 rounded-xl flex items-center gap-2 shadow-sm">
    <i data-lucide="alert-circle" class="w-4 h-4"></i>
    {{ session('error') }}
</div>
@endif

<div class="mx-6 my-6 grid grid-cols-1 lg:grid-cols-12 lg:grid-rows-6 gap-6 items-stretch min-h-[80vh] pb-10">

    {{-- KOLOM KIRI --}}
    <div class="lg:col-start-1 lg:row-start-1 lg:col-span-3 lg:row-span-6 flex flex-col gap-5 h-full">

        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-4 shrink-0 flex flex-col h-70 relative">
            <div class="w-full flex-1 bg-gray-50 rounded-3xl overflow-hidden flex items-center justify-center border-2 border-dashed border-gray-100">
                <img src="{{ $managementTrainee->profile_picture ? asset('storage/' . $managementTrainee->profile_picture) : 'https://ui-avatars.com/api/?name='.urlencode($managementTrainee->user->name ?? 'MT').'&background=197B40&color=fff&size=300' }}" 
                     alt="Profile Image" 
                     class="w-full h-full object-cover" 
                     onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($managementTrainee->user->name ?? 'MT') }}&background=197B40&color=fff&size=300'">
            </div>
            <a href="#" onclick="openModal('modal-photo'); return false;" class="absolute top-6 right-6 bg-[#197B40] p-2.5 rounded-xl text-white hover:bg-[#146032] transition shadow-md group" title="Ganti Foto">
                <i data-lucide="camera" class="w-4 h-4 group-hover:scale-110 transition-transform"></i>
            </a>
        </div>

        <div class="bg-[#197B40] rounded-2xl shadow-sm px-4 py-2 flex justify-center items-center w-full shrink-0 border border-[#146032]">
            <span class="bg-white text-[#197B40] px-4 py-1.5 rounded-xl font-black text-sm md:text-base uppercase tracking-widest shadow-sm w-full text-center">
                {{ $managementTrainee->status }}
            </span>
        </div>

        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden flex flex-col shrink-0">
            <div class="bg-[#197B40] px-5 py-3.5 flex items-center justify-center">
                <h3 class="text-white font-extrabold text-sm uppercase tracking-wider text-center">My Coach</h3>
            </div>
            <div class="p-5 flex items-center justify-center bg-gray-50/50">
                <span class="font-black text-gray-900 text-sm md:text-base text-center">
                    {{ $managementTrainee->coachHistory()->where('ended_at', null)->first()?->coach?->user?->name ?? 'Unassigned' }}
                </span>
            </div>
        </div>

        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden flex flex-col flex-1 min-h-0">
            <div class="bg-[#197B40] px-5 py-3.5 flex justify-between items-center shrink-0">
                <div class="flex-1"></div>
                <h3 class="text-white font-extrabold text-sm uppercase tracking-wider text-center flex-1">My Data</h3>
                <div class="flex-1 flex justify-end">
                    <a href="#" onclick="openModal('modal-own-data'); return false;" class="bg-white/20 p-1.5 rounded-lg text-white hover:bg-[#fba919] transition shadow-sm" title="Edit Data">
                        <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                    </a>
                </div>
            </div>
            <div class="p-5 flex flex-col justify-between flex-1 text-xs gap-1 overflow-y-auto custom-scrollbar bg-gray-50/30">
                <div class="flex justify-between items-center py-1.5 border-b border-gray-100/50"><span class="text-gray-500 font-extrabold uppercase tracking-wide">Index Num</span> <span class="font-bold text-gray-900">{{ $managementTrainee->index_number }}</span></div>
                <div class="flex justify-between items-center py-1.5 border-b border-gray-100/50"><span class="text-gray-500 font-extrabold uppercase tracking-wide">Batch</span> <span class="font-bold text-gray-900">{{ $managementTrainee->batch }}</span></div>
                <div class="flex justify-between items-center py-1.5 border-b border-gray-100/50"><span class="text-gray-500 font-extrabold uppercase tracking-wide">MBTI</span> <span class="font-bold text-gray-900">{{ $managementTrainee->mbti }}</span></div>
                <div class="flex justify-between items-center py-1.5 border-b border-gray-100/50"><span class="text-gray-500 font-extrabold uppercase tracking-wide">Major</span> <span class="font-bold text-gray-900">{{ $managementTrainee->major }}</span></div>
                <div class="flex justify-between items-center py-1.5 border-b border-gray-100/50"><span class="text-gray-500 font-extrabold uppercase tracking-wide">University</span> <span class="font-bold text-gray-900 truncate max-w-[120px] text-right">{{ $managementTrainee->university }}</span></div>
                <div class="flex justify-between items-center py-1.5 border-b border-gray-100/50"><span class="text-gray-500 font-extrabold uppercase tracking-wide">Degree</span> <span class="font-bold text-gray-900">{{ $managementTrainee->education_degree }}</span></div>
                <div class="flex justify-between items-center py-1.5 border-b border-gray-100/50"><span class="text-gray-500 font-extrabold uppercase tracking-wide">Placement</span> <span class="font-bold text-gray-900">{{ $managementTrainee->placement }}</span></div>
                <div class="flex justify-between items-center py-1.5 border-b border-gray-100/50"><span class="text-gray-500 font-extrabold uppercase tracking-wide">Prog. Ldr</span> <span class="font-bold text-gray-900">{{ $managementTrainee->program_leader }}</span></div>
                <div class="flex justify-between items-center py-1.5 border-b border-gray-100/50"><span class="text-gray-500 font-extrabold uppercase tracking-wide">Assign Ldr</span> <span class="font-bold text-gray-900">{{ $managementTrainee->assignment_leader }}</span></div>
                <div class="flex justify-between items-center py-2 pt-3"><span class="text-gray-500 font-extrabold uppercase tracking-wide">Program</span> <span class="font-black text-[#197B40] bg-[#197B40]/10 px-2 py-0.5 rounded-md">{{ $managementTrainee->mtProgram->name ?? 'N/A' }}</span></div>
            </div>
        </div>
    </div>

    {{-- KANAN: ASSIGNMENTS --}}
    <div class="lg:col-start-4 lg:row-start-1 lg:col-span-9 lg:row-span-6 bg-white rounded-[2rem] shadow-sm border border-gray-100 p-6 flex flex-col overflow-hidden">

        <div class="flex flex-wrap gap-2 mb-4 border-b border-gray-100 pb-4 shrink-0">
            @foreach ($managementTrainee->assignment as $index => $assignment)
                @php
                    $unlocked = match($assignment->phase) {
                        'Phase 1' => true,
                        'Phase 2' => ($managementTrainee->assignment->firstWhere('phase', 'Phase 1')?->score->whereNotNull('submitted_at')->count() ?? 0) >= 3,
                        'Phase 3' => (($managementTrainee->assignment->firstWhere('phase', 'Phase 1')?->score->whereNotNull('submitted_at')->count() ?? 0) >= 3)
                                     && (($managementTrainee->assignment->firstWhere('phase', 'Phase 2')?->score->whereNotNull('submitted_at')->count() ?? 0) >= 3),
                        default => false,
                    };
                @endphp
                <button id="btn-phase-{{ $assignment->phase }}" 
                        onclick="showAssignment('{{ $assignment->phase }}')" 
                        class="tab-btn px-5 py-2 rounded-xl font-extrabold text-xs transition-all duration-200 {{ $index === 0 ? 'bg-[#fba919] text-white shadow-sm' : 'bg-gray-50 text-gray-500 hover:bg-gray-100 hover:text-gray-700' }} uppercase tracking-wide border border-transparent flex items-center gap-1.5">
                    {{ $assignment->phase }}
                    @unless($unlocked)
                        <i data-lucide="lock" class="w-3.5 h-3.5 opacity-70"></i>
                    @endunless
                </button>
            @endforeach
        </div>

        @foreach ($managementTrainee->assignment as $index => $assignment)
        @php
            $unlocked = match($assignment->phase) {
                'Phase 1' => true,
                'Phase 2' => ($managementTrainee->assignment->firstWhere('phase', 'Phase 1')?->score->whereNotNull('submitted_at')->count() ?? 0) >= 3,
                'Phase 3' => (($managementTrainee->assignment->firstWhere('phase', 'Phase 1')?->score->whereNotNull('submitted_at')->count() ?? 0) >= 3)
                             && (($managementTrainee->assignment->firstWhere('phase', 'Phase 2')?->score->whereNotNull('submitted_at')->count() ?? 0) >= 3),
                default => false,
            };
            $scoredCount = $assignment->score->whereNotNull('submitted_at')->count();
        @endphp

        <div id="assignment-{{ $assignment->phase }}" class="assignment-content flex-1 flex flex-col min-h-0" style="display: {{ $index === 0 ? 'flex' : 'none' }};">

            <div class="flex items-center justify-between mb-3 shrink-0">
                <h2 class="text-xl font-black text-gray-900">{{ $assignment->title }}</h2>
                @if($assignment->file_path)
                    <span class="text-xs font-bold text-[#197B40] flex items-center gap-1 bg-[#197B40]/10 px-3 py-1.5 rounded-lg">
                        <i data-lucide="check-circle" class="w-3.5 h-3.5"></i>
                        {{ $scoredCount }}/3 panelist sudah menilai
                    </span>
                @endif
            </div>

            @if($unlocked)
                <form method="POST" action="{{ route('mt.uploadAssignment', $assignment) }}" enctype="multipart/form-data" class="flex flex-col flex-1 min-h-0">
                    @csrf

                    @error('file')
                        <p class="text-xs text-red-500 font-bold mb-2">{{ $message }}</p>
                    @enderror

                    <div class="bg-gray-50 rounded-[1.5rem] border-2 border-dashed border-gray-200 overflow-hidden w-full flex-1 min-h-0 relative flex items-center justify-center transition-colors hover:border-[#197B40]/30 mb-4">
                        @if($assignment->file_path)
                            <iframe src="{{ asset('storage/' . $assignment->file_path) }}" class="absolute inset-0 w-full h-full border-0 bg-white"></iframe>
                            @if($scoredCount === 0)
                                <div class="absolute bottom-4 right-4 bg-white/95 p-2 rounded-xl shadow-lg backdrop-blur-sm border border-gray-100 flex items-center gap-2">
                                    <span class="text-xs font-bold text-gray-600 ml-2">Ganti File:</span>
                                    <input type="file" name="file" accept="application/pdf"
                                           class="text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-[#197B40]/10 file:text-[#197B40] file:font-extrabold hover:file:bg-[#197B40]/20 file:transition-colors file:cursor-pointer cursor-pointer w-[190px]">
                                </div>
                            @else
                                <div class="absolute bottom-4 right-4 bg-white/95 px-3 py-2 rounded-xl shadow-lg backdrop-blur-sm border border-gray-100 flex items-center gap-1.5">
                                    <i data-lucide="lock" class="w-3.5 h-3.5 text-gray-400"></i>
                                    <span class="text-xs font-bold text-gray-500">Sudah dinilai, tidak bisa diubah</span>
                                </div>
                            @endif
                        @else
                            <div class="flex flex-col items-center justify-center p-8 w-full h-full">
                                <div class="w-16 h-16 bg-white rounded-full shadow-sm flex items-center justify-center mb-3 border border-gray-100">
                                    <i data-lucide="upload-cloud" class="w-8 h-8 text-[#197B40]"></i>
                                </div>
                                <span class="text-base font-bold text-gray-700 mb-1">Upload Dokumen {{ $assignment->phase }}</span>
                                <span class="text-xs font-semibold text-gray-400 mb-4">Format PDF, maksimal 10MB</span>
                                <input type="file" name="file" accept="application/pdf" required
                                       class="text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-5 file:rounded-xl file:border-0 file:bg-[#197B40]/10 file:text-[#197B40] file:font-extrabold hover:file:bg-[#197B40]/20 file:transition-colors file:cursor-pointer cursor-pointer">
                            </div>
                        @endif
                    </div>

                    <div class="flex justify-between items-center shrink-0">
                        <p class="text-xs font-bold text-gray-400 flex items-center gap-1.5">
                            @if($assignment->uploaded_at)
                                <i data-lucide="clock" class="w-4 h-4"></i> Terakhir diubah: {{ $assignment->uploaded_at }}
                            @endif
                        </p>
                        @if($scoredCount === 0)
                        <button type="submit" class="bg-[#197B40] hover:bg-[#146032] text-white text-sm font-extrabold px-8 py-3 rounded-xl transition-all shadow-md tracking-wide flex items-center gap-2">
                            <i data-lucide="save" class="w-4 h-4"></i> {{ $assignment->file_path ? 'Update Assignment' : 'Submit Assignment' }}
                        </button>
                        @endif
                    </div>
                </form>
            @else
                <div class="bg-gray-100 rounded-[1.5rem] border-2 border-gray-200 overflow-hidden w-full flex-1 min-h-0 relative flex flex-col items-center justify-center opacity-70 cursor-not-allowed">
                    <div class="w-20 h-20 bg-gray-200 rounded-full flex items-center justify-center mb-4 shadow-inner">
                        <i data-lucide="lock" class="w-10 h-10 text-gray-400"></i>
                    </div>
                    <span class="text-xl font-black text-gray-500 uppercase tracking-wide">Phase Terkunci</span>
                    <span class="text-xs font-bold text-gray-400 mt-2 max-w-xs text-center">Selesaikan penilaian fase sebelumnya oleh ketiga panelist untuk membuka akses formulir.</span>
                </div>
            @endif

        </div>
        @endforeach
    </div>

</div>

{{-- MODAL: UPLOAD FOTO PROFIL --}}
<div id="modal-photo" onclick="if(event.target === this) closeModal('modal-photo')" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4 transition-opacity" style="display:none;">
    <div class="bg-white rounded-[2rem] p-8 w-full max-w-sm shadow-xl relative">
        <button type="button" onclick="closeModal('modal-photo')" class="absolute top-6 right-6 text-gray-400 hover:text-gray-800 transition-colors bg-gray-50 hover:bg-gray-100 p-1.5 rounded-full">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        <h3 class="font-black text-xl mb-6 pr-8 text-gray-900 tracking-tight">Ganti Foto Profil</h3>

        <form method="POST" action="{{ route('mt.uploadPhoto') }}" enctype="multipart/form-data" class="flex flex-col gap-4">
            @csrf
            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-extrabold text-gray-500 uppercase tracking-wide">Pilih File Gambar</label>
                <input type="file" name="profile_picture" accept="image/*" required
                       class="w-full border-2 border-gray-100 rounded-xl p-2.5 text-sm font-semibold text-gray-600 bg-gray-50 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-[#197B40]/10 file:text-[#197B40] file:font-bold hover:file:bg-[#197B40]/20 file:transition-colors file:cursor-pointer cursor-pointer">
                @error('profile_picture') <p class="text-xs text-red-500 font-bold mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end gap-3 mt-4 pt-4 border-t border-gray-100">
                <button type="button" onclick="closeModal('modal-photo')" class="px-5 py-2.5 rounded-xl bg-gray-100 text-gray-700 text-sm font-bold hover:bg-gray-200 transition-colors">Batal</button>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#197B40] hover:bg-[#146032] text-white text-sm font-bold shadow-sm transition-colors">Upload</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL: EDIT DATA MT --}}
<div id="modal-own-data" onclick="if(event.target === this) closeModal('modal-own-data')" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4 transition-opacity" style="display:none;">
    <div class="bg-white rounded-[2rem] p-8 w-full max-w-md shadow-xl relative">
        <button type="button" onclick="closeModal('modal-own-data')" class="absolute top-6 right-6 text-gray-400 hover:text-gray-800 transition-colors bg-gray-50 hover:bg-gray-100 p-1.5 rounded-full">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        <h3 class="font-black text-xl mb-6 pr-8 text-gray-900 tracking-tight">Edit Data Pribadi</h3>

        <form method="POST" action="{{ route('mt.updateOwnData') }}" class="flex flex-col gap-4">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-extrabold text-gray-500 uppercase tracking-wide">Major</label>
                    <input type="text" name="major" value="{{ old('major', $managementTrainee->major) }}" 
                           class="w-full border-2 border-gray-100 rounded-xl p-3 text-sm font-semibold text-gray-800 focus:outline-none focus:border-[#197B40] bg-gray-50 focus:bg-white transition-colors">
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-extrabold text-gray-500 uppercase tracking-wide">University</label>
                    <input type="text" name="university" value="{{ old('university', $managementTrainee->university) }}" 
                           class="w-full border-2 border-gray-100 rounded-xl p-3 text-sm font-semibold text-gray-800 focus:outline-none focus:border-[#197B40] bg-gray-50 focus:bg-white transition-colors">
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-extrabold text-gray-500 uppercase tracking-wide">Degree</label>
                    <select name="education_degree" class="w-full border-2 border-gray-100 rounded-xl p-3 text-sm font-semibold text-gray-800 focus:outline-none focus:border-[#197B40] bg-gray-50 transition-colors cursor-pointer">
                        @foreach (['S1','S2','S3','D1','D2','D3','D4'] as $degree)
                            <option value="{{ $degree }}" {{ old('education_degree', $managementTrainee->education_degree) === $degree ? 'selected' : '' }}>{{ $degree }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-extrabold text-gray-500 uppercase tracking-wide">MBTI</label>
                    <input type="text" name="mbti" value="{{ old('mbti', $managementTrainee->mbti) }}" 
                           class="w-full border-2 border-gray-100 rounded-xl p-3 text-sm font-semibold text-gray-800 focus:outline-none focus:border-[#197B40] bg-gray-50 focus:bg-white transition-colors">
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-4 pt-4 border-t border-gray-100">
                <button type="button" onclick="closeModal('modal-own-data')" class="px-5 py-2.5 rounded-xl bg-gray-100 text-gray-700 text-sm font-bold hover:bg-gray-200 transition-colors">Batal</button>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#197B40] hover:bg-[#146032] text-white text-sm font-bold shadow-sm transition-colors">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function showAssignment(phase) {
        document.querySelectorAll('.assignment-content').forEach(el => {
            el.style.display = 'none';
        });

        document.getElementById('assignment-' + phase).style.display = 'flex';

        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('bg-[#fba919]', 'text-white', 'shadow-sm');
            btn.classList.add('bg-gray-50', 'text-gray-500', 'hover:bg-gray-100', 'hover:text-gray-700');
        });
        let activeBtn = document.getElementById('btn-phase-' + phase);
        if(activeBtn) {
            activeBtn.classList.remove('bg-gray-50', 'text-gray-500', 'hover:bg-gray-100', 'hover:text-gray-700');
            activeBtn.classList.add('bg-[#fba919]', 'text-white', 'shadow-sm');
        }
    }

    function openModal(id) {
        const el = document.getElementById(id);
        if(el){
            el.classList.remove('hidden');
            el.style.display = 'flex';
            el.style.alignItems = 'center';
            el.style.justifyContent = 'center';
        }
    }

    function closeModal(id) {
        const el = document.getElementById(id);
        if(el){
            el.classList.add('hidden');
            el.style.display = 'none';
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        const urlParams = new URLSearchParams(window.location.search);
        const preselectedPhase = urlParams.get('phase');
        if (preselectedPhase) {
            showAssignment(preselectedPhase);
        }
    });
</script>

<style>
.custom-scrollbar::-webkit-scrollbar { width: 6px; }
.custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
.custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
</style>
@endsection