<?php

namespace App;

use App\Models\MerchantIntegration;
use App\Models\Plan;
use Illuminate\Database\Eloquent\Model;
use Laravel\Cashier\Billable;

class Merchant extends Model
{
	use Billable;

    protected $guarded = ['plan_id'];

    protected $appends = ['email', 'plan', 'is_subscription_yearly'];

    public function owner()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'merchant_user')->withPivot('role', 'created_at');
    }

    public function integrations()
    {
        return $this->hasMany(MerchantIntegration::class, 'merchant_id');
    }

    public function platform()
    {
        return $this->hasOne(MerchantIntegration::class, 'merchant_id')->where('is_platform', 1);
    }

    public function hasPermission($feature)
    {
        $growthOrder = config('permissions.features.'.$feature);
        if(!$growthOrder) return true;
        if(!$this->plan) return false;
        return $this->plan->growth_order >= $growthOrder;
    }

    public function getPlanAttribute()
    {
        $subscription = $this->subscription('default');
        if($subscription && $subscription->plan_id && ($this->onTrial('default') || $subscription->stripe_status == "active")) {
            return Plan::find($subscription->plan_id);
        }
        return null;
    }

    public function getIsSubscriptionYearlyAttribute()
    {
        $subscription = $this->subscription('default');
        return $subscription ? $subscription->is_yearly : 0;
    }

    public function getEmailAttribute()
    {
        return $this->owner->email;
    }
}
