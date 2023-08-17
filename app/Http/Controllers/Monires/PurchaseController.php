<?php

namespace App\Http\Controllers\Monires;

use Illuminate\Http\Request;

class PurchaseController extends MonerisController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function purchase(Request $request)
    {
        $params = [
            'order_id' => $request->order_id ?? uniqid('1234-56789', true),
            'amount' => $request->amount,
            'credit_card' => $request->credit_card,
            'expiry_month' => $request->expiry_month,
            'expiry_year' => $request->expiry_year,
            'expdate' => $request->expiry_year,
        ];
        
        $response = $this->gateway->purchase($params);

        if(count($response->errors) > 0) {
            return response()->json($response->errors);
        }

        return response()->json($response->receipt());
    }
}
