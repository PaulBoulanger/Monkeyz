@extends('layouts.master')

@section('content')

    <h2>Message #{{ $message->id }}</h2>

    @if(session('success'))
        <p>{{session('success')}}</p>
    @endif

    @if(session('error'))
        <p>{{session('error')}}</p>
    @endif
    <div class="row">
        <div class="message col-xs-12">
            @if(!$message->read)
                <div class="new-msg">nouveau message...</div>
            @endif
            <p class="date">{{ $message->created_at->format('d/m/Y à H:i') }}</p>
            <p>{!! $message->message !!}</p>
            <a href="">Supprimer ce message</a>
        </div>
    </div>
@endsection
