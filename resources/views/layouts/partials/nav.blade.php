<nav class="navbar navbar-expand-lg navbar-light bg-white flex-row border-bottom shadow">
    <div class="container-fluid">
        <a class="navbar-brand mx-lg-1 mr-0"  href="{{ route('records.index') }}">
            <img src="{{ asset('img/logo.png') }}" style="max-width: 15%">
        </a>
        <button class="navbar-toggler mt-2 mr-auto toggle-sidebar text-muted">
            <i class="fe fe-menu navbar-toggler-icon"></i>
        </button>
        <div class="navbar-slide bg-white ml-lg-4" id="navbarSupportedContent">
            <a href="#" class="btn toggle-sidebar d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
                <i class="fe fe-x"><span class="sr-only"></span></i>
            </a>
            <ul class="navbar-nav mr-auto">
                @can('view','App\\Models\Record')
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="{{route('records.index')}}">
                            <i class="fe fe-layers fe-16"></i>
                            <span class="ml-3 item-text">السجلات</span>
                        </a>
                    </li>
                @endcan
                @can('view','App\\Models\Financier')
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="{{route('financiers.index')}}">
                            <i class="fe fe-dollar-sign fe-16"></i>
                            <span class="ml-3 item-text">الممولين</span>
                        </a>
                    </li>
                @endcan
                @can('view','App\\Models\User')
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="{{route('users.index')}}">
                            <i class="fe fe-users fe-16"></i>
                            <span class="ml-3 item-text">المستخدمين</span>
                        </a>
                    </li>
                @endcan

            </ul>
        </div>
        <ul class="navbar-nav d-flex flex-row">
            @stack('extentions')
            <li class="nav-item">
                <a class="nav-link text-muted my-2" href="./#" id="modeSwitcher" data-mode="light">
                    <i class="fe fe-sun fe-16"></i>
                </a>
            </li>
            <li class="nav-item dropdown ml-lg-0">
                <a class="nav-link dropdown-toggle text-muted" href="#" id="navbarDropdownMenuLink"
                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="avatar avatar-sm mt-2">
                        <img src="{{ asset('img/user.jpg') }}" alt="..." class="avatar-img rounded-circle">
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                    {{-- <li class="nav-item">
                        <a class="nav-link pl-3" href="#">الملف الشخصي</a>
                    </li> --}}
                    <li class="nav-item">
                        {{-- <a class="nav-link pl-3" href="#">Activities</a> --}}
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button type="submit" class="nav-link pl-3">تسجيل خروج</button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
