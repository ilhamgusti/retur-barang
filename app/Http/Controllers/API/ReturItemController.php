<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReturItem;
use App\Http\Requests\UpdateReturItem;
use App\Http\Resources\ReturItemResource;
use App\ReturItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReturItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReturItem $request)
    {
        // jika user bertipe 0 / customer
        if (Auth::user()->tipe === 0) {
            $data = ReturItem::create([
                'keterangan' => $request->keterangan,
                'is_valid' => false,
                'status' => 0, // '0. belum di validasi, 1. validasi sales, 2. validasi direktur, 3. tolak'
                'kode_transaksi' => $request->kode_transaksi,
            ]);

            if ($request->hasfile('images')) {
                $images = $request->file('images');
    
                foreach($images as $image) {
                    $name = $image->getClientOriginalName();
                    $path = $image->storeAs('uploads', $name, 'public');

                    $data->images()->create(['image_url' => '/storage/'.$path]);
                }
             }
            
            return (new ReturItemResource($data->loadMissing('transaction', 'images')));
        } else {
            return response()->json([
                'message' => 'Kamu tidak dapat menyimpan data retur Item, kamu bukan Customer.'
            ], 403);
        }   
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ReturItem  $returItem
     * @return \Illuminate\Http\Response
     */
    public function show(ReturItem $returItem)
    {
        return (new ReturItemResource($returItem->loadMissing('transaction', 'images')));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReturItem  $returItem
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReturItem $request, ReturItem $returItem)
    {
        //jika status retur ditolak, maka langsung mengembalikan data resource tanpa update
        if($returItem->status === 3){
            return (new ReturItemResource($returItem->loadMissing('transaction', 'images')));
        }

        //jika sales
        if(Auth::user()->tipe === 1){
           if($returItem->status === 0){
            $returItem->status = $request->isApproved ? 1 : 3;
            $returItem->is_valid = $request->isApproved ? true : false;
            if($request->has('remarks_sales')){
                $returItem->remarks_sales = $request->remarks_sales;
            }
            $returItem->validate_sales_at = Carbon::now();
            $returItem->save();

            return (new ReturItemResource($returItem->loadMissing('transaction', 'images')));

           }else{
               return 'sudah divalidasi';
           }

            //jika direktur
        }elseif (Auth::user()->tipe === 2) {
            // jika retur item berstatus 1 (sudah divalidasi sales) maka terima or tolak
            if($returItem->status === 1){
                $returItem->status = $request->isApproved ? 2 : 3;
                $returItem->is_valid = $request->isApproved ? true : false;
                if($request->has('remarks_direktur')){
                    $returItem->remarks_direktur = $request->remarks_direktur;
                }
                $returItem->validate_direktur_at = Carbon::now();
                $returItem->save();

                return (new ReturItemResource($returItem->loadMissing('transaction', 'images')));
            }elseif ($returItem->status === 0) {
                return "harus divalidasi sales terlebih dahulu";
            }else{
                return "sudah divalidasi";
            }
        }else{
            return response()->json([
                'message' => 'Kamu tidak dapat akses untuk melakukan validasi data, kamu bukan sales atau direktur.'
            ], 403);
        }
    }
}
