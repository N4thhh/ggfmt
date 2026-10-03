@extends('layouts.app')

@section('content')
<div class="mx-6 my-6 bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
    
    <div class="bg-[#197B40] px-8 py-5 flex flex-col md:flex-row justify-between items-center gap-4">
        <h1 class="text-white text-xl font-bold">User Management</h1>
        
        <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
            <a href="{{ route('user.create') }}" class="bg-white text-[#197B40] hover:bg-gray-50 font-bold px-5 py-2 rounded-full text-sm shadow-sm transition flex items-center justify-center gap-2 whitespace-nowrap">
                <i data-lucide="plus" class="w-4 h-4"></i> Create User
            </a>

            <form method="POST" action="{{ route('user.sendInviteAll') }}" class="m-0 w-full md:w-auto">
                @csrf
                <button type="submit" class="w-full bg-[#fba919] hover:bg-orange-500 text-white font-bold px-5 py-2 rounded-full text-sm shadow-sm transition flex items-center justify-center gap-2 whitespace-nowrap">
                    <i data-lucide="mail" class="w-4 h-4"></i> Send Invite to All
                </button>
            </form>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left whitespace-nowrap">
            <thead class="text-xs text-gray-500 uppercase tracking-wider bg-white border-b-2 border-gray-100">
                <tr>
                    <th class="px-8 py-5 font-bold">Name</th>
                    <th class="px-8 py-5 font-bold">Email</th>
                    <th class="px-8 py-5 font-bold text-center">Role</th>
                    <th class="px-8 py-5 font-bold text-center">Action</th>
                </tr>
            </thead>
            
            <tbody>
                @foreach($users as $user)
                <tr class="border-b border-gray-100 hover:bg-gray-50 transition duration-150">
                    
                    <td class="px-8 py-4 font-bold text-gray-800">
                        {{ $user->name }}
                    </td>
                    
                    <td class="px-8 py-4 text-gray-600">
                        {{ $user->email }}
                    </td>
                    
                    <td class="px-8 py-4 text-center">
                        <span class="bg-gray-100 text-gray-700 px-3 py-1.5 rounded-md text-xs font-bold uppercase tracking-wide">
                            {{ $user->role }}
                        </span>
                    </td>
                    
                    <td class="px-8 py-4 text-center">
                        <form method="POST" action="{{ route('user.sendInvite', $user) }}" class="m-0 inline-block">
                            @csrf
                            @if ($user->password == null)
                                <button type="submit" class="bg-[#fba919] hover:bg-orange-500 text-white font-bold px-6 py-2 rounded-full text-xs transition shadow-sm flex items-center justify-center mx-auto gap-2">
                                    <i data-lucide="send" class="w-3.5 h-3.5"></i> Send Invite
                                </button>
                            @else
                                <button type="submit" class="bg-gray-200 text-gray-400 font-bold px-6 py-2 rounded-full text-xs cursor-not-allowed flex items-center justify-center mx-auto gap-2" disabled>
                                    <i data-lucide="check-circle" class="w-3.5 h-3.5"></i> Invited
                                </button>
                            @endif
                        </form>
                    </td>
                    
                </tr>
                @endforeach
                
                @if($users->isEmpty())
                <tr>
                    <td colspan="4" class="px-8 py-10 text-center text-gray-500 font-medium">
                        No Users found.
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection