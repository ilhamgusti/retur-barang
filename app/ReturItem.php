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
        'no_surat_jalan',
        'jenis_masalah',
        'keterangan',
        'tanggal_pesan',
        'tanggal_kirim',
        'bukti_foto',
        'status',
        'remarks_direktur',
        'validate_sales_at',
        'validate_direktur_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_valid' => 'boolean',
        'tanggal_pesan' => 'date:Y-m-d',
        'tanggal_kirim' => 'date:Y-m-d',
        'status' => 'integer',
        'validate_sales_at' => 'datetime',
        'validate_direktur_at' => 'datetime',
    ];

        // 1 user bisa memiliki banyak transaksi namun hanya yang bertipe customer atau tipe = 0
        public function customer()
        {
            return $this->belongsTo(Transaksi::class, 'user_id','id');
        }
    
        // 1 sales bisa memiliki banyak customer namun hanya yang bertipe sales atau tipe = 1
        public function sales()
        {
            return $this->belongsTo(User::class, 'sales_id','id');
        }
}
