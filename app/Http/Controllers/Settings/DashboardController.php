<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Merchant;
use App\Repositories\MerchantRepository;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MerchantRepository $merchantRepository)
    {
        $this->merchantRepository = $merchantRepository;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {

        if ($request->route()->getPrefix() == '/app') {

            $shop = Auth::user();
            $response = $shop->api()->request(
                'GET',
                '/admin/api/shop.json',
                []
            );
            if ($response['errors'] != true) {
                $shopData = $response['body']['shop'];

                $email = $shopData['email'];
                $name = $shopData['name'];
                $domain = $shopData['domain'];
                $countryName = $shopData['country_name'];

                // TODO we can update the user email with $email of shopify data
                $merchant = Merchant::where('user_id', '=', $shop->id)->first();

                if (!$merchant) {

                    // TODO now add marchant for the shopify user.
                    $merchant = $this->merchantRepository->createMerchantAndUser($shopData);
                }
            }
        }

        return view('dashboard');
    }
}
