<div id="modal-data" onclick="if(event.target === this) closeModal('modal-data')" class="hidden fixed inset-0 bg-black/50 z-50 items-center justify-center p-4 transition-opacity" style="display:none;">
    <div class="bg-white rounded-4xl p-6 w-full max-w-2xl relative shadow-xl">
        
        <button type="button" onclick="closeModal('modal-data')" class="absolute top-6 right-6 text-gray-400 hover:text-gray-800 transition-colors bg-gray-50 hover:bg-gray-100 p-1.5 rounded-full">
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>

        <h3 class="font-extrabold text-xl mb-5 pr-8 text-gray-900">Edit MT Data</h3>
        
        <form method="POST" action="{{ route('mt.update', $managementTrainee) }}" class="flex flex-col">
            @csrf
            @method('PATCH')
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 mb-6">
                @foreach ([
                    'index_number' => 'Index Number',
                    'batch' => 'Batch',
                    'mbti' => 'MBTI',
                    'major' => 'Major',
                    'university' => 'University',
                    'education_degree' => 'Degree',
                    'placement' => 'Placement',
                    'program_leader' => 'Program Leader',
                    'assignment_leader' => 'Assignment Leader',
                ] as $field => $label)
                    <div>
                        <label class="text-xs font-bold text-gray-500 mb-1.5 block">{{ $label }}</label>
                        <input type="text" name="{{ $field }}" value="{{ $managementTrainee->$field }}" class="w-full border-2 border-gray-100 rounded-xl p-2.5 text-sm font-semibold text-gray-800 focus:outline-none focus:border-[#197B40] transition-colors bg-gray-50 focus:bg-white">
                    </div>
                @endforeach
                
                <div>
                    <label class="text-xs font-bold text-gray-500 mb-1.5 block">Program</label>
                    <select name="mt_program_id" class="w-full border-2 border-gray-100 rounded-xl p-2.5 text-sm font-semibold text-gray-800 focus:outline-none focus:border-[#197B40] transition-colors bg-gray-50 focus:bg-white cursor-pointer">
                        @foreach (\App\Models\MtProgram::all() as $program)
                            <option value="{{ $program->id }}" {{ $managementTrainee->mt_program_id === $program->id ? 'selected' : '' }}>
                                {{ $program->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <button type="button" onclick="closeModal('modal-data')" class="px-5 py-2.5 rounded-xl bg-gray-100 text-gray-700 text-sm font-bold hover:bg-gray-200 transition-colors">Batal</button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#197B40] text-white text-sm font-bold hover:bg-[#146032] transition-colors shadow-sm">Simpan</button>
            </div>
        </form>
    </div>
</div>