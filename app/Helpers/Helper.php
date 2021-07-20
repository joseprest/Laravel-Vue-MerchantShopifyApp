<?php

use App\Models\Plan;

function has_permission($feature, $merchant = null)
{
    if(!$merchant) $merchant = Auth::user()->merchant;
    return $merchant ? $merchant->hasPermission($feature) : false;
}

function feature_plan($feature)
{
    $growthOrder = config('permissions.features.'.$feature);
    if(!$growthOrder) {
        return Plan::orderBy('growth_order', 'asc')->first();
    } else {
        return Plan::where('growth_order', $growthOrder)->first();
    }
}
