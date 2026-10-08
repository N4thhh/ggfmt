<div id="modal-data" class="hidden fixed inset-0 bg-black/50 z-50 items-center justify-center p-4">
    <div class="bg-white rounded-2xl p-6 w-full max-w-md max-h-[90vh] overflow-y-auto">
        <h3 class="font-bold text-lg mb-4 text-gray-900">Edit MT Data</h3>
        <form method="POST" action="{{ route('mt.update', $managementTrainee) }}" class="flex flex-col gap-3">
            @csrf
            @method('PATCH')
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
                    <label class="text-xs text-gray-500">{{ $label }}</label>
                    <input type="text" name="{{ $field }}" value="{{ $managementTrainee->$field }}" class="w-full border border-gray-200 rounded-lg p-2 text-sm">
                </div>
            @endforeach
            <div>
                <label class="text-xs text-gray-500">Program</label>
                <select name="mt_program_id" class="w-full border border-gray-200 rounded-lg p-2 text-sm">
                    @foreach (\App\Models\MtProgram::all() as $program)
                        <option value="{{ $program->id }}" {{ $managementTrainee->mt_program_id === $program->id ? 'selected' : '' }}>
                            {{ $program->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex justify-end gap-2 mt-2">
                <button type="button" onclick="closeModal('modal-data')" class="px-4 py-2 rounded-lg bg-gray-100 text-sm font-semibold">Batal</button>
                <button type="submit" class="px-4 py-2 rounded-lg bg-[#197B40] text-white text-sm font-semibold">Simpan</button>
            </div>
        </form>
    </div>
</div>