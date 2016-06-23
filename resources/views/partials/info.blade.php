<div class="info">
    <div class="name">{{ $user->name }}</div>
    <div class="peon">{{ $peons }} {{ trans_choice('site.peons', $peons) }}</div>
    <div class="bananas">{{ $user->bananas }} {{ trans_choice('site.bananas', $user->bananas) }}</div>
</div>



