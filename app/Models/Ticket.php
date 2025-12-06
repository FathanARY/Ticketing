<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = 'tickets';
    protected $primaryKey = 'ticket_id';
    public $timestamps = true;

    protected $fillable = [
        'event_id',
        'jenis_tiket',
        'harga',
        'stok',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'stok' => 'integer',
    ];
}