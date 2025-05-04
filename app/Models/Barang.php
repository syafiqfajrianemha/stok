<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function masuk()
    {
        return $this->hasMany(BarangMasuk::class);
    }

    public function transaksiItem()
    {
        return $this->hasMany(TransaksiItem::class);
    }
}
