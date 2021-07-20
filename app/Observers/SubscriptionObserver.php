<?php

namespace App\Observers;

use App\Mail\CancelSubscription;
use App\Mail\UpgradeSubscription;
use App\Models\Plan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Laravel\Cashier\Subscription;

class SubscriptionObserver
{
    public function created(Subscription $subscription)
    {
        Mail::to($subscription->owner->owner->email)->send(new UpgradeSubscription($subscription->plan_id));
    }

    public function creating(Subscription $subscription)
    {
        $this->updatePlanId($subscription);
    }

    public function updating(Subscription $subscription)
    {
        $this->updatePlanId($subscription);

        if($subscription->stripe_status == "canceled") {
            // Send Cancel Subscription Mail
            Mail::to($subscription->owner->owner->email)->send(new CancelSubscription($plan));

        } else {
            // Send Upgrade Subscription Mail
            $plan = Plan::find($subscription->plan_id);
            $oldplanOrder = $subscription->getOriginal('plan_id') && Plan::find($subscription->getOriginal('plan_id')) ? Plan::find($subscription->getOriginal('plan_id'))->growth_order : 0;
            
            if($plan->growth_order > $oldplanOrder) {
                Mail::to($subscription->owner->owner->email)->send(new UpgradeSubscription($plan));
            }
        }
    }

    public function updatePlanId($subscription)
    {
        if($subscription->stripe_plan) {
            $plan = Plan::where('stripe_plan', $subscription->stripe_plan)
                        ->orWhere('yearly_stripe_plan', $subscription->stripe_plan)
                        ->first();
            if($plan) {
                $subscription->unsetEventDispatcher();
                $subscription->plan_id = $plan->id;
                $subscription->is_yearly = $subscription->stripe_plan == $plan->yearly_stripe_plan ? 1 : 0;
            }
        }
    }
}
