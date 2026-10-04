@extends('layouts.app')

@section('content')
<div class="mx-6 my-6 bg-white rounded-4xl shadow-sm border border-gray-100 overflow-hidden">
    
    <div class="bg-[#197B40] px-8 py-5 flex flex-col md:flex-row justify-between items-center gap-4">
        <h1 class="text-white text-xl font-bold">Panelists</h1>
        
        <div class="flex gap-3 w-full md:w-auto">
            <div class="bg-white rounded-full flex items-center px-4 py-2 w-full md:w-64 shadow-inner">
                <i data-lucide="search" class="w-4 h-4 text-gray-400 mr-2"></i>
                <input type="text" placeholder="Search panelist..." class="outline-none text-sm w-full text-gray-700 bg-transparent">
            </div>
            
            <button class="bg-[#fba919] rounded-full px-5 py-2 text-white font-bold text-sm flex items-center gap-2 shadow-sm hover:bg-orange-500 transition whitespace-nowrap">
                <i data-lucide="filter" class="w-4 h-4"></i> Filters
            </button>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left whitespace-nowrap">
            <thead class="text-xs text-gray-500 uppercase tracking-wider bg-white border-b-2 border-gray-100">
                <tr>
                    <th class="px-8 py-5 font-bold">Index</th>
                    <th class="px-8 py-5 font-bold">Name</th>
                    <th class="px-8 py-5 font-bold text-center">Actions</th>
                </tr>
            </thead>
            
            <tbody>
                @foreach($panelists as $panelist)
                <tr class="border-b border-gray-100 hover:bg-gray-50 transition duration-150">
                    
                    <td class="px-8 py-4 font-medium text-gray-900">
                        {{ $panelist->index_number }}
                    </td>
                    
                    <td class="px-8 py-4 font-bold text-gray-800">
                        {{ $panelist->user->name }}
                    </td>
                    
                    <td class="px-8 py-4 text-center">
                        <a href="{{ route('panelist.show', $panelist) }}" class="inline-block bg-[#fba919] hover:bg-orange-500 text-white font-bold px-6 py-2 rounded-full text-xs transition shadow-sm">
                            View Details
                        </a>
                    </td>
                    
                </tr>
                @endforeach
                
                @if($panelists->isEmpty())
                <tr>
                    <td colspan="3" class="px-8 py-10 text-center text-gray-500 font-medium">
                        No Panelists found.
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection