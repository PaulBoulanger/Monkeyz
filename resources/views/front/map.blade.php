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

        @if($fight)
            <div class="fight">
                <p>Il reste <span class="timespan"></span> secondes avant la bataille contre {{ $fight->enemy() }} !
                </p>
                <script>

                    var endTime = new Date('{{$fight->timeFinished()}}');
                    $('.timespan').countdown(endTime, function (e) {
                        $(this).text(e.strftime('%D %H:%M:%S'));
                    });
                    $('.timespan').countdown(endTime).on('finish.countdown', function () {
                        location.reload();
                    });
                </script>
            </div>
        @endif

        @foreach($bases as $base)
            <div class="base">
                <div class="user">Ce bananier appartient au joueur : {{ $base->user->name }}</div>
                <div class="position">coordonnées : {{ $base->position_x }} en X et {{ $base->position_y }} en Y.</div>
                <div class="power">Ce bananier à une puissance de {{ $base->strength() }}.</div>
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
