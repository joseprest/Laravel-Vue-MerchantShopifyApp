<?php

namespace App\Services;

use App\Models\Plan;
use Illuminate\Support\Facades\Auth;

class StripeService
{
    public function subscriptionUpdateOrCreate($merchant, $plan, $paymentMethod, $isYearly = false)
    {
        $user = $merchant->owner;
        $merchant->createOrGetStripeCustomer([
            'name' => $user->name,
            'metadata' => [
                'Merchant Name' => $merchant->name
            ]
        ]);

        $stripePlan = $isYearly == "0" ? $plan->stripe_plan : $plan->yearly_stripe_plan;
        $hadSubscribedBefore = $merchant->subscriptions()->count() > 0;

        if(!$merchant->subscribed('default')) {
            $merchant->updateDefaultPaymentMethod($paymentMethod);
            $newSubscription = $merchant->newSubscription('default', $stripePlan);
            if(!$hadSubscribedBefore) $newSubscription->trialDays(7);
            $newSubscription->withMetadata([
                'MID'          => $merchant->id,
                'Merchant Name' => $merchant->name,
             ])->create($paymentMethod);
        } else {
            $newSubscription = $merchant->subscription('default');
            if($newSubscription->cancelled()) $newSubscription->resume();

            $newSubscription->skipTrial()->swap($stripePlan);
        }
        
        return;
    }
}
