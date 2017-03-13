<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            @if(! Auth::check())

            <a class="navbar-brand logo-size" href="/"><b>Admin</b> DASH</a>

            @else

            <a class="navbar-brand logo-size" href="/home"><b>Admin</b> DASH</a>

            @endif

        </div>
        <div id="navbar" class="collapse navbar-collapse pull-right">
            <ul class="nav navbar-nav">

                @if(! Auth::check())

                <li><a href="/register" ><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                <li><a href="/login"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                <li><a href="/auth/facebook" title="Facebook"><i class="fa fa-facebook"></i></a></li>
                @if(! empty(env('TWITTER_URL')) )
                <li><a href="/auth/twitter" title="Twitter"><i class="fa fa-twitter"></i></a></li>
                @endif
                @if(! empty(env('GOOGLE_URL')) )
                <li><a href="/auth/google" title="Google"><i class="fa fa-google"></i></a></li>
                @endif
                @if(! empty(env('GITHUB_URL')) )
                <li><a href="/auth/github" title="GitHub"><i class="fa fa-github"></i></a></li>
                @endif

                @endif

            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>
