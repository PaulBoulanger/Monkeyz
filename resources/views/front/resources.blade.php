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
    <p>Vous avez actuellement {{$fields->units}} singes ouvriers qui collectent des bananes !</p>
    <p>Ce qui vous fournis {{ $user->incomeBanana() }} bananes par heure.</p>
    <p>Ce qui vous fournis {{ $user->incomeWood() }} bois par heure.</p>
    <p>Prochain approvisonnement de ressources dans : <span class="timespan"></span></p>
    <script>
        var endTime = new Date('{{ $user->nextIncome()->format('Y/m/d H:i:s') }}');
        $('.timespan').countdown(endTime, function (e) {
            $(this).text(e.strftime('%H:%M:%S'));
        });
        $('.timespan').countdown(endTime).on('finish.countdown', function () {
            location.reload();
        });
    </script>

    <form action="" method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="">Combien de singes ouvriers pour récolter les bananes :</label>
            <input type="text" name="units_banana" value="{{ $fields->units_banana }}">
        </div>
        <div class="form-group">
            <label for="">Combien de singes ouvriers pour récolter du bois :</label>
            <input type="text" name="units_wood" value="{{ $fields->units_wood }}">
        </div>
        <div class="form-group">
            <button>Attribuer</button>
        </div>
    </form>

@endsection
