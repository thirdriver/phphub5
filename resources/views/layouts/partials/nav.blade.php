<div role="navigation" class="navbar navbar-default navbar-static-top topnav">
  <div class="container">
    <div class="navbar-header">

      <a href="/" class="navbar-brand">PHPHub</a>
    </div>
    <div id="top-navbar-collapse" class="navbar-collapse">
      <ul class="nav navbar-nav">
        <li class="{{ (Request::is('topics*') ? ' active' : '') }}"><a href="{{ route('topics.index') }}">{{ lang('Topics') }}</a></li>
        <li class="{{ (Request::is('categories/1') ? ' active' : '') }}"><a href="{{ route('categories.show', 1) }}">{{ lang('Jobs') }}</a></li>
        <li class="{{ (Request::is('categories/5') ? ' active' : '') }}"><a href="{{ route('categories.show', 5) }}">{{ lang('Share') }}</a></li>
        <li class="{{ (Request::is('categories/4') ? ' active' : '') }}"><a href="{{ route('categories.show', 4) }}">{{ lang('Q&A') }}</a></li>
      </ul>

      <div class="navbar-right">
          <form method="GET" action="{{route('search')}}" accept-charset="UTF-8" class="navbar-form navbar-left" target="_blank">
            <div class="form-group">
            <input class="form-control search-input mac-style" placeholder="{{lang('Search')}}" name="q" type="text">
            </div>
          </form>

        <ul class="nav navbar-nav github-login" >
          @if (Auth::check())
              <li>
                  <a href="{{ route('notifications.index') }}" class="text-warning">
                      <span class="badge badge-{{ $currentUser->notification_count > 0 ? 'important' : 'fade' }}" id="notification-count">
                          {{ $currentUser->notification_count }}
                      </span>
                  </a>
              </li>

                @if (Auth::user()->can('visit_admin'))
              <li>
                  <a href="/admin">
                      <i class="fa fa-tachometer"></i>
                  </a>
              </li>
                @endif

              <li>
                  <a href="{{ route('users.show', $currentUser->id) }}">
                      <img class="avatar-topnav" alt="Summer" src="{{ $currentUser->present()->gravatar }}">
                       {{{ $currentUser->name }}}
                  </a>
              </li>
              <li>
                  <a id="login-out" class="button" href="{{ URL::route('logout') }}" data-lang-loginout="{{ lang('Are you sure want to logout?') }}">
                      <i class="fa fa-sign-out"></i> {{ lang('Logout') }}
                  </a>
              </li>
          @else
              <a href="{{ URL::route('login') }}" class="btn btn-info" id="login-btn">
                <i class="fa fa-github-alt"></i>
                {{ lang('Login') }}
              </a>
          @endif
        </ul>
      </div>
    </div>

  </div>
</div>
