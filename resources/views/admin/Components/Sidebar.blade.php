<div class="left-sidenav">
    <!-- LOGO -->
    <div class="brand">
        <a href="dashboard/crm-index.html" class="logo">
            <span>
                <img src="{{asset("admin/assets/images/logo-sm.png")}}" alt="logo-small" class="logo-sm">
            </span>
            <span>
                <img src="{{asset("admin/assets/images/logo.png")}}" alt="logo-large" class="logo-lg logo-light">
                <img src="{{asset("admin/assets/images/logo-dark.png")}}" alt="logo-large" class="logo-lg logo-dark">
            </span>
        </a>
    </div>
    <!--end logo-->
    <div class="menu-content h-100" data-simplebar>
        <ul class="metismenu left-sidenav-menu">
            <li class="menu-label mt-0">Main</li>
            <li>
                <a href="{{route('admin.dashboard')}}">
                    <i class="bi bi-columns-gap menu-icon"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{route('niches.index')}}">
                    <i class="bi bi-columns-gap menu-icon"></i>
                    <span>Niches</span>
                </a>
            </li>
            <li>
                <a href="{{route('bots.index')}}">
                    <i class="bi bi-columns-gap menu-icon"></i>
                    <span>Bots</span>
                </a>
            </li>
            {{-- <li>
                <a href="javascript: void(0);"><i class="ti-control-record"></i>Niches <span
                        class="menu-arrow left-has-menu"><i class="mdi mdi-chevron-right"></i></span></a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li><a href="{{route('niches.index')}}">list</a></li>
                    <li><a href="charts-chartjs.html">Chartjs</a></li>
                    <li><a href="charts-flot.html">Flot</a></li>
                    <li><a href="charts-morris.html">Morris</a></li>
                </ul>
            </li> --}}
        </ul>
    </div>
</div>