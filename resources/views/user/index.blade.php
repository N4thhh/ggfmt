@extends('layouts.app')
@section('content')
<div class="grid grid-cols-4 md:grid-cols-4 grid-rows-4 md:grid-rows-5 gap-2 md:gap-2 m-4">
    <div class="col-start-1 row-start-1 col-span-4 md:col-start-1 md:row-start-1 md:col-span-4 md:row-span-1 bg-gray-300 rounded-md p-10">
        <a href="{{ route('user.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Create User
        </a>

        <form method="POST" action="{{ route('user.sendInviteAll') }}">
            @csrf
            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                Send Invite to All
            </button>
        </form>
    </div>
      
    <div class="col-start-1 row-start-2 col-span-4 row-span-3 md:col-start-1 md:row-start-2 md:col-span-4 md:row-span-4 bg-gray-300 rounded-md p-10">
        <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>
                    {{$user->name}}
                </td>
                <td>
                    {{$user->email}}
                </td>
                <td>
                    {{$user->role}}
                </td>
                <td>
                    <form method="POST" action="{{ route('user.sendInvite', $user) }}">
                    @csrf
                    @if ($user->password == null)
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Send Invite
                        </button>
                    @else
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" disabled>
                            Send Invite
                        </button>
                    @endif
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
        </table>
    </div>
      
</div>
@endsection