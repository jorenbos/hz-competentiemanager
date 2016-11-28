{{-- For all your navigation needs, commented and well, provided by yours truly --}}

{{-- The dank colorscheme --}}
<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">
            <!-- <img alt="HZ" src="HZLOGO.svg"> -->
            HZ Competentiemanager</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            {{-- Maybe loop through extra nav --}}
            @if(Auth::check())
              <li><a href="logout">Logout</a></li>
            @else
              <li><a href="login">Login</a></li>
            @endif

          </div>
        </div><!--/.navbar-collapse -->
      </div>
</nav>
