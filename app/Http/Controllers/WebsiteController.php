<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Merchant;

use Log;

class WebsiteController extends Controller
{
    public function home()
    {
        return view('website.welcome');
    }
    public function checkDBConnection(Request $request) {
        $merchants = Merchant::all();
        if (empty($merchants)) {
            return response()->json([
                'message' => 'DB connection failed'
            ], 401);    
        }
        return response()->json([
            'code' => 200,
            'result' => $merchants
        ]);
    }
}
