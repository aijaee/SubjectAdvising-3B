@extends('layouts.app')

@section('content')
    <h2>Your Marks</h2>
    {{-- Display marks --}}
    <ul>
        @foreach($marks as $mark)
            <li>{{ $mark->course->name }}: {{ $mark->score }}</li>
        @endforeach
    </ul>
@endsection
