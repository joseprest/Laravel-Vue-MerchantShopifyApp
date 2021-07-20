<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MerchantIntegration extends Model
{
	const ECOMMERCE_PLATFORMS = [
		'shopify',
		'woocommerce',
		'magento',
		'bigcommerce'
	];

    protected $guarded = ['id'];

    protected $casts = [
        'settings' => 'array'
    ];
}
