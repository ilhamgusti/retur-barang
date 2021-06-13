<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Transaksi;
use Faker\Generator as Faker;

$factory->define(Transaksi::class, function (Faker $faker) {
    return [
        'kode_transaksi' => $faker->uuid(),
        'nama_barang' => $faker->name,
        'tanggal_pembelian' => $faker->date(),
        'user_id' => User::where('tipe',0)->get()->random()->id
    ];
});
