<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiItem extends Model
{
    protected $table = 'transaksi_item';
    protected $guarded = ['id'];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }
}
