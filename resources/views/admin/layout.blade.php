<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Gateway To PTN</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin-new.css') }}">
    @yield('styles')
</head>
<body>
    <!-- Admin Navbar -->
    <nav class="admin-navbar">
        <a href="{{ route('admin.dashboard') }}" class="logo">
            <img src="{{ asset('assets/images/GatewayToPTN.png') }}" alt="Logo">
            <div class="logo-text">
                <span class="logo-title">Gateway to PTN</span>
                <span class="logo-subtitle">Admin Panel</span>
            </div>
        </a>

        <div class="admin-nav-links">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <a href="{{ route('admin.tickets.index') }}" class="{{ request()->routeIs('admin.tickets.*') ? 'active' : '' }}">
                <i class="fas fa-ticket-alt"></i> Tickets
            </a>
            <a href="{{ route('admin.events.index') }}" class="{{ request()->routeIs('admin.events.*') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt"></i> Events
            </a>
            <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Users
            </a>
            <a href="{{ route('admin.cash.payments') }}" class="{{ request()->routeIs('admin.cash.*') ? 'active' : '' }}">
                <i class="fas fa-money-bill-wave"></i> Payments
            </a>
        </div>

        <div class="admin-profile">
            <div class="admin-info">
                <span class="label">Administrator</span>
                <span class="name">{{ Auth::user()->nama_lengkap }}</span>
            </div>
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="admin-container">
        @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
        @endif

        @yield('content')
    </div>

    @yield('scripts')
</body>
</html>