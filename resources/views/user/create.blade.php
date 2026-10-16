@extends('layouts.app')

@section('content')
<!-- Menggunakan mx-6 tanpa pembungkus pemusat (justify-center) agar sejajar dengan navbar -->
<div class="mx-6 my-6 pb-10">
    <!-- Menghapus max-w-* dan menggunakan w-full agar membentang penuh -->
    <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 overflow-hidden w-full flex flex-col">

        <!-- ========================================== -->
        <!-- HEADER SECTION                             -->
        <!-- ========================================== -->
        <div class="bg-[#197B40] p-8 md:p-10 flex items-center gap-4 shrink-0">
            <div class="w-12 h-12 bg-[#fba919] rounded-full flex items-center justify-center text-white shadow-sm shrink-0">
                <i data-lucide="user-plus" class="w-6 h-6"></i>
            </div>
            <div>
                <h2 class="text-2xl md:text-3xl font-black text-white tracking-tight">Create New User</h2>
                <p class="text-sm font-semibold text-white/80 mt-1">Add a new member and assign their role in the system</p>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- FORM SECTION                               -->
        <!-- ========================================== -->
        <form method="POST" action="{{ route('user.store') }}" class="p-8 md:p-10 flex flex-col gap-6">
            @csrf

            <!-- Pesan Error Global -->
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 text-sm font-semibold p-4 rounded-xl flex flex-col gap-1 mb-2">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Data Akun Dasar -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex flex-col gap-1.5">
                    <label for="name" class="text-xs font-extrabold text-gray-500 uppercase tracking-wide">Full Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Enter full name"
                           class="w-full border-2 border-gray-100 rounded-xl p-3 text-sm font-semibold text-gray-800 focus:outline-none focus:border-[#197B40] bg-gray-50 focus:bg-white transition-colors" required>
                </div>
                <div class="flex flex-col gap-1.5">
                    <label for="email" class="text-xs font-extrabold text-gray-500 uppercase tracking-wide">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Enter email address"
                           class="w-full border-2 border-gray-100 rounded-xl p-3 text-sm font-semibold text-gray-800 focus:outline-none focus:border-[#197B40] bg-gray-50 focus:bg-white transition-colors" required>
                </div>
            </div>

            <!-- Role & Index Number -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex flex-col gap-1.5">
                    <label for="role" class="text-xs font-extrabold text-gray-500 uppercase tracking-wide">System Role</label>
                    <select id="role" name="role" onchange="toggleRoleFields()"
                            class="w-full border-2 border-gray-100 rounded-xl p-3 text-sm font-semibold text-gray-800 focus:outline-none focus:border-[#197B40] bg-gray-50 transition-colors cursor-pointer" required>
                        <option value="mt" {{ old('role', 'mt') === 'mt' ? 'selected' : '' }}>Management Trainee</option>
                        <option value="panelist" {{ old('role') === 'panelist' ? 'selected' : '' }}>Panelist</option>
                        <option value="coach" {{ old('role') === 'coach' ? 'selected' : '' }}>Coach</option>
                    </select>
                </div>
                <div class="flex flex-col gap-1.5">
                    <label for="index_number" class="text-xs font-extrabold text-gray-500 uppercase tracking-wide">Index Number</label>
                    <input type="text" id="index_number" name="index_number" value="{{ old('index_number') }}" placeholder="e.g. MT001"
                           class="w-full border-2 border-gray-100 rounded-xl p-3 text-sm font-semibold text-gray-800 focus:outline-none focus:border-[#197B40] bg-gray-50 focus:bg-white transition-colors" required>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- MT SPECIFIC FIELDS (3x3 Grid)              -->
            <!-- ========================================== -->
            <div id="fields-mt" class="hidden flex-col gap-5 mt-2 p-6 border-2 border-dashed border-gray-200 bg-gray-50/50 rounded-2xl">
                
                <h3 class="font-extrabold text-gray-800 text-sm uppercase tracking-wider flex items-center gap-2 border-b border-gray-200 pb-3">
                    <i data-lucide="graduation-cap" class="w-4 h-4 text-[#197B40]"></i> Management Trainee Data
                </h3>

                <!-- Grid 3 Kolom untuk 9 Field MT -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    
                    <!-- Kolom 1 -->
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-extrabold text-gray-500 uppercase tracking-wide">Program</label>
                        <select name="mt_program_id" class="w-full border-2 border-gray-100 rounded-xl p-3 text-sm font-semibold text-gray-800 focus:outline-none focus:border-[#197B40] bg-white transition-colors cursor-pointer">
                            <option value="">-- Select Program --</option>
                            @foreach (\App\Models\MtProgram::all() as $program)
                                <option value="{{ $program->id }}" {{ old('mt_program_id') === $program->id ? 'selected' : '' }}>
                                    {{ $program->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Kolom 2 -->
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-extrabold text-gray-500 uppercase tracking-wide">Batch</label>
                        <input type="text" name="batch" value="{{ old('batch') }}" placeholder="e.g. 9.1"
                               class="w-full border-2 border-gray-100 rounded-xl p-3 text-sm font-semibold text-gray-800 focus:outline-none focus:border-[#197B40] bg-white transition-colors">
                    </div>

                    <!-- Kolom 3 -->
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-extrabold text-gray-500 uppercase tracking-wide">MBTI</label>
                        <input type="text" name="mbti" value="{{ old('mbti') }}" placeholder="e.g. ISTJ"
                               class="w-full border-2 border-gray-100 rounded-xl p-3 text-sm font-semibold text-gray-800 focus:outline-none focus:border-[#197B40] bg-white transition-colors">
                    </div>

                    <!-- Kolom 4 -->
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-extrabold text-gray-500 uppercase tracking-wide">Major</label>
                        <input type="text" name="major" value="{{ old('major') }}" placeholder="e.g. Informatics"
                               class="w-full border-2 border-gray-100 rounded-xl p-3 text-sm font-semibold text-gray-800 focus:outline-none focus:border-[#197B40] bg-white transition-colors">
                    </div>

                    <!-- Kolom 5 -->
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-extrabold text-gray-500 uppercase tracking-wide">University</label>
                        <input type="text" name="university" value="{{ old('university') }}" placeholder="e.g. Universitas Lampung"
                               class="w-full border-2 border-gray-100 rounded-xl p-3 text-sm font-semibold text-gray-800 focus:outline-none focus:border-[#197B40] bg-white transition-colors">
                    </div>

                    <!-- Kolom 6 -->
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-extrabold text-gray-500 uppercase tracking-wide">Education Degree</label>
                        <select name="education_degree" class="w-full border-2 border-gray-100 rounded-xl p-3 text-sm font-semibold text-gray-800 focus:outline-none focus:border-[#197B40] bg-white transition-colors cursor-pointer">
                            <option value="">-- Select Degree --</option>
                            @foreach (['S1','S2','S3','D1','D2','D3','D4'] as $degree)
                                <option value="{{ $degree }}" {{ old('education_degree') === $degree ? 'selected' : '' }}>{{ $degree }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Kolom 7 -->
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-extrabold text-gray-500 uppercase tracking-wide">Placement</label>
                        <input type="text" name="placement" value="{{ old('placement') }}" placeholder="e.g. IT Department"
                               class="w-full border-2 border-gray-100 rounded-xl p-3 text-sm font-semibold text-gray-800 focus:outline-none focus:border-[#197B40] bg-white transition-colors">
                    </div>

                    <!-- Kolom 8 -->
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-extrabold text-gray-500 uppercase tracking-wide">Program Leader</label>
                        <input type="text" name="program_leader" value="{{ old('program_leader') }}" placeholder="Enter leader name"
                               class="w-full border-2 border-gray-100 rounded-xl p-3 text-sm font-semibold text-gray-800 focus:outline-none focus:border-[#197B40] bg-white transition-colors">
                    </div>

                    <!-- Kolom 9 -->
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-extrabold text-gray-500 uppercase tracking-wide">Assignment Leader</label>
                        <input type="text" name="assignment_leader" value="{{ old('assignment_leader') }}" placeholder="Enter leader name"
                               class="w-full border-2 border-gray-100 rounded-xl p-3 text-sm font-semibold text-gray-800 focus:outline-none focus:border-[#197B40] bg-white transition-colors">
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex justify-end gap-3 mt-4 pt-6 border-t border-gray-100">
                <a href="{{ route('user.index') }}" class="px-6 py-3 rounded-xl bg-gray-100 text-gray-700 text-sm font-extrabold hover:bg-gray-200 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-8 py-3 rounded-xl bg-[#197B40] hover:bg-[#146032] text-white text-sm font-extrabold shadow-md transition-all tracking-wide">
                    Create User
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleRoleFields() {
        const role = document.getElementById('role').value;
        const mtFields = document.getElementById('fields-mt');
        
        if (role === 'mt') {
            mtFields.classList.remove('hidden');
            mtFields.classList.add('flex');
        } else {
            mtFields.classList.add('hidden');
            mtFields.classList.remove('flex');
            
            const mtInputs = mtFields.querySelectorAll('input, select');
            mtInputs.forEach(input => {
                if(input.name !== 'role') input.value = '';
            });
        }
    }
    document.addEventListener('DOMContentLoaded', toggleRoleFields);
</script>
@endsection