<div class="navbar navbar-default">

  <nav class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/">
        <img src="/img/hz.png" class="brand-logo" />
        <div class="brand-name">HZ Competentie Dashboard</div>
      </a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

      <ul class="nav navbar-nav navbar-right">
        @if(!Auth::guest())
          <li><a href="/projects">Projecten</a></li>
          <li><a href="/competencies">Competenties</a></li>
          <li><a href='student/1/competencies'>Student Competenties</a></li>
          <li><a href='/demand'>Competentiebehoefte</a></li>
        @endif
        @if(Auth::guest())
          <li><a href="/login">Inloggen</a></li>
        @else
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{Auth::user()->name}} <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="#">Mijn projecten</a></li>
              <li><a href="#">Instellingen</a></li>
              <li role="separator" class="divider"></li>
              <li>
                <a href="{{ url('/logout') }}"
                   onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                    Uitloggen
                </a>
                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
              </li>
            </ul>
          </li>
        @endif

      </ul>
    </div><!-- /.navbar-collapse -->
  </nav>

</div>
