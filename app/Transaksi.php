<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';

    //setiap transaksi dimiliki 1 user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // 1 transaksi mempunyai banyak retur item barang

    public function returItems()
    {
        return $this->hasMany(ReturItem::class, 'transaction_id','id');
    }
}
