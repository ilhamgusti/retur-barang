<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama','tipe','alamat','no_tel', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'tipe' => 'integer',
    ];


    // 1 user bisa memiliki banyak transaksi namun hanya yang bertipe customer atau tipe = 0
    public function returItems()
    {
        return $this->hasMany(Transaksi::class, 'user_id');
    }

    // 1 sales bisa memiliki banyak customer namun hanya yang bertipe sales atau tipe = 1
    public function returItemToSales()
    {
        return $this->hasMany(User::class, 'sales_id');
    }

    // 1 customer dimiliki oleh 1 sales namun hanya yang bertipe customer atau tipe = 0
    public function sales()
    {
        return $this->belongsTo(User::class,'sales_id','id');
    }
    // 1 customer dimiliki oleh 1 sales namun hanya yang bertipe customer atau tipe = 0
    public function customers()
    {
        return $this->hasMany(User::class,'sales_id','id');
    }


}
