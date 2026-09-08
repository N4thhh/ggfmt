@extends('layouts.app')

@section('content')
<div class="grid grid-cols-4 md:grid-cols-3 grid-rows-4 md:grid-rows-4 gap-2 md:gap-2 m-4">
    <div class="col-start-1 row-start-1 col-span-4 row-span-4 md:col-start-1 md:row-start-1 md:col-span-3 md:row-span-4 bg-gray-300 rounded-md p-10">
        <table>
            <thead>
                <tr>
                    <th>Index</th>
                    <th>Name</th>
                    <th>Number of MTs</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($coaches as $coach)
                <tr>
                    <td>
                        {{$coach->index_number}}
                    </td>
                    <td>
                        {{$coach->user->name}}
                    </td>
                    <td>
                        {{ count($coach->coachHistory()->where('ended_at', null)->get() )}}
                    </td>
                    <td>
                        <a href="{{ route('coach.show', $coach) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            View
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
      
    </div>
@endsection