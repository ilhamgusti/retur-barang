<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTransaksi;
use App\Http\Resources\TransaksiResource;
use App\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->user()->tipe === 0){
            $data = Transaksi::where('user_id',$request->user()->id)->get();
            return TransaksiResource::collection($data);
        }
        $data = Transaksi::where('user_id',$request->userId)->get();
        return TransaksiResource::collection($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function show(Transaksi $transaksi)
    {
        return (new TransaksiResource($transaksi->loadMissing('returItems','user')));
    }

    /**
     * Store data of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTransaksi $request)
    {
        if($request->user()->tipe === 0){
            $data = Transaksi::create([
                'kode_transaksi' => $request->kode_transaksi,
                'nama_barang' => $request->nama_barang,
                'tanggal_pembelian' => $request->tanggal_pembelian,
                'user_id' => $request->user()->id,
            ]);
            return (new TransaksiResource($data->loadMissing('returItems','user')));
        }else{
            return response()->json([
                'message' => 'Kamu tidak dapat akses untuk menyimpan transaksi, kamu bukan customer'
            ], 403);
        }


    }

}
