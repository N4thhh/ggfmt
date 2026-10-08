@foreach ($managementTrainee->assignment as $assignment)
<div id="modal-panelist-{{ $assignment->phase }}" class="hidden fixed inset-0 bg-black/50 z-50 items-center justify-center p-4">
    <div class="bg-white rounded-2xl p-6 w-full max-w-sm">
        <h3 class="font-bold text-lg mb-4 text-gray-900">Assign Panelist — {{ $assignment->phase }}</h3>
        <form method="POST" action="{{ route('assignment.assignPanelist', $assignment) }}">
            @csrf
            <select name="panelist_id" class="w-full border border-gray-200 rounded-lg p-2 mb-4 text-sm">
                @foreach (\App\Models\Panelist::all() as $panelist)
                    <option value="{{ $panelist->id }}">{{ $panelist->user->name }}</option>
                @endforeach
            </select>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal('modal-panelist-{{ $assignment->phase }}')" class="px-4 py-2 rounded-lg bg-gray-100 text-sm font-semibold">Batal</button>
                <button type="submit" class="px-4 py-2 rounded-lg bg-[#197B40] text-white text-sm font-semibold">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endforeach