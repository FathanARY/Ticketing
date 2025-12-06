<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'events';
    
    // Primary Key (karena kamu pakai event_id, bukan id biasa)
    protected $primaryKey = 'event_id';

    // Kolom yang boleh diisi
    protected $fillable = [
        'nama_event',
        'deskripsi',
        'tanggal_event',
        'lokasi',
        'maps_embed',
    ];

    // Relasi ke Speaker (Satu event punya banyak speaker)
    public function speakers()
    {
        return $this->hasMany(Speaker::class, 'event_id', 'event_id');
    }

    // Relasi ke Ticket (Satu event punya banyak jenis tiket)
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'event_id', 'event_id');
    }
}