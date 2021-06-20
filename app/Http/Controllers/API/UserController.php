<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Transformers\UserTransformer;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::where('tipe','!=',0)->get();
        return UserResource::collection($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        DB::beginTransaction();
        try {
            $user = UserTransformer::toInstance($request->validated(), User::findOrFail($request->user()->id));
            $user->save();
            DB::commit();
        } catch (Exception $ex) {
            Log::info($ex->getMessage());
            DB::rollBack();
            return response()->json($ex->getMessage(), 409);
        }

        return (new UserResource($user))
            ->additional([
                'meta' => [
                    'success' => true,
                    'message' => "User Updated"
                ]
            ]);
    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([
            'code'=>203,
            'message' => 'Success Delete User'
        ]);
    }
}
