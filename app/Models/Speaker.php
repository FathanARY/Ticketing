<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Speaker extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'speakers';
    
    // Primary Key
    protected $primaryKey = 'speaker_id';

    // Kolom yang boleh diisi
    protected $fillable = [
        'event_id',
        'nama_speaker',
        'bio',
        'foto',
        'is_revealed',
        'reveal_date',
    ];

    // Relasi ke Event
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'event_id');
    }
}