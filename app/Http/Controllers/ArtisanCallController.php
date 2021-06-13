<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ArtisanCallController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('command')){
            Artisan::call($request->command);
            $output = Artisan::output();
            return $output;
        }
    }
}
