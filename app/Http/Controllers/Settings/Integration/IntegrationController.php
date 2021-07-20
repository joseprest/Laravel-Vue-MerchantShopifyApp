<?php

namespace App\Http\Controllers\Settings\Integration;

use App\Http\Controllers\Controller;
use App\Models\MerchantIntegration;
use App\Repositories\MerchantRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IntegrationController extends Controller
{
    public function __construct(MerchantRepository $merchantRepository)
    {
        $this->merchantRepository = $merchantRepository;
    }

    public function index()
    {
        return view('integrations.index');
    }

    public function shopify()
    {
        return view('integrations.manage.shopify');
    }

    public function get()
    {
    	$merchant = Auth::user()->merchant;
    	return response()->json([
    		'integrations' => $merchant->integrations
    	], 200);
    }

    public function store(Request $request, $slug)
    {
    	$merchant = Auth::user()->merchant;
        $integration = $this->merchantRepository->storeIntegration($merchant, $slug, $request->all());
    	return response()->json([
    		'data' => $integration
    	], 200);
    }

    public function delete(Request $request, $slug)
    {
    	$merchant = Auth::user()->merchant;
    	$integration = MerchantIntegration::where('merchant_id', $merchant->id)->where('slug', $slug)->first();
    	if($integration) $integration->delete();
    	return response()->json([], 200);
    }
}
