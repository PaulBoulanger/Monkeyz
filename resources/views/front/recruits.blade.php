@extends('layouts.master')

@section('content')
    <h2>Singeries</h2>

    @if(session('success'))
        <p>{{session('success')}}</p>
    @endif

    @if(session('error'))
        <p>{{session('error')}}</p>
    @endif

    @if($recruits)
        <div class="recruits">
            <script>
                var timespan = [];
            </script>
            @foreach($recruits as $index => $recruit)
                <div class="recruit">
                    {{ $recruit->units }} {{ $recruit->unit->name() }} | Temps requis : {{ $recruit->requireTime() }} | Temps restant : <span class="timespan-{{$index}}"></span>
                </div>
                <script>
                    var endTime = new Date('{{$recruit->finished_at->format('Y/m/d h:i:s')}}');
                    $('.timespan-{{$index}}').countdown(endTime, function (e) {
                        $(this).text(e.strftime('%D %H:%M:%S'));
                    });
                    $('.timespan-{{$index}}').countdown(endTime).on('finish.countdown', function () {
                        $(this).parent('.recruit').remove();
                    });
                </script>

            @endforeach
        </div>
    @endif

    <div class="units">
        @foreach($units as $unit)
            <div class="unit">
                <div class="name">{{ $unit->name() }}</div>
                @if( $unit->endurance != 0 && $unit->strength != 0 && $unit->agility != 0 )
                    <div class="statistics">
                        <div class="endurance"><span class="icon-endurance"></span> {{ $unit->endurance }}</div>
                        <div class="strength"><span class="icon-strength"></span> {{ $unit->strength }}</div>
                        <div class="agility"><span class="icon-agility"></span> {{ $unit->agility }}</div>
                    </div>
                @endif
                <div class="image">{{ $unit->image }}</div>
                <div class="resources">
                    <div class="time"><span class="icon-time">{{ $unit->time }} sec</div>
                    <div class="bananas"><span class="icon-bananas"> {{ $unit->bananas }}</div>
                    @can('recruit', $unit)
                    <form action="" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="text" name="number">
                            <input type="hidden" name="unit" value="{{ $unit->id }}">
                            <button>Recruter</button>
                        </div>
                    </form>
                    @endcan
                </div>

            </div>
        @endforeach
    </div>
@endsection
