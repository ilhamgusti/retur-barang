<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReturItem;
use App\Http\Requests\UpdateReturItem;
use App\Http\Resources\ReturItemResource;
use App\Mail\ApprovalApprove;
use App\Mail\ApprovalReject;
use App\ReturItem;
use Carbon\Carbon;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class ReturItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->user()->tipe === 0) {
            $data = $request->user()->returItems()->get();
        }elseif ($request->user()->tipe === 1) {
            $data = $request->user()->returItemToSales()->get();
        }else{
            $data = ReturItem::all();
        }

        return (new ReturItemResource($data->loadMissing('sales', 'customer')));
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
        if ($request->user()->tipe === 0) {
            if ($request->hasfile('bukti_foto')) {
                $image = $request->file('bukti_foto');
                $path = $image->store('images', 'public');
                $data = $request->user()->returItems()->create([
                    'is_valid' => false,
                    'no_surat_jalan' => $request->no_surat_jalan,
                    'jenis_masalah' => $request->jenis_masalah,
                    'keterangan' => $request->keterangan,
                    'tanggal_pesan' => $request->tanggal_pesan,
                    'tanggal_kirim' => $request->tanggal_pesan,
                    'bukti_foto' => URL::asset('storage/' . $path),
                    'status' => 0,
                    // 'remarks_direktur',
                    // 'validate_sales_at',
                    // 'validate_direktur_at',
                ]);
                $sales = User::findOrFail($request->sales_id);
                // $data->sales()->associate($sales);
                $request->user()->returItemToSales()->associate($sales)->save();
                return (new ReturItemResource($data->loadMissing('sales', 'customer')));
             }
            
        } else {
            return response()->json([
                'message' => 'Kamu tidak dapat menyimpan data retur Item, kamu bukan Customer.'
            ], 403);
        }   
    }

    public function destroy(ReturItem $returItem)
    {
        $returItem->delete();
        return response()->json([
            'code'=>203,
            'message' => 'Success Delete Data'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ReturItem  $returItem
     * @return \Illuminate\Http\Response
     */
    public function show(ReturItem $returItem)
    {
        return (new ReturItemResource($returItem->loadMissing('sales', 'customer')));
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
            return (new ReturItemResource($returItem->loadMissing('sales', 'customer')));
        }

        //jika sales
        if($request->user()->tipe === 1){
           if($returItem->status === 0){
            $returItem->status = $request->is_valid ? 1 : 3;
            $returItem->is_valid = $request->is_valid ? true : false;
            if($request->has('remarks_sales')){
                $returItem->remarks_sales = $request->remarks_sales;
            }
            $returItem->validate_sales_at = Carbon::now();
            $returItem->save();
            if(!$request->is_valid){
                Mail::to($returItem->customer->email)->send(new ApprovalReject($returItem->toArray()));
            }
            return (new ReturItemResource($returItem->loadMissing('sales', 'customer')));

           }else{
               return 'sudah divalidasi';
           }

            //jika direktur
        }elseif ($request->user()->tipe === 2) {
            // jika retur item berstatus 1 (sudah divalidasi sales) maka terima or tolak
            if($returItem->status === 1){
                $returItem->status = $request->is_valid ? 2 : 3;
                $returItem->is_valid = $request->is_valid ? true : false;
                if($request->has('remarks_direktur')){
                    $returItem->remarks_direktur = $request->remarks_direktur;
                }
                $returItem->validate_direktur_at = Carbon::now();
                $returItem->save();
                if(!$request->is_valid){
                    Mail::to($returItem->customer->email)->send(new ApprovalReject($returItem->toArray()));
                }else{
                    Mail::to($returItem->customer->email)->send(new ApprovalApprove($returItem->toArray()));
                }
                return (new ReturItemResource($returItem->loadMissing('sales', 'customer')));
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
