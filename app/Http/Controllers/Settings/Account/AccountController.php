<?php

namespace App\Http\Controllers\Settings\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\Account\StoreRequest;
use App\Mail\InviteEmployee;
use App\Models\MerchantUser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AccountController extends Controller
{
	public function index()
	{
        return view('account.settings');
	}

	public function get()
	{
    	$merchant = Auth::user()->merchant;
		return response()->json([
			'user' 	     => Auth::user(),
			'merchant'   => $merchant
		], 200);
	}

	public function update(StoreRequest $request)
	{
		// User Settings
		$user = Auth::user();
		$user->name = $request->name;
		$user->email = $request->email;
		if($request->password && $request->password == $request->password_confirmation) {
			$user->password = Hash::make($request->password);
		}
		$user->save();

		// Merchant Settings
		$merchantData = $request->store;
    	$merchant = Auth::user()->merchant;
    	$merchant->name = $merchantData['name'];
    	$merchant->website = $merchantData['website'];
    	$merchant->billing_email = $request->billing_email;
		$merchant->save();
		
		return response()->json(['message' => 'Settings saved', 'merchant' => $merchant], 200);
	}

	public function getEmployees()
	{
    	$usersData = collect();
    	$users = Auth::user()->merchant->users;
    	foreach ($users as $user) {
    		if(Auth::user()->id != $user->id) {
	    		$usersData->push([
	    			'id' 		 => $user->id,
	    			'name' 		 => $user->name,
	    			'email' 	 => $user->email,
	    			'role'		 => $user->pivot->role,
	    			'created_at' => $user->pivot->created_at ? date('m-d-Y', strtotime($user->pivot->created_at)) : null
	    		]);
    		}
    	}
		return response()->json(['users' => $usersData], 200);
	}

	public function storeEmployee(Request $request)
	{
    	$merchant = Auth::user()->merchant;
    	$password = Str::random(20);
        $user = User::create([
            'name' 			   => $request->name,
            'email' 		   => $request->email,
            'password' 		   => Hash::make($password),
            'current_merchant' => $merchant->id
        ]);

        MerchantUser::firstOrCreate([
        	'merchant_id' => $merchant->id,
        	'user_id' 	  => $user->id,
        ], [
        	'role'		  => $request->role
        ]);

        try {
	    	Mail::to($user->email)->send(new InviteEmployee($merchant, $user, $password));
        } catch (\Exception $e) {
        	Log::error('Cannot send employee invite email: '.$e->getMessage());        	
        }

		return response()->json(['message' => 'Employee added successfully!'], 200);
	}

	public function updateEmployee(Request $request)
	{
		$user = User::find($request->id);
		$user->name = $request->name;
		$user->email = $request->email;

    	$merchant = Auth::user()->merchant;
        MerchantUser::updateOrCreate([
        	'merchant_id' => $merchant->id,
        	'user_id' 	  => $user->id,
        ], [
        	'role'		  => $request->role
        ]);
		return response()->json(['message' => 'Employee updated successfully!'], 200);
	}

	public function deleteEmployee(Request $request)
	{
		$user = User::find($request->id);
    	$merchant = Auth::user()->merchant;

        $record = MerchantUser::where([
        	'user_id' 	  => $user->id,
        	'merchant_id' => $merchant->id
        ])->first();
        $record->delete();

        if($user->current_merchant == $merchant->id) {
        	$user->current_merchant = null;
        }
		return response()->json(['message' => 'Employee deleted successfully!'], 200);
	}
}
