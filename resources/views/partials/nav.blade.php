<nav class="navbar navbar-default">
    <div class="container-fluid">
        <ul class="nav navbar-nav">
            <li><a href="{{ action('FrontController@home') }}">Bananier</a></li>
            <li><a href="{{ action('FrontController@units') }}">Mon armée</a></li>
            <li><a href="{{ action('FrontController@recruits') }}">Recrutements</a></li>
            <li><a href="{{ action('FrontController@builder') }}">Constructions</a></li>
            <li><a href="#">Technologies</a></li>
            <li><a href="{{ action('FrontController@resources') }}">Récolte</a></li>
            <li><a href="#">Terrain</a></li>
            <li><a href="{{ action('FrontController@map') }}">Jungle</a></li>
            <li><a href="{{ action('FrontController@messages') }}">Messages</a></li>
            <li><a href="#">Aide</a></li>
        </ul>
    </div>
</nav>