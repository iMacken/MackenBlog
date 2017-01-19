<nav class="navbar navbar-default navbar-inverse">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/backend">麦肯博客</a>
			</div>
			@if (Auth::check())
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="{{ route('admin.user.index') }}">用户管理</a></li>
					<li>
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">内容管理<span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li>
					            <a href="{{ route('admin.category.index') }}">分类管理</a>
					        </li>
					        <li>
					            <a href="{{ route('admin.article.index') }}">文章管理</a>
					        </li>
					        <li>
					            <a href="{{ route('admin.tag.index') }}">标签管理</a>
					        </li>
				            <li>
				                <a href="{{ route('admin.link.index') }}">友链管理</a>
				            </li>
						</ul>
					</li>
					<li><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">系统设置<span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li>
				                <a href="{{ action('SettingController@index') }}">基本设置</a>
				            </li>
				            <li>
				                <a href="{{ route('admin.navigation.index') }}">导航设置</a>
				            </li>
						</ul>
					</li>
				</ul>
				@endif
				<ul class="nav navbar-nav navbar-right">
					@if (Auth::check())
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="{{ url('/backend/auth/logout') }}">登出</a></li>
							</ul>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>