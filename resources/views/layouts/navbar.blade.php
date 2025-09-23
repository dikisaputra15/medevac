<nav class="navbar">
    <div class="d-flex align-items-center w-100 justify-content-between">
        <a href="/home">
            <img src="{{ asset('images/CMT-logo.png') }}" alt="CMT Logo" class="brand-image">
        </a>

        <ul class="navbar-nav d-flex flex-row align-items-center">

            <a href="https://pg.concordreview.com/concord-homepage-new-layout-2/new-incident-tracking/" class="btn btn-danger d-flex flex-column align-items-center p-3" target="_blank">
            <img src="https://pg.concordreview.com/wp-content/uploads/2025/07/incident-tracking-icon.png" style="width: 18px; height: 18px;">
                <small>Incident Tracking</small>
            </a>

            <a href="http://pg.concordreview.com/papua-new-guinea-png-dashboard-overview/" class="btn btn-danger d-flex flex-column align-items-center p-3" target="_blank">
            <img src="https://pg.concordreview.com/wp-content/uploads/2023/12/icon-overview-dashboard.png" style="width: 18px; height: 18px;">
                <small>Incident Dashboard</small>
            </a>

            @role('admin')
            <li class="nav-item me-3">
                <a class="btn btn-primary" href="/administrator" target="_blank">
                    Admin
                </a>
            </li>
            @endrole

            <li class="nav-item">
                <a class="nav-link" href="#"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa fa-power-off"></i>
                </a>
            </li>
        </ul>
    </div>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
</nav>
