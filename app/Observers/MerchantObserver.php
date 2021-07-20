<?php

namespace App\Observers;

use App\Merchant;
use Illuminate\Support\Facades\Auth;

class MerchantObserver
{
    /**
     * Handle the merchant "created" event.
     *
     * @param  \App\Merchant  $merchant
     * @return void
     */
    public function created(Merchant $merchant)
    {
        // Switch to Merchant
        $user = Auth::user();
        if($user) {
            $user->merchants()->syncWithoutDetaching($merchant);
            $user->current_merchant = $merchant->id;
            $user->save();
        }
    }

    /**
     * Handle the merchant "updated" event.
     *
     * @param  \App\Merchant  $merchant
     * @return void
     */
    public function updated(Merchant $merchant)
    {
        //
    }

    /**
     * Handle the merchant "deleted" event.
     *
     * @param  \App\Merchant  $merchant
     * @return void
     */
    public function deleted(Merchant $merchant)
    {
        //
    }

    /**
     * Handle the merchant "restored" event.
     *
     * @param  \App\Merchant  $merchant
     * @return void
     */
    public function restored(Merchant $merchant)
    {
        //
    }

    /**
     * Handle the merchant "force deleted" event.
     *
     * @param  \App\Merchant  $merchant
     * @return void
     */
    public function forceDeleted(Merchant $merchant)
    {
        //
    }
}
