<div class="side-menu sidebar-inverse">
    <nav class="navbar navbar-default" role="navigation">
        <div class="side-menu-container">
            <div class="navbar-header">
                <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                    <div class="logo-icon-container">
                        <?php $admin_logo_img = Admin::setting('admin_icon_image', ''); ?>
                        @if($admin_logo_img == '')
                            <img src="{{ admin_asset('images/logo-icon-light.png') }}" alt="Logo Icon">
                        @else
                            <img src="{{ Admin::image($admin_logo_img) }}" alt="Logo Icon">
                        @endif
                    </div>
                    <div class="title">{{Admin::setting('admin_title', 'ADMIN')}}</div>
                </a>
            </div><!-- .navbar-header -->

            <div class="panel widget center bgimage"
                 style="background-image:url({{ Admin::image( Admin::setting('admin_bg_image'), config('admin.assets_path') . '/images/bg.jpg' ) }});">
                <div class="dimmer"></div>
                <div class="panel-content">
                    @php $user = Auth::user(); @endphp
                    @if($user)
                        <img src="{{ $user_avatar }}" class="avatar" alt="{{ Auth::user()->name }} avatar">
                        <h4>{{ ucwords(Auth::user()->name) }}</h4>
                        <p>{{ Auth::user()->email }}</p>
                    @else
                        <img src="{{ $user_avatar }}" class="avatar" alt="avatar">
                        <h4>临时登录</h4>
                    @endif
                    <a href="{{ route('admin.profile') }}" class="btn btn-primary">Profile</a>
                    <div style="clear:both"></div>
                </div>
            </div>

        </div>

        {!! menu('admin', 'admin_menu') !!}
    </nav>
</div>
