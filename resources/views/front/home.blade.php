@extends('layouts.master')

@section('content')

    <h2>Accueil</h2>

    <p>Votre bananier est positioné en {{ $base->position_x }} x et {{ $base->position_y }} y.</p>
    <div class="buildings">
        <p>Vous avez les bâtiments suivant :</p>
        <ul>
            @foreach($user->buildings()->where('built', 1)->get() as $building)
                <li>{{ $building->name }}</li>
            @endforeach
        </ul>
    </div>
@endsection
