@extends('layouts.master')

@section('content')

    <h2>Vos ressources</h2>

    <p>Votre territoire s'étend à {{ $fields->fields }} km² !</p>
    <p>Vous avez actuellement {{$fields->units}} ouvrier qui collectents des bananes !</p>
    <p>Ce qui vous fournis {{ round($fields->units / 10) }} bananes par heure.</p>

@endsection
