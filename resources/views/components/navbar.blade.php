<!-- Preloader -->
<div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{ asset('assets/plugins/adminlte/img/AdminLTELogo.png') }}" alt="AdminLTELogo"
        height="60" width="60" />
</div>

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        @php
            // Mengambil hanya notifikasi yang belum dibaca
            $unreadNotifications = auth()
                ->user()
                ->unreadNotifications()
                ->where('type', 'App\Notifications\LowStockNotification')
                ->get();
        @endphp

        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                @if ($unreadNotifications->count() > 0)
                    <span class="badge badge-danger navbar-badge">{{ $unreadNotifications->count() }}</span>
                @endif
            </a>
            <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right">
                <span class="dropdown-item dropdown-header">{{ $unreadNotifications->count() }} Notifikasi Stok
                    Rendah</span>
                <div class="dropdown-divider"></div>
                @foreach ($unreadNotifications as $notification)
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-cubes mr-2"></i> {{ $notification->data['nama_produk'] }} - Tersisa:
                        {{ $notification->data['stok'] }} stok
                        <span
                            class="float-right text-muted text-sm">{{ $notification->created_at->diffForHumans() }}</span>
                    </a>
                    <div class="dropdown-divider"></div>
                @endforeach
                <div class="dropdown-divider"></div>
                <a href="{{ route('notifications.markAllAsRead') }}" class="dropdown-item dropdown-footer">Tandai semua
                    sudah dibaca</a>
            </div>
        </li>


        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#"
                role="button">
                <i class="fas fa-th-large"></i>
            </a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->
