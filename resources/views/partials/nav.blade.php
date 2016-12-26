<nav id="site-header" class="navbar navbar-default">
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
    <form data-pjax class="navbar-form nav navbar-nav navbar-right" role="search" action="{{ url('search') }}">
        {{ csrf_field() }}
        <div class="form-group">
            <input type="text" id="search-keyword" name="keyword" value="{{ $keyword or '' }}" class="form-control" placeholder="输入关键字 回车搜索">
        </div>
        <button type="submit" class="btn btn-default fa fa-search"></button>
    </form>
  </div>
</div>
</nav>