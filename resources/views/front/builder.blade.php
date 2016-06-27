@extends('layouts.master')

@section('content')

    <h2>Construction</h2>

    @if(session('success'))
        <p>{{session('success')}}</p>
    @endif

    @if(session('error'))
        <p>{{session('error')}}</p>
    @endif


    @if($builts)
        <div class="builts">
            <script>
                var timespan = [];
            </script>
            @foreach($builts as $index => $built)
                <div class="built">
                    {{ $built->name }} | Temps requis : {{ $built->requireTime() }} |
                    Temps restant : <span class="timespan-{{$index}}"></span>
                </div>
                <script>

                    var endTime = new Date('{{$built->timeFinished($user)}}');
                    $('.timespan-{{$index}}').countdown(endTime, function (e) {
                        $(this).text(e.strftime('%D %H:%M:%S'));
                    });
                    $('.timespan-{{$index}}').countdown(endTime).on('finish.countdown', function () {
                        $(this).parent('.built').remove();
                    });
                </script>

            @endforeach
        </div>
    @endif



    <div class="buildings">
        @foreach($buildings as $building)

                @can('can', $building)
                <div class="building">
                    <p class="name">{{ $building->name }}</p>
                    <p class="wood">{{ $building->wood }} bois</p>
                    <p class="time">{{ $building->time }}</p>
                    <form action="{{ action('FrontController@built', $building->id) }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <button>Construire</button>
                        </div>
                    </form>
                </div>
                @endcan

        @endforeach
    </div>

@endsection
