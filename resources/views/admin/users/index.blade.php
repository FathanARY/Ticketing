@extends('admin.layout')

@section('content')
<div class="crud-container">
    <h1 class="page-title">Manajemen Pengguna</h1>

    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid-split">
        <div class="form-box">
            <h3>{{ isset($user) ? 'Edit Pengguna' : 'Tambah User Baru' }}</h3>
            
            <form method="POST" action="{{ isset($user) ? route('admin.users.update', $user->user_id) : route('admin.users.store') }}">
                @csrf
                @if(isset($user)) @method('PUT') @endif

                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', $user->nama_lengkap ?? '') }}" required placeholder="Nama Lengkap...">
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email ?? '') }}" required placeholder="email@contoh.com">
                </div>

                <div class="form-group">
                    <label>Password {{ isset($user) ? '(Isi jika ingin mengganti)' : '' }}</label>
                    <input type="password" name="password" class="form-control" {{ isset($user) ? '' : 'required' }} placeholder="*******">
                </div>

                <div class="form-group">
                    <label>Role</label>
                    <select name="role" class="form-control" required>
                        <option value="user" {{ (old('role', $user->role ?? '') == 'user') ? 'selected' : '' }}>User (Peserta)</option>
                        <option value="admin" {{ (old('role', $user->role ?? '') == 'admin') ? 'selected' : '' }}>Administrator</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Asal Sekolah / Instansi</label>
                    <input type="text" name="school_name" class="form-control" value="{{ old('school_name', $user->school_name ?? '') }}" placeholder="Contoh: SMAN 1 Bandung">
                </div>

                <div class="form-group">
                    <label>No HP</label>
                    <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', $user->no_hp ?? '') }}" placeholder="0812...">
                </div>

                <button type="submit" class="btn btn-primary">
                    {{ isset($user) ? 'Simpan User' : 'Tambah User' }}
                </button>

                @if(isset($user))
                    <a href="{{ route('admin.users.index') }}" class="btn btn-danger" style="width:100%; margin-top:10px; text-align:center;">Batal Edit</a>
                @endif
            </form>
        </div>

        <div class="table-box">
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Nama / Sekolah</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th width="140px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $u)
                        <tr>
                            <td>
                                <strong>{{ $u->nama_lengkap }}</strong><br>
                                <small style="color:#666; font-size:0.85rem;">{{ $u->school_name ?? '-' }}</small>
                            </td>
                            <td>{{ $u->email }}</td>
                            <td>
                                @if($u->role == 'admin')
                                    <span style="background:#ffebee; color:#c62828; padding:2px 8px; border-radius:4px; font-size:0.8rem; font-weight:bold;">ADMIN</span>
                                @else
                                    <span style="background:#e8f5e9; color:#2e7d32; padding:2px 8px; border-radius:4px; font-size:0.8rem;">USER</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.users.edit', $u->user_id) }}" class="btn btn-warning">Edit</a>
                                
                                @if(auth()->id() != $u->user_id)
                                <form method="POST" action="{{ route('admin.users.destroy', $u->user_id) }}" style="display:inline;" onsubmit="return confirm('Hapus user ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" style="text-align: center;">Belum ada user terdaftar.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection