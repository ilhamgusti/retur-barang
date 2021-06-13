<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // jika user login bertipe sales maka list customernya;
        if($request->user()->tipe === 1){
            $data = User::where('sales_id',Auth::user()->id)->get();
            return UserResource::collection($data);
        }else{
            return response()->json([
                'message' => 'Kamu tidak dapat akses untuk melihat list Customer, kamu bukan sales'
            ], 403);
        }
        
    }
}
