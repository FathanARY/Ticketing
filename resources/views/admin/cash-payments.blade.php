@extends('admin.layout')

@section('title', 'Kelola Pembayaran')

@section('content')
<div class="page-header">
    <h1 class="page-title">Kelola Pembayaran Tunai</h1>
    <p class="page-subtitle">Verifikasi dan kelola pembayaran tunai dari pengguna</p>
</div>

<!-- Filter Tabs -->
<div class="filter-tabs">
    <button class="tab-btn {{ request('status', 'pending') == 'pending' ? 'active' : '' }}" 
            onclick="window.location.href='{{ route('admin.cash.payments', ['status' => 'pending']) }}'">
        <i class="fas fa-hourglass-half"></i> Pending ({{ $pendingCount }})
    </button>
    <button class="tab-btn {{ request('status') == 'approved' ? 'active' : '' }}" 
            onclick="window.location.href='{{ route('admin.cash.payments', ['status' => 'approved']) }}'">
        <i class="fas fa-check-circle"></i> Approved ({{ $approvedCount }})
    </button>
    <button class="tab-btn {{ request('status') == 'rejected' ? 'active' : '' }}" 
            onclick="window.location.href='{{ route('admin.cash.payments', ['status' => 'rejected']) }}'">
        <i class="fas fa-times-circle"></i> Rejected ({{ $rejectedCount }})
    </button>
    <button class="tab-btn {{ request('status') == 'all' ? 'active' : '' }}" 
            onclick="window.location.href='{{ route('admin.cash.payments', ['status' => 'all']) }}'">
        <i class="fas fa-list"></i> Semua ({{ $totalCount }})
    </button>
</div>

<!-- Payments Grid -->
<div class="payments-grid">
    @forelse($payments as $payment)
    <div class="payment-card">
        <div class="payment-card-header">
            <div>
                <p class="payment-order-id">{{ $payment->order_id }}</p>
                <span class="badge badge-{{ $payment->status }}">{{ ucfirst($payment->status) }}</span>
            </div>
            <div class="payment-amount">Rp {{ number_format($payment->amount, 0, ',', '.') }}</div>
        </div>

        <div class="payment-detail">
            <span class="label">Nama:</span>
            <span class="value">{{ $payment->nama_lengkap }}</span>
        </div>
        <div class="payment-detail">
            <span class="label">Email:</span>
            <span class="value">{{ $payment->email }}</span>
        </div>
        <div class="payment-detail">
            <span class="label">Telepon:</span>
            <span class="value">{{ $payment->phone }}</span>
        </div>
        <div class="payment-detail">
            <span class="label">Bundle:</span>
            <span class="value">{{ ucfirst($payment->bundle_type) }}</span>
        </div>
        <div class="payment-detail">
            <span class="label">Tanggal:</span>
            <span class="value">{{ \Carbon\Carbon::parse($payment->created_at)->format('d M Y, H:i') }}</span>
        </div>

        <button class="btn btn-view-proof" onclick="viewProof('{{ route('admin.cash.proof', $payment->payment_id) }}', '{{ $payment->order_id }}')">
            <i class="fas fa-eye"></i> Lihat Bukti Pembayaran
        </button>

        @if($payment->status === 'pending')
        <div class="payment-actions">
            <form method="POST" action="{{ route('admin.cash.approve', $payment->payment_id) }}" style="flex: 1;">
                @csrf
                <button type="submit" class="btn btn-approve-lg" onclick="return confirm('Setujui pembayaran ini?')">
                    <i class="fas fa-check"></i> Approve
                </button>
            </form>
            <button type="button" class="btn btn-reject-lg" onclick="showRejectModal({{ $payment->payment_id }})" style="flex: 1;">
                <i class="fas fa-times"></i> Reject
            </button>
        </div>
        @endif
    </div>
    @empty
    <div class="empty-state" style="grid-column: 1/-1;">
        <i class="fas fa-inbox"></i>
        <h3>Tidak Ada Pembayaran</h3>
        <p>Belum ada pembayaran dengan status ini.</p>
    </div>
    @endforelse
</div>

<!-- Proof Modal -->
<div class="modal-overlay" id="proofModal">
    <div class="modal-content" style="max-width: 600px;">
        <div class="modal-header">
            <h3 class="modal-title" id="proofModalTitle">Bukti Pembayaran</h3>
        </div>
        <div style="text-align: center; padding: 20px 0;">
            <img id="proofImage" src="" alt="Bukti Pembayaran" style="max-width: 100%; max-height: 400px; border-radius: 10px;">
        </div>
        <div style="text-align: right;">
            <button class="btn-cancel" onclick="closeProofModal()">Tutup</button>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal-overlay" id="rejectModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Tolak Pembayaran</h3>
        </div>
        <form id="rejectForm" method="POST" action="">
            @csrf
            <div class="form-group">
                <label class="form-label">Alasan Penolakan (Opsional)</label>
                <textarea name="admin_notes" class="form-textarea" placeholder="Masukkan alasan penolakan..."></textarea>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-submit" style="background: #ff4757;">Tolak Pembayaran</button>
                <button type="button" class="btn-cancel" onclick="closeRejectModal()">Batal</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
function viewProof(url, orderId) {
    document.getElementById('proofModalTitle').textContent = 'Bukti Pembayaran - ' + orderId;
    document.getElementById('proofImage').src = url;
    document.getElementById('proofModal').classList.add('active');
}

function closeProofModal() {
    document.getElementById('proofModal').classList.remove('active');
}

function showRejectModal(paymentId) {
    document.getElementById('rejectForm').action = '/admin/cash-payments/' + paymentId + '/reject';
    document.getElementById('rejectModal').classList.add('active');
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.remove('active');
}

// Close modal on overlay click
document.querySelectorAll('.modal-overlay').forEach(modal => {
    modal.addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.remove('active');
        }
    });
});
</script>
@endsection