<div class="info">
    <div class="name">{{ $user->name }}</div>
    <div class="peon">{{ $peons }} {{ trans_choice('site.peons', $peons) }}</div>
    <div class="bananas">{{ $user->bananas }} {{ trans_choice('site.bananas', $user->bananas) }}</div>
    <div class="bananas">{{ $user->wood }} {{ trans_choice('site.woods', $user->wood) }}</div>
    @if($countMessages)
        <div class="messages">Vous avez {{ $countMessages }} {{ trans_choice('site.newMsg', $countMessages) }} <a href="{{ action('FrontController@messages') }}" class="btn btn-default">Voir les messages</a></div>
    @endif
</div>



