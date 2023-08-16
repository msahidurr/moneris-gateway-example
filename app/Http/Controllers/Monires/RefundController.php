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
        $response = $this->gateway->refund($request->transactionId, $request->order_id, $request->amount);

        return response()->json($response ?? []);
    }
}
