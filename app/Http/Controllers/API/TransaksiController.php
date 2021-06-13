<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
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
        if(Auth::user()->tipe === 0){
            $data = Transaksi::where('user_id',Auth::user()->id)->get();
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

}
