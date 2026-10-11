@extends('layouts.app')

@section('content')
<div class="mx-6 my-6 flex flex-col gap-4 h-full min-h-[80vh]">

    <div class="bg-[#197B40] rounded-4xl p-8 md:p-10 shadow-md flex flex-col md:flex-row items-start md:items-center justify-between border border-[#146032] shrink-0 gap-4">
        <div class="flex flex-col items-start gap-3 text-left">
            <span class="inline-block bg-[#fba919] text-white text-[11px] font-extrabold px-3 py-1.5 rounded-md uppercase tracking-widest shadow-sm">
                {{ $assignment->phase }}
            </span>
            <div>
                <h2 class="text-2xl md:text-3xl font-black text-white mb-1">
                    {{ $assignment->managementTrainee->user->name ?? 'Unknown MT' }}
                </h2>
                <p class="text-sm font-semibold text-white/80">
                    {{ $assignment->title }}
                </p>
            </div>
        </div>
        
        <div class="flex items-center gap-2 bg-[#146032]/50 px-4 py-2 rounded-xl text-white/90 shadow-inner">
            <i data-lucide="clock" class="w-4 h-4"></i>
            <span class="text-sm font-semibold">
                Uploaded: {{ $assignment->uploaded_at ?? 'Belum diupload' }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 flex-1">
        
        <div class="lg:col-span-2 bg-white rounded-4xl shadow-sm border border-gray-200 flex flex-col min-h-125 overflow-hidden relative">
            @if($assignment->file_path)
                <iframe src="{{ asset('storage/' . $assignment->file_path) }}" class="absolute inset-0 w-full h-full border-0"></iframe>
            @else
                <div class="absolute inset-0 flex flex-col items-center justify-center text-gray-400 bg-gray-50">
                    <i data-lucide="file-x-2" class="w-12 h-12 mb-3 opacity-40"></i>
                    <span class="text-base font-bold tracking-wider">No Document Uploaded</span>
                </div>
            @endif
        </div>

        <div class="lg:col-span-1 flex flex-col gap-4">
            
            @if($canScore)
                <form method="POST" action="{{ route('scoring.store', $assignment) }}" class="flex flex-col gap-4 h-full">
                    @csrf

                    <div class="bg-white rounded-4xl p-6 shadow-sm border border-gray-200 shrink-0">
                        <label class="text-xs font-extrabold text-gray-500 mb-2 block uppercase tracking-wide text-center">Score (0 - 100)</label>
                        <input type="number" name="score" min="0" max="100" step="0.1" required
                               value="{{ old('score', $existingScore->score ?? '') }}"
                               class="w-full border-2 border-gray-100 rounded-2xl p-4 text-4xl text-center font-black text-[#197B40] focus:outline-none focus:border-[#197B40] bg-gray-50 transition-colors">
                        @error('score')
                            <p class="text-xs text-red-500 font-semibold mt-2 text-center">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="bg-white rounded-4xl p-6 shadow-sm border border-gray-200 flex flex-col flex-1 gap-4">
                        <div class="flex-1 flex flex-col">
                            <label class="text-xs font-extrabold text-gray-500 mb-2 block uppercase tracking-wide">Comments</label>
                            <textarea name="comments" required
                                      class="w-full flex-1 border-2 border-gray-100 rounded-xl p-3 text-sm font-medium text-gray-700 focus:outline-none focus:border-[#197B40] bg-gray-50 resize-none transition-colors min-h-30"
                                      placeholder="Berikan catatan, evaluasi, atau masukan untuk MT...">{{ old('comments', $existingScore->comments ?? '') }}</textarea>
                            @error('comments')
                                <p class="text-xs text-red-500 font-semibold mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        @if(session('success'))
                            <div class="bg-green-50 border border-green-200 text-green-700 text-sm font-semibold px-4 py-3 rounded-xl text-center">
                                <i data-lucide="check-circle" class="w-4 h-4 inline-block mr-1 -mt-0.5"></i>
                                {{ session('success') }}
                            </div>
                        @endif

                        <button type="submit" class="w-full bg-[#197B40] hover:bg-[#146032] text-white font-extrabold py-3.5 rounded-xl transition-all shadow-md text-sm tracking-wide mt-auto">
                            {{ $existingScore ? 'Update Score' : 'Simpan Score' }}
                        </button>
                    </div>
                </form>

            @else

                <div class="bg-white rounded-3xl shadow-sm border border-gray-200 flex flex-col overflow-hidden h-fit">
                    
                    <div class="bg-[#197B40] py-4 flex items-center justify-between px-5 shrink-0">
                        <h3 class="font-extrabold text-white text-base uppercase tracking-widest">Score</h3>
                    </div>

                    <div class="p-5 flex flex-col gap-3 bg-white">
                        @php
                            $panelistAccesses = $assignment->panelistAccess;
                            $maxSlots = 3;
                            
                            // Hitung skor aktual untuk Final Score
                            $actualScores = $assignment->score->pluck('score')->filter(function($val) { return $val !== null; });
                            $finalScore = $actualScores->count() > 0 ? number_format($actualScores->average(), 1) : '-';
                        @endphp

                        @for ($i = 0; $i < $maxSlots; $i++)
                            @php
                                $access = $panelistAccesses->get($i);
                            @endphp
                            
                            @if ($access)
                                @php
                                    $panelistScore = $assignment->score->where('panelist_id', $access->panelist_id)->first();
                                @endphp
                                <div class="flex justify-between items-center p-4 bg-white border border-gray-100 rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)]">
                                    <span class="font-extrabold text-[#1e293b] text-sm">
                                        {{ $access->panelist->user->name ?? 'Unknown' }}
                                    </span>
                                    @if($panelistScore)
                                        <span class="font-black text-[#fba919] text-lg">{{ $panelistScore->score }}</span>
                                    @else
                                        <span class="font-black text-gray-300 text-lg">-</span>
                                    @endif
                                </div>
                            @else
                                <button type="button" onclick="openModal('modal-panelist-{{ $assignment->phase }}')" class="w-full flex flex-col items-center justify-center py-5 border-2 border-dashed border-gray-300 rounded-2xl text-gray-400 hover:text-[#197B40] hover:border-[#197B40] hover:bg-[#197B40]/5 transition-all cursor-pointer group">
                                    <i data-lucide="plus" class="w-7 h-7 mb-1 group-hover:scale-110 transition-transform"></i>
                                    <span class="font-bold text-sm">Assign Panelist</span>
                                </button>
                            @endif
                        @endfor

                        <div class="flex justify-between items-center p-4 border-2 border-[#197B40] rounded-2xl bg-white mt-1">
                            <span class="font-extrabold text-[#197B40] text-sm uppercase tracking-wide">Final Score</span>
                            <span class="font-black text-[#197B40] text-xl">{{ $finalScore }}</span>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>

@unless($canScore)
    @include('panelist.modal-score-panelist')
@endunless

<script>
    function openModal(id) {
        const el = document.getElementById(id);
        if (!el) return;
        el.classList.remove('hidden');
        el.style.display = 'flex';
        el.style.alignItems = 'center';
        el.style.justifyContent = 'center';
    }

    function closeModal(id) {
        const el = document.getElementById(id);
        if (!el) return;
        el.classList.add('hidden');
        el.style.display = 'none';
    }
</script>

<style>
.custom-scrollbar::-webkit-scrollbar { width: 6px; }
.custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
.custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
</style>
@endsection