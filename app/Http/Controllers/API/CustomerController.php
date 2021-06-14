<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
    /**
     * Store a customer of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        // jika user login bertipe sales maka list customernya;
        if($request->user()->tipe === 1){
            $validatedData = $request->validate([
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
                'tipe' => 'required|string',
                'alamat'=> 'required',
                'no_tel' => 'required',
                'nama' => 'required|string|min:3|max:255'
            ]);
            $customer = $request->user()->customer()->create([
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'alamat'=> $validatedData['alamat'],
                'nama'=> $validatedData['nama'],
                'tipe' => $validatedData['tipe'],
                'no_tel'=> $validatedData['no_tel']
            ]);

            // $token = $user->createToken('auth_token')->plainTextToken;
    
            return (new UserResource($customer->loadMissing('sales')));
        }else{
            return response()->json([
                'message' => 'Kamu tidak dapat akses untuk melihat list Customer, kamu bukan sales'
            ], 403);
        }
        
    }
}
