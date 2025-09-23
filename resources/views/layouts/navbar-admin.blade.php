<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <div class="container-fluid d-flex justify-content-between align-items-center">

        <!-- Left side (menu + logo) -->
        <div class="d-flex align-items-center">
            <!-- Icon menu -->
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>

            <!-- Logo -->
            <a href="/home" class="ms-2">
                <img src="{{ asset('images/CMT-logo.png') }}" alt="CMT Logo" style="height:40px;">
            </a>
        </div>

        <!-- Right side (incident buttons + logout) -->
        <div class="d-flex align-items-center">
            <!-- Incident Tracking -->
            <a href="https://pg.concordreview.com/concord-homepage-new-layout-2/new-incident-tracking/"
               class="btn btn-danger d-flex flex-column align-items-center p-2 me-2"
               target="_blank">
                <img src="https://pg.concordreview.com/wp-content/uploads/2025/07/incident-tracking-icon.png"
                     style="width: 18px; height: 18px;">
                <small>Incident Tracking</small>
            </a>

            <!-- Incident Dashboard -->
            <a href="http://pg.concordreview.com/papua-new-guinea-png-dashboard-overview/"
               class="btn btn-danger d-flex flex-column align-items-center p-2 me-2"
               target="_blank">
                <img src="https://pg.concordreview.com/wp-content/uploads/2023/12/icon-overview-dashboard.png"
                     style="width: 18px; height: 18px;">
                <small>Incident Dashboard</small>
            </a>

            <!-- Logout -->
            <a class="btn btn-danger d-flex align-items-center justify-content-center p-2"
               title="Logout" href="#"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa fa-power-off"></i>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>
</nav>
<!-- /.navbar -->
