@extends('layouts.master')

@section('content')

    <h2>La jungle</h2>

    @if(session('success'))
        <p>{{session('success')}}</p>
    @endif

    @if(session('error'))
        <p>{{session('error')}}</p>
    @endif

    <div class="bases">

        @foreach($bases as $base)
            <div class="base">
                <div class="user">Ce bananier appartient au joueur : {{ $base->user->name }}</div>
                <div class="position">coordonnées : {{ $base->position_x }} en X et {{ $base->position_y }} en Y.</div>
                @can('loot', $base)
                <form action="{{ action('FrontController@loot', $base) }}" method="post">
                    {{ csrf_field() }}
                    <button>Piller</button>
                </form>
                @endcan
            </div>
        @endforeach
    </div>

@endsection
