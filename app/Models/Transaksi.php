<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';
    protected $guarded = ['id'];

    public function items()
    {
        return $this->hasMany(TransaksiItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
