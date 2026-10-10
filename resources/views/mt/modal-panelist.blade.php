@if(isset($managementTrainee->assignment))
    @foreach($managementTrainee->assignment as $assignment)
        @php
            $assignedIds = [];
            if (isset($assignment->panelistAccess)) {
                $assignedIds =$assignment->panelistAccess->pluck('panelist_id')->toArray();
            }
            
            $initialPanelists = \App\Models\Panelist::whereIn('id', $assignedIds)->get()->map(function($p) {
                return [
                    'id' => $p->id,
                    'name' => $p->user->name ?? 'Unknown',
                    'initial' => strtoupper(substr($p->user->name ?? 'U', 0, 1))
                ];
            })->toJson();
        @endphp

        <div id="modal-panelist-{{ $assignment->phase }}" onclick="if(event.target === this) closeModal('modal-panelist-{{ $assignment->phase }}')" class="hidden fixed inset-0 bg-black/50 z-50 items-center justify-center p-4 transition-opacity" style="display:none;">
            <div class="bg-white rounded-4xl p-6 w-full max-w-md shadow-xl flex flex-col max-h-[85vh] relative">
                
                <button type="button" onclick="closeModal('modal-panelist-{{ $assignment->phase }}')" class="absolute top-6 right-6 text-gray-400 hover:text-gray-800 transition-colors bg-gray-50 hover:bg-gray-100 p-1.5 rounded-full">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>

                <h3 class="font-extrabold text-xl mb-4 pr-8 text-gray-900 shrink-0">Assign Panelist — {{ $assignment->phase }}</h3>

                <form method="POST" action="{{ route('assignment.assignPanelist', $assignment->id) }}" class="flex flex-col min-h-0 overflow-hidden">
                    @csrf
                    
                    <input type="hidden" name="panelist_id_1" id="input-p1-{{ $assignment->phase }}" value="{{ $assignedIds[0] ?? '' }}">
                    <input type="hidden" name="panelist_id_2" id="input-p2-{{ $assignment->phase }}" value="{{ $assignedIds[1] ?? '' }}">
                    <input type="hidden" name="panelist_id_3" id="input-p3-{{ $assignment->phase }}" value="{{ $assignedIds[2] ?? '' }}">

                    <div class="mb-4 shrink-0">
                        <label class="text-xs font-bold text-gray-500 mb-2 block">Panelist Terpilih (Maks 3)</label>
                        <div class="flex flex-col gap-2" id="selected-container-{{ $assignment->phase }}"></div>
                    </div>

                    <div class="relative mb-3 shrink-0">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <input type="text" id="search-{{ $assignment->phase }}" placeholder="Cari nama panelist..." class="w-full pl-10 pr-4 py-2.5 border-2 border-gray-100 rounded-xl text-sm font-semibold focus:outline-none focus:border-[#197B40] transition-colors bg-gray-50">
                    </div>

                    <div id="results-{{ $assignment->phase }}" class="flex-1 overflow-y-auto custom-scrollbar flex flex-col gap-2 mb-2 p-1 min-h-45">
                        <div class="flex items-center justify-center h-full text-gray-400 font-semibold text-sm">
                            Memuat data...
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 mt-4 pt-4 border-t border-gray-100 shrink-0">
                        <button type="button" onclick="closeModal('modal-panelist-{{ $assignment->phase }}')" class="px-5 py-2.5 rounded-xl bg-gray-100 text-gray-700 text-sm font-bold hover:bg-gray-200 transition-colors">Batal</button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#197B40] text-white text-sm font-bold hover:bg-[#146032] transition-colors shadow-sm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            (function() {
                const phase = "{{ $assignment->phase }}";
                const initialData = {!! $initialPanelists !!}; 
                
                let selected = [...initialData]; 

                const searchInput = document.getElementById(`search-${phase}`);
                const resultsContainer = document.getElementById(`results-${phase}`);
                const selectedContainer = document.getElementById(`selected-container-${phase}`);
                
                const inputs = [
                    document.getElementById(`input-p1-${phase}`),
                    document.getElementById(`input-p2-${phase}`),
                    document.getElementById(`input-p3-${phase}`)
                ];

                let debounceTimer;

                function renderSelected() {
                    if(!selectedContainer) return;
                    selectedContainer.innerHTML = '';
                    
                    inputs.forEach((input, index) => {
                        if(input) input.value = selected[index] ? selected[index].id : '';
                    });

                    for (let i = 0; i < 3; i++) {
                        const slot = document.createElement('div');
                        if (selected[i]) {
                            slot.className = "flex items-center justify-between p-2 rounded-xl border border-[#197B40] bg-[#197B40]/5 shadow-sm";
                            slot.innerHTML = `
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-[#197B40] flex items-center justify-center text-white font-extrabold text-xs rounded-full shadow-sm shrink-0">
                                        ${selected[i].initial}
                                    </div>
                                    <p class="font-bold text-gray-900 text-sm">${selected[i].name}</p>
                                </div>
                                <button type="button" class="remove-btn text-red-400 hover:text-red-600 p-1 bg-white rounded-full transition-colors shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            `;
                            slot.querySelector('.remove-btn').addEventListener('click', () => {
                                selected.splice(i, 1);
                                renderSelected();
                                fetchPanelists(searchInput.value);
                            });
                        } else {
                            slot.className = "flex items-center gap-3 p-2 rounded-xl border-2 border-dashed border-gray-200 bg-gray-50 text-gray-400 h-[52px]";
                            slot.innerHTML = `<p class="text-sm font-semibold ml-2">Slot ${i + 1} (Kosong)</p>`;
                        }
                        selectedContainer.appendChild(slot);
                    }
                }

                function fetchPanelists(query = '') {
                    if(!resultsContainer) return;
                    fetch(`/panelists/search?q=${encodeURIComponent(query)}`)
                        .then(res => res.json())
                        .then(data => {
                            resultsContainer.innerHTML = '';
                            if(data.length === 0) {
                                resultsContainer.innerHTML = '<div class="text-center text-gray-400 text-sm font-semibold mt-6">Tidak ditemukan.</div>';
                                return;
                            }

                            data.forEach(panelist => {
                                const isSelected = selected.find(p => p.id == panelist.id);
                                const card = document.createElement('div');
                                
                                if (isSelected) {
                                    card.className = "flex items-center justify-between p-3 rounded-xl border-2 border-[#197B40] bg-[#197B40]/5 opacity-50 cursor-not-allowed";
                                    card.innerHTML = `
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-[#fba919] flex items-center justify-center text-white font-extrabold text-sm rounded-full shrink-0">${panelist.initial}</div>
                                            <p class="font-bold text-gray-900 text-sm">${panelist.name}</p>
                                        </div>
                                        <span class="text-xs font-bold text-[#197B40]">Terpilih</span>
                                    `;
                                } else {
                                    card.className = "flex items-center justify-between p-3 rounded-xl border-2 border-transparent bg-gray-50 hover:border-[#197B40]/50 hover:bg-white cursor-pointer transition-all shadow-sm";
                                    card.innerHTML = `
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-[#fba919] flex items-center justify-center text-white font-extrabold text-sm rounded-full shrink-0">${panelist.initial}</div>
                                            <p class="font-bold text-gray-900 text-sm">${panelist.name}</p>
                                        </div>
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    `;
                                    card.addEventListener('click', () => {
                                        if (selected.length < 3) {
                                            selected.push(panelist);
                                            renderSelected();
                                            fetchPanelists(searchInput.value);
                                        } else {
                                            alert("Maksimal 3 Panelist yang dapat dipilih!");
                                        }
                                    });
                                }
                                resultsContainer.appendChild(card);
                            });
                        })
                        .catch(err => {
                            resultsContainer.innerHTML = '<div class="text-center text-red-500 text-sm mt-4">Gagal memuat data.</div>';
                        });
                }

                if(searchInput) {
                    searchInput.addEventListener('input', function() {
                        clearTimeout(debounceTimer);
                        debounceTimer = setTimeout(() => fetchPanelists(this.value), 300);
                    });
                }

                renderSelected();
                fetchPanelists();
            })();
        </script>
    @endforeach
@endif