<?php

namespace App\Http\Controllers\Billing;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Charge;
use PDF;

class BillingController extends Controller
{
    //
    /**
     * Show Billing homepage
     */
    public function index(Request $request) {
        return view('billing.index');
    }
    /**
     * Get transactions
     * @return billings
     */
    public function getBillings(Request $request) {
    }
    /**
     * Download bills
     */
    public function downloadBillings(Request $request) {
        $billings = [];
        $other = [];
        $bill = PDF::loadview('billing.invoice', [
            'data' => $billings,
            'other' => $other
        ]);
        $date = '';
        return $bill->download('Billing_'.$date.'.pdf');
    }

    /**
     * View invoice PDF template
     */
    public function invoice(Request $request) {
        return view('billing.invoice');
    }
}
