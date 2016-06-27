@extends('layouts.master')

@section('content')

    <h2>Vos messages</h2>

    @if(session('success'))
        <p>{{session('success')}}</p>
    @endif

    @if(session('error'))
        <p>{{session('error')}}</p>
    @endif
    <div class="row">
        <div class="messages col-xs-12">
            <div class="row">
                @forelse($messages as $message)
                    <div class="message col-xs-12">
                        @if(!$message->read)
                            <div class="new-msg">nouveau message...</div>
                        @endif
                        <p class="date">{{ $message->created_at->format('d/m/Y à H:i') }}</p>
                        <p>{!! str_limit($message->message, 50) !!}</p>
                        <a href="{{ action('FrontController@message', $message) }}" class="btn btn-default">Voir le
                            message</a>
                    </div>
                @empty
                    <div class="message col-xs-12">
                        <p>Aucun message.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
