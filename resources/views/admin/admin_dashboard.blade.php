@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
<!-- Welcome Section -->
<div class="welcome-section">
    <div class="welcome-content">
        <h1>Dashboard<br><span>Administrator</span></h1>
        <p>Selamat bekerja, Admin! Ini adalah pusat kontrol untuk mengelola Event, Tiket, dan Data Peserta Gateway to PTN. Anda memiliki akses penuh untuk mengatur jalannya acara ini.</p>
        
        <div style="display: flex; gap: 15px; flex-wrap: wrap;">
            <a href="{{ route('admin.tickets.index') }}" class="btn-add">
                <i class="fas fa-ticket-alt"></i> Kelola Tiket
            </a>
            <a href="{{ route('admin.cash.payments') }}" class="btn-add" style="background: linear-gradient(135deg, #4CAF50, #8BC34A);">
                <i class="fas fa-money-bill-wave"></i> Verifikasi Pembayaran
            </a>
        </div>
    </div>
    <div class="welcome-image">
        <img src="{{ asset('assets/images/displayCard.jpg') }}" alt="Gateway to PTN">
    </div>
</div>

<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-value">{{ \App\Models\User::where('role', 'user')->count() }}</div>
        <div class="stat-label">Total Pengguna</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon pink">
            <i class="fas fa-ticket-alt"></i>
        </div>
        <div class="stat-value">{{ \App\Models\Ticket::sum('stok') }}</div>
        <div class="stat-label">Stok Tiket Tersedia</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon gold">
            <i class="fas fa-hourglass-half"></i>
        </div>
        <div class="stat-value">{{ \Illuminate\Support\Facades\DB::table('cash_payments')->where('status', 'pending')->count() }}</div>
        <div class="stat-label">Pembayaran Pending</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon green">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-value">{{ \Illuminate\Support\Facades\DB::table('cash_payments')->where('status', 'approved')->count() }}</div>
        <div class="stat-label">Pembayaran Approved</div>
    </div>
</div>

<!-- Recent Payments -->
<div class="table-card">
    <div class="table-header">
        <h3><i class="fas fa-clock"></i> Pembayaran Terbaru</h3>
        <a href="{{ route('admin.cash.payments') }}" class="btn-add">Lihat Semua</a>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Nama</th>
                <th>Bundle</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @php
                $recentPayments = \Illuminate\Support\Facades\DB::table('cash_payments')
                    ->join('users', 'cash_payments.user_id', '=', 'users.user_id')
                    ->select('cash_payments.*', 'users.nama_lengkap')
                    ->orderBy('cash_payments.created_at', 'desc')
                    ->limit(5)
                    ->get();
            @endphp
            
            @forelse($recentPayments as $payment)
            <tr>
                <td>{{ $payment->order_id }}</td>
                <td>{{ $payment->nama_lengkap }}</td>
                <td>{{ ucfirst($payment->bundle_type) }}</td>
                <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                <td>
                    <span class="badge badge-{{ $payment->status }}">{{ ucfirst($payment->status) }}</span>
                </td>
                <td>{{ \Carbon\Carbon::parse($payment->created_at)->format('d M Y, H:i') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 30px;">Belum ada pembayaran</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection