<?php

namespace App\Repositories;

use App\Merchant;
use App\Models\MerchantIntegration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\User;
use App\Models\MerchantUser;

class MerchantRepository
{
    /**
     * Store Integration
     *
     * @param $merchant
     * @param $slug
     * @param $data
     *
     * @return MerchantIntegration $integration
     */
    public function storeIntegration($merchant, $slug, $data = [])
    {
        $data['slug'] = $slug;
        $matchData = ['merchant_id' => $merchant->id];
        if(in_array($slug, MerchantIntegration::ECOMMERCE_PLATFORMS)) {
            $matchData['is_platform'] = 1;
        } else {
            $matchData['slug'] = $slug;
        }
        
        $integration = MerchantIntegration::updateOrCreate(
            $matchData,
            array_only($data, ['slug', 'api_endpoint', 'access_token'])
        );
        return $integration;
    }

    /**
     * Find Merchant by Platform Domain 
     *
     * @param $endpoint
     *
     * @return Merchant $merchant
     */
    public function findByIntegrationEndpoint($endpoint, $with = [])
    {
        return Merchant::whereHas('platform', function($query) use ($endpoint) {
            return $query->where('api_endpoint', $endpoint);
        })->with($with)->first();
    }
    /**
     * Create Merchant
     * @param $data
     * @return Merchant $merchant
     */
    public function createMerchantAndUser($data) 
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email']
        ]);
        $merchant = Merchant::create([
    		'user_id' => $user->id,
    		'name' 	  => $data['name'] ?? '',
    		'website' => $data['website']?? '',
            'country_name' => $data['countryName']?? '',
            'billing_email' => $data['email'] ?? ''
    	]);

        MerchantUser::create([
            'merchant_id' => $merchant->id,
            'user_id' => $user->id,
            'role' => ''
        ]);
        
        $merchantIntegration = MerchantIntegration::create([
            'merchant_id' => $merchant->id,
            'slug' => '',
            'is_platform' => 1,
            'status' => 1
        ]);

        return $merchantIntegration;
    }
}
