<?php

namespace App\Http\Controllers\Monires;

use Illuminate\Http\Request;

class RefundController extends MonerisController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function refund(Request $request)
    {
        $response = $this->gateway->refund($request->trans_id, $request->receipt_id, $request->amount);

        if(count($response->errors) > 0) {
            return response()->json($response->errors);
        }
        
        return response()->json($response->receipt());
    }
}
