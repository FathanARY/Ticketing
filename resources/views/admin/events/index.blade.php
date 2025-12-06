@extends('admin.layout')

@section('content')
<div class="crud-container">
    <h1 class="page-title">Manajemen Event Utama</h1>

    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid-split">
        
        <div class="form-box">
            @if(isset($event))
                <h3>Edit Event: {{ $event->nama_event }}</h3>
                
                <form method="POST" action="{{ route('admin.events.update', $event->event_id) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Nama Event</label>
                        <input type="text" name="nama_event" class="form-control" value="{{ $event->nama_event }}" readonly style="background-color: #e9ecef;">
                    </div>

                    <div class="form-group">
                        <label>Tanggal Pelaksanaan</label>
                        <input type="datetime-local" name="tanggal_event" class="form-control" value="{{ date('Y-m-d\TH:i', strtotime($event->tanggal_event)) }}" required>
                    </div>

                    <div class="form-group">
                        <label>Lokasi</label>
                        <input type="text" name="lokasi" class="form-control" value="{{ $event->lokasi }}" required>
                    </div>

                    <div class="form-group">
                        <label>Deskripsi (Akan tampil di Timeline Home)</label>
                        <textarea name="deskripsi" class="form-control" rows="5">{{ $event->deskripsi }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Link Google Maps Embed</label>
                        <input type="text" name="maps_embed" class="form-control" value="{{ $event->maps_embed }}">
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('admin.events.index') }}" class="btn btn-danger" style="text-align:center; display:inline-block;">Batal</a>
                </form>
            @else
                <div style="padding: 40px; text-align: center; border: 2px dashed #ccc; border-radius: 10px; color: #fff;">
                    <h3>Silakan Pilih Event</h3>
                    <p>Pilih salah satu event di tabel sebelah kanan untuk mengedit detailnya.</p>
                </div>
            @endif
        </div>

        <div class="table-box">
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Event</th>
                            <th>Tanggal Saat Ini</th>
                            <th>Lokasi</th>
                            <th width="100px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($events as $e)
                        <tr>
                            <td><strong>{{ $e->nama_event }}</strong></td>
                            <td>{{ \Carbon\Carbon::parse($e->tanggal_event)->format('d M Y') }}</td>
                            <td>{{ $e->lokasi }}</td>
                            <td>
                                <a href="{{ route('admin.events.edit', $e->event_id) }}" class="btn btn-warning" style="width: 100%;">Edit Detail</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection