<div id="modal-coach" onclick="if(event.target === this) closeModal('modal-coach')" class="hidden fixed inset-0 bg-black/50 z-50 items-center justify-center p-4 transition-opacity" style="display:none;">
    <div class="bg-white rounded-4xl p-6 w-full max-w-md shadow-xl flex flex-col max-h-[85vh] relative">
        
        <button type="button" onclick="closeModal('modal-coach')" class="absolute top-6 right-6 text-gray-400 hover:text-gray-800 transition-colors bg-gray-50 hover:bg-gray-100 p-1.5 rounded-full">
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>

        <h3 class="font-extrabold text-xl mb-4 pr-8 text-gray-900 shrink-0">Assign Coach</h3>
        
        <div class="relative mb-4 shrink-0">
            <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
            <input type="text" id="coach-search-input" placeholder="Search coach name..." class="w-full pl-10 pr-4 py-2.5 border-2 border-gray-100 rounded-xl text-sm font-semibold focus:outline-none focus:border-[#197B40] transition-colors bg-gray-50">
        </div>

        <form method="POST" action="{{ route('mt.assignCoach', $managementTrainee) }}" class="flex flex-col min-h-0 overflow-hidden">
            @csrf
            <input type="hidden" name="coach_id" id="selected-coach-id" required>

            <div id="coach-list-container" class="flex-1 overflow-y-auto custom-scrollbar flex flex-col gap-2 mb-2 p-1 min-h-62.5">
                <div class="flex items-center justify-center h-full text-gray-400 font-semibold text-sm">
                    Memuat data...
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-4 pt-4 border-t border-gray-100 shrink-0">
                <button type="button" onclick="closeModal('modal-coach')" class="px-5 py-2.5 rounded-xl bg-gray-100 text-gray-700 text-sm font-bold hover:bg-gray-200 transition-colors">Batal</button>
                <button type="submit" id="btn-submit-coach" class="px-5 py-2.5 rounded-xl bg-[#197B40] text-white text-sm font-bold hover:bg-[#146032] transition-colors opacity-50 cursor-not-allowed" disabled>Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('coach-search-input');
        const listContainer = document.getElementById('coach-list-container');
        const hiddenInput = document.getElementById('selected-coach-id');
        const submitBtn = document.getElementById('btn-submit-coach');
        let debounceTimer;

        function fetchCoaches(query = '') {
            fetch(`/coaches/search?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    listContainer.innerHTML = '';
                    
                    if(data.length === 0) {
                        listContainer.innerHTML = `
                            <div class="p-6 text-center text-gray-400 text-sm font-semibold border-2 border-dashed border-gray-200 rounded-xl mt-2">
                                Tidak ada Coach yang ditemukan.
                            </div>`;
                        return;
                    }

                    data.forEach(coach => {
                        const isSelected = hiddenInput.value == coach.id;
                        const card = document.createElement('div');
                        
                        card.className = `coach-card flex items-center justify-between p-3 rounded-xl border-2 cursor-pointer transition-all group ${isSelected ? 'border-[#197B40] bg-[#197B40]/5' : 'border-transparent bg-gray-50 hover:border-[#197B40]/50 hover:bg-white shadow-sm'}`;
                        card.onclick = () => selectCoach(coach.id, card);

                        card.innerHTML = `
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-[#fba919] flex items-center justify-center text-white font-extrabold text-sm rounded-full shadow-sm shrink-0">
                                    ${coach.initial}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900 text-sm group-hover:text-[#197B40] transition-colors">${coach.name}</p>
                                </div>
                            </div>
                            <div class="text-right shrink-0">
                                <span class="inline-block bg-white border border-gray-200 text-gray-600 text-xs font-bold px-2.5 py-1 rounded-md shadow-sm">
                                    ${coach.mt_count} MTs
                                </span>
                            </div>
                        `;
                        listContainer.appendChild(card);
                    });
                })
                .catch(error => {
                    listContainer.innerHTML = `<div class="text-red-500 text-sm text-center py-4">Gagal memuat data.</div>`;
                });
        }

        function selectCoach(id, cardElement) {
            hiddenInput.value = id;
            
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');

            document.querySelectorAll('.coach-card').forEach(el => {
                el.classList.remove('border-[#197B40]', 'bg-[#197B40]/5');
                el.classList.add('border-transparent', 'bg-gray-50');
            });

            cardElement.classList.remove('border-transparent', 'bg-gray-50');
            cardElement.classList.add('border-[#197B40]', 'bg-[#197B40]/5');
        }

        searchInput.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => fetchCoaches(this.value), 300);
        });

        fetchCoaches();
    });
</script>