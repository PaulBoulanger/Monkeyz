@extends('layouts.master')

@section('content')

    <h2>Vos ressources</h2>

    @if(session('success'))
        <p>{{session('success')}}</p>
    @endif

    @if(session('error'))
        <p>{{session('error')}}</p>
    @endif

    <p>Votre territoire s'étend à {{ $fields->fields }} km² !</p>
    <p>Vous avez actuellement {{$fields->units}} ouvrier qui collectents des bananes !</p>
    <p>Ce qui vous fournis {{ round($fields->units / 10) }} bananes par heure.</p>
    <p>Prochain approvisonnement de bananes dans : <span class="timespan"></span></p>
    <script>
        var endTime = new Date('{{ $user->lastIncome() }}');
        $('.timespan').countdown(endTime, function (e) {
            $(this).text(e.strftime('%H:%M:%S'));
        });
        $('.timespan').countdown(endTime).on('finish.countdown', function () {
            document.refresh();
        });
    </script>

    <form action="" method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="">Combien d'ouvrier pour récolter les bananes :</label>
            <input type="text" name="units" value="{{ $fields->units }}">
            <button>Attribuer</button>
        </div>
    </form>

@endsection
