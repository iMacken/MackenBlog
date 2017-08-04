<nav class="navbar navbar-default navbar-fixed-top navbar-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button class="hamburger btn-link">
                <span class="hamburger-inner"></span>
            </button>
            <a id="sidebar-anchor" class="voyager-anchor btn-link navbar-link hidden-xs"
               title="Yarr! Drop the anchors! (and keep the sidebar open)"
               data-unstick="Unstick the sidebar"
               data-toggle="tooltip" data-placement="bottom"></a>


        </div>
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown profile">
                <a href="#" class="dropdown-toggle text-right" data-toggle="dropdown" role="button"
                   aria-expanded="false"><img src="{{ $user_avatar }}" class="profile-img"> <span
                            class="caret"></span></a>
                <ul class="dropdown-menu dropdown-menu-animated">
                    <li class="profile-img">
                        <img src="{{ $user_avatar }}" class="profile-img">
                        <div class="profile-body">
                            @php $user = Auth::user(); @endphp
                            @if ($user)
                                <h5>{{ Auth::user()->name }}</h5>
                                <h6>{{ Auth::user()->email }}</h6>
                            @else
                                <h5>临时登录</h5>
                            @endif
                        </div>
                    </li>
                    <li class="divider"></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>