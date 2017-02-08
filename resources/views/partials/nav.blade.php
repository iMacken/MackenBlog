<nav id="site-header" class="navbar">
<div class="container">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-main">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="/">Macken Stack</a>
  </div>

  <div class="navbar-collapse collapse" id="navbar-main">
    <ul class="nav navbar-nav">
        <li><a href="/" title="Home">主页</a></li>
        @if(!empty($navList))
            @foreach($navList as $nav)
                <li><a href="{{ $nav->url }}" title="{{ $nav->name }}">{{ $nav->name }}</a></li>
            @endforeach
        @endif
    </ul>
      @if (Auth::check())
          <ul class="nav navbar-nav navbar-right">
              <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                      <li><a href="{{ route('article.create') }}">写文章</a></li>
                      <li><a href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">登出</a></li>
                      <form id="logout-form" action="{{ route('logout') }}" method="POST"
                            style="display: none;">
                          {{ csrf_field() }}
                      </form>
                  </ul>
              </li>
          </ul>
      @endif
    <form data-pjax class="navbar-form nav navbar-nav navbar-right" role="search" action="{{ url('search') }}">
        {{ csrf_field() }}
        <div class="form-group">
            <input type="text" id="search-keyword" name="keyword" value="{{ $keyword or '' }}" class="form-control" placeholder="搜索">
        </div>
    </form>

  </div>
</div>
</nav>