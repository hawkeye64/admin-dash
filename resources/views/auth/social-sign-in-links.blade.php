<div class="social-auth-links text-center">

    <p>- OR -</p>

    <a href="/auth/facebook"
       class="btn btn-block btn-social btn-facebook btn-flat">

       <i class="fa fa-facebook"></i>

       Sign in using Facebook

    </a>

    @if(! empty(env('TWITTER_URL')) )
    <a href="/auth/twitter"
       class="btn btn-block btn-social btn-twitter btn-flat">

       <i class="fa fa-twitter"></i>

       Sign in using Twitter

    </a>
    @endif

    @if(! empty(env('GOOGLE_URL')) )
    <a href="/auth/google"
       class="btn btn-block btn-social btn-google btn-flat">

       <i class="fa fa-google"></i>

       Sign in using Google

    </a>
    @endif

    @if(! empty(env('GITHUB_URL')) )
    <a href="/auth/github"
       class="btn btn-block btn-social btn-github">

        <i class="fa fa-github"></i>

        Sign in with GitHub

    </a>
    @endif

</div>
