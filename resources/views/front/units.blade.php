@extends('layouts.master')

@section('content')

    <h2>Votre armée</h2>

    <div class="units">

        @foreach($unit_user as $unit)
            <div class="unit">
                {{ $unit->unit->name }}
                {{ $unit->units }}
            </div>
        @endforeach

    </div>


@endsection
