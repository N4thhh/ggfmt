<!-- MODAL ASSIGN MT -->
<div id="modal-assign-mt" onclick="if(event.target === this) closeModal('modal-assign-mt')" class="hidden fixed inset-0 bg-black/50 z-50 items-center justify-center p-4 transition-opacity" style="display:none;">
    <div class="bg-white rounded-4xl p-6 w-full max-w-md shadow-xl flex flex-col max-h-[85vh] relative">
        
        <button type="button" onclick="closeModal('modal-assign-mt')" class="absolute top-6 right-6 text-gray-400 hover:text-gray-800 transition-colors bg-gray-50 hover:bg-gray-100 p-1.5 rounded-full">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        <h3 class="font-extrabold text-xl mb-4 pr-8 text-gray-900 shrink-0">Assign MT ke {{ $coach->user->name }}</h3>
        
        <div class="relative mb-4 shrink-0">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            <input type="text" id="mt-search-input" placeholder="Cari nama atau index MT..." class="w-full pl-10 pr-4 py-2.5 border-2 border-gray-100 rounded-xl text-sm font-semibold focus:outline-none focus:border-[#197B40] transition-colors bg-gray-50">
        </div>

        <form method="POST" action="{{ route('coach.assignMt', $coach) }}" class="flex flex-col min-h-0 overflow-hidden">
            @csrf
            
            <input type="hidden" name="mt_id" id="selected-mt-id" required>

            <div id="mt-list-container" class="flex-1 overflow-y-auto custom-scrollbar flex flex-col gap-2 mb-2 p-1 min-h-62.5">
                <div class="flex items-center justify-center h-full text-gray-400 font-semibold text-sm">
                    Memuat data...
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-4 pt-4 border-t border-gray-100 shrink-0">
                <button type="button" onclick="closeModal('modal-assign-mt')" class="px-5 py-2.5 rounded-xl bg-gray-100 text-gray-700 text-sm font-bold hover:bg-gray-200 transition-colors">Batal</button>
                <button type="submit" id="btn-submit-mt" class="px-5 py-2.5 rounded-xl bg-[#197B40] text-white text-sm font-bold hover:bg-[#146032] transition-colors opacity-50 cursor-not-allowed" disabled>Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    (function() {
        const searchInput = document.getElementById('mt-search-input');
        const listContainer = document.getElementById('mt-list-container');
        const hiddenInput = document.getElementById('selected-mt-id');
        const submitBtn = document.getElementById('btn-submit-mt');
        let debounceTimer;

        function fetchMTs(query = '') {
            fetch(`/mts/search?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    listContainer.innerHTML = ''; 
                    
                    if(data.length === 0) {
                        listContainer.innerHTML = `
                            <div class="p-6 text-center text-gray-400 text-sm font-semibold border-2 border-dashed border-gray-200 rounded-xl mt-2">
                                Tidak ada MT yang ditemukan.
                            </div>`;
                        return;
                    }

                    data.forEach(mt => {
                        const isSelected = hiddenInput.value == mt.id;
                        const card = document.createElement('div');
                        
                        card.className = `mt-card flex items-center justify-between p-3 rounded-xl border-2 cursor-pointer transition-all group ${isSelected ? 'border-[#197B40] bg-[#197B40]/5' : 'border-transparent bg-gray-50 hover:border-[#197B40]/50 hover:bg-white shadow-sm'}`;
                        card.onclick = () => selectMT(mt.id, card);

                        card.innerHTML = `
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-[#fba919] flex items-center justify-center text-white font-extrabold text-sm rounded-full shadow-sm shrink-0">
                                    ${mt.initial}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900 text-sm group-hover:text-[#197B40] transition-colors">${mt.name}</p>
                                    <p class="text-xs font-semibold text-gray-500">${mt.index_number}</p>
                                </div>
                            </div>
                            <div class="shrink-0 text-[#197B40] ${isSelected ? 'block' : 'hidden'}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                        `;
                        listContainer.appendChild(card);
                    });
                })
                .catch(error => {
                    listContainer.innerHTML = `<div class="text-red-500 text-sm text-center py-4">Gagal memuat data.</div>`;
                });
        }

        function selectMT(id, cardElement) {
            hiddenInput.value = id;
            
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');

            fetchMTs(searchInput.value);
        }

        if(searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => fetchMTs(this.value), 300);
            });
        }

        fetchMTs();
    })();
</script>