@extends('admin.layout')

@section('title', 'Kelola Tiket')

@section('content')
<div class="page-header">
    <h1 class="page-title">Manajemen Tiket</h1>
    <p class="page-subtitle">Kelola tiket event Gateway to PTN</p>
</div>

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 30px;">
    <!-- Form Section -->
    <div class="form-card">
        <h3 style="color: white; margin-bottom: 20px; font-size: 1.2rem;">
            <i class="fas fa-{{ isset($ticket) ? 'edit' : 'plus' }}"></i>
            {{ isset($ticket) ? 'Edit Tiket' : 'Tambah Tiket Baru' }}
        </h3>
        
        <form method="POST" action="{{ isset($ticket) ? route('admin.tickets.update', $ticket->ticket_id) : route('admin.tickets.store') }}">
            @csrf
            @if(isset($ticket)) @method('PUT') @endif

            <div class="form-group">
                <label class="form-label">Pilih Event</label>
                <select name="event_id" class="form-select" required>
                    <option value="">-- Pilih Event --</option>
                    @foreach($events as $id => $name)
                        <option value="{{ $id }}" {{ (isset($ticket) && $ticket->event_id == $id) ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Jenis Tiket</label>
                <input type="text" name="jenis_tiket" class="form-input" value="{{ old('jenis_tiket', $ticket->jenis_tiket ?? '') }}" required placeholder="Cth: VIP, Regular, dll">
            </div>

            <div class="form-group">
                <label class="form-label">Harga (Rp)</label>
                <input type="number" name="harga" class="form-input" value="{{ old('harga', $ticket->harga ?? 0) }}" required placeholder="0 untuk gratis">
            </div>

            <div class="form-group">
                <label class="form-label">Stok</label>
                <input type="number" name="stok" class="form-input" value="{{ old('stok', $ticket->stok ?? '') }}" required placeholder="Jumlah tiket tersedia">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit" style="width: 100%;">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
            
            @if(isset($ticket))
            <a href="{{ route('admin.tickets.index') }}" class="btn-cancel" style="display: block; text-align: center; margin-top: 10px;">
                Batal Edit
            </a>
            @endif
        </form>
    </div>

    <!-- Table Section -->
    <div class="table-card">
        <div class="table-header">
            <h3><i class="fas fa-ticket-alt"></i> Daftar Tiket</h3>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Event</th>
                    <th>Jenis</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tickets as $t)
                <tr>
                    <td>{{ $t->nama_event }}</td>
                    <td>{{ $t->jenis_tiket }}</td>
                    <td>{{ $t->harga == 0 ? 'GRATIS' : 'Rp ' . number_format($t->harga, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge {{ $t->stok > 50 ? 'badge-approved' : ($t->stok > 10 ? 'badge-pending' : 'badge-rejected') }}">
                            {{ $t->stok }}
                        </span>
                    </td>
                    <td>
                        <div class="action-btns">
                            <a href="{{ route('admin.tickets.edit', $t->ticket_id) }}" class="btn-icon btn-edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.tickets.destroy', $t->ticket_id) }}" method="POST" style="display:inline">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Hapus tiket ini?')" class="btn-icon btn-delete" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 30px;">
                        <i class="fas fa-ticket-alt" style="font-size: 2rem; opacity: 0.3; margin-bottom: 10px;"></i>
                        <p>Belum ada tiket</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection