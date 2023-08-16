<?php

namespace App\Http\Controllers;

use App\Moneris\Moneris;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MonerisController extends Controller
{
    protected $gateway;

    protected $id = "monca08002";

    protected $token = "Otx1Ob8ScDr3oXNe4XRO";

    public function __construct()
    {
        $params = [  
            'environment' => Moneris::ENV_TESTING,
            'avs' => false,
            'cvd' => false,
            'cof' => false,
        ];

        $this->gateway = (new Moneris($this->id, $this->token, $params))->connect();
    }

    public function purchase(Request $request)
    {
        $params = [
            'order_id' => $request->order_id ?? uniqid('1234-56789', true),
            'amount' => $request->amount ?? '1.00',
            'credit_card' => $request->credit_card ?? '4242424242424242',
            'expiry_month' => $request->expiry_month ?? '12',
            'expiry_year' => $request->expiry_year ?? '2026',
            'expdate' => $request->expdate ?? '2026',
        ];
        
        $response = $this->gateway->purchase($params);

        return response()->json($response->transaction->response->receipt ?? []);
    }
}