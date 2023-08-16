<?php

namespace App\Http\Controllers\Monires;

use Illuminate\Http\Request;

class PreAuthorization extends MonerisController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function authorization(Request $request)
    {
        $params = [
            'order_id' => uniqid('1234-56789', true),
            'amount' => $request->amount ?? '1.00',
            'credit_card' => $request->amount ?? '4242424242424242',
            'expiry_month' => $request->expiry_month ?? '12',
            'expiry_year' => $request->expiry_year ?? '26',
            'expdate' => $request->expiry_year ?? '2026',
        ];
        
        $response = $this->gateway->preauth($params);
        
        $response = $this->gateway->capture($response->transaction);

        return response()->json($response);
    }
}
