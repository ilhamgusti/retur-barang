<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReturItem extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'is_valid',
        'keterangan',
        'status',
        'remarks_sales',
        'remarks_direktur',
        'validate_sales_at',
        'validate_direktur_at',
        'transaction_id'
    ];

    //setiap retur item pasti dimiliki oleh 1 transaksi
    public function transaction()
    {
        return $this->belongsTo(Transaksi::class, 'transaction_id', 'id');
    }

    // setiap 1 retur barang mempunyai banyak gambar
    public function images()
    {
        return $this->hasMany(ReturItemImage::class,'retur_id', 'id');
    }
}
