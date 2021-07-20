<?php

namespace App\Http\Controllers\Settings\Merchant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Merchant;
use Illuminate\Support\Facades\Auth;

class MerchantController extends Controller
{
    public function switch($id)
    {
    	$user = Auth::user();
    	$merchant = Merchant::find($id);
    	if($merchant && $user->merchantsList()->where('id', $merchant->id)->first()) {
    		$user->current_merchant = $id;
    		$user->save();
    	}
    	return redirect()->back();
    }

    public function create(Request $request)
    {
    	$merchant = Merchant::create([
    		'user_id' => Auth::user()->id,
    		'name' 	  => $request->name,
    		'website' => $request->website
    	]);
    	
    	return redirect()->back();
    }
}
