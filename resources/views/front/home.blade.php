@extends('layouts.master')

@section('content')

    <h2>Accueil</h2>

    <p>Votre bananier est positioné en {{ $base->position_x }} x et {{ $base->position_y }} y.</p>

@endsection
