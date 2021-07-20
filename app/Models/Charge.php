<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Osiset\ShopifyApp\Services\ChargeHelper;


class Charge extends Model
{
    protected $chargeHelper;
    /**
     * Constructor
     */
    public function __construct(ChargeHelper $chargeHelper) {
        $this->chargeHelper = $chargeHelper;
    }
    public function getChargeFromShopify() {
    }
}
