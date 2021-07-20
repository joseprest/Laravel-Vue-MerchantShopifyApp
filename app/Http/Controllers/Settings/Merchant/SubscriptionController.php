<?php

namespace App\Http\Controllers\Settings\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Stripe\BillingPortal\Session as StripeSession;
use Stripe\Stripe;

class SubscriptionController extends Controller
{
    public function upgrade()
    {
        $merchant = Auth::user()->merchant;
        $plans = Plan::where('stripe_plan', '<>', '')->get();
        $intent = $merchant ? $merchant->createSetupIntent() : '';

        return view('account.upgrade', compact('merchant', 'intent', 'plans'));
    }

    public function create(Request $request)
    {
		$plan = Plan::find($request->plan);
    	$merchant = Auth::user()->merchant;
        try {
            app('stripe_service')->subscriptionUpdateOrCreate(
                $merchant,
                $plan, 
                $request->paymentMethod, 
                $request->is_yearly
            );
            return redirect()->back()->with('success', 'You’ve successfully upgraded to the '.$plan->name.' plan.');
        } catch (\Exception $e) {
            Log::error('Stripe upgrade plan error: '. $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong while processing your payment. Please contact us.');
        }
    }

    public function stripePortal(Request $request)
    {
        $merchant = Auth::user()->merchant;
        if($merchant->stripe_id) {
            try {
                Stripe::setApiKey(config("services.stripe.secret"));
                $session = StripeSession::create([
                    'customer' => $merchant->stripe_id,
                    'return_url' => url('/home'),
                ]);
                return redirect($session->url);
            } catch (\Exception $e) {
                Log::error('Stripe Portal Error: '.$e->getMessage());
            }
        }
        return redirect()->back();
    }
}
