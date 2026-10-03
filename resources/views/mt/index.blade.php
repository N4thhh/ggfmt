@extends('layouts.app')

@section('content')
<div class="mx-6 my-6 bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
    
    <!-- Top Header Bar -->
    <div class="bg-[#197B40] px-8 py-5 flex flex-col md:flex-row justify-between items-center gap-4">
        <h1 class="text-white text-xl font-bold">Management Trainees</h1>
        
        <!-- Search and Filter Actions -->
        <div class="flex gap-3 w-full md:w-auto">
            <!-- Search Bar -->
            <div class="bg-white rounded-full flex items-center px-4 py-2 w-full md:w-64 shadow-inner">
                <i data-lucide="search" class="w-4 h-4 text-gray-400 mr-2"></i>
                <input type="text" placeholder="Search trainee..." class="outline-none text-sm w-full text-gray-700 bg-transparent">
            </div>
            
            <!-- Filter Button -->
            <button class="bg-[#fba919] rounded-full px-5 py-2 text-white font-bold text-sm flex items-center gap-2 shadow-sm hover:bg-gray-50 transition whitespace-nowrap">
                <i data-lucide="filter" class="w-4 h-4"></i> Filters
            </button>
        </div>
    </div>

    <!-- Table Section -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left whitespace-nowrap">
            <!-- Table Headers -->
            <thead class="text-xs text-gray-500 uppercase tracking-wider bg-white border-b-2 border-gray-100">
                <tr>
                    <th class="px-8 py-5 font-bold">Index</th>
                    <th class="px-8 py-5 font-bold">Name</th>
                    <th class="px-8 py-5 font-bold">Program</th>
                    <th class="px-8 py-5 font-bold text-center">Batch</th>
                    <th class="px-8 py-5 font-bold text-center">Status</th>
                    <th class="px-8 py-5 font-bold text-center">Action</th>
                </tr>
            </thead>
            
            <!-- Table Body -->
            <tbody>
                @foreach($managementTrainees as $mt)
                <tr class="border-b border-gray-100 hover:bg-gray-50 transition duration-150">
                    
                    <!-- Index -->
                    <td class="px-8 py-4 font-medium text-gray-900">
                        {{ $mt->index_number }}
                    </td>
                    
                    <!-- Name -->
                    <td class="px-8 py-4 font-bold text-gray-800">
                        {{ $mt->user->name }}
                    </td>
                    
                    <!-- Program -->
                    <td class="px-8 py-4 text-gray-600">
                        {{ $mt->mtProgram->name }}
                    </td>
                    
                    <!-- Batch -->
                    <td class="px-8 py-4 text-center font-medium text-gray-700">
                        {{ $mt->batch }}
                    </td>
                    
                    <!-- Status Badge -->
                    <td class="px-8 py-4 text-center">
                        @php
                            $status = strtolower($mt->status);
                            $badgeClass = 'bg-gray-100 text-gray-700'; // Default
                            
                            if ($status === 'active') {
                                $badgeClass = 'bg-blue-100 text-blue-800';
                            } elseif ($status === 'graduate') {
                                $badgeClass = 'bg-green-100 text-green-800';
                            } elseif ($status === 'failed' || $status === 'withdraw') {
                                $badgeClass = 'bg-red-100 text-red-800';
                            }
                        @endphp
                        <span class="px-3 py-1.5 rounded-md text-xs font-bold {{ $badgeClass }}">
                            {{ ucfirst($mt->status) }}
                        </span>
                    </td>
                    
                    <!-- Action Button -->
                    <td class="px-8 py-4 text-center">
                        <a href="{{ route('mt.show', $mt->id) }}" class="inline-block bg-[#fba919] hover:bg-orange-500 text-white font-bold px-6 py-2 rounded-full text-xs transition shadow-sm">
                            View Details
                        </a>
                    </td>
                    
                </tr>
                @endforeach
                
                <!-- Fallback if empty -->
                @if($managementTrainees->isEmpty())
                <tr>
                    <td colspan="6" class="px-8 py-10 text-center text-gray-500 font-medium">
                        No Management Trainees found.
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection