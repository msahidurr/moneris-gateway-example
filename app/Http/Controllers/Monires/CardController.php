<?php

namespace App\Http\Controllers\Monires;

use App\Moneris\CreditCard;
use Illuminate\Http\Request;

class CardController extends MonerisController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function update(Request $request)
    {
        $vault = $this->gateway->cards();

        $card = CreditCard::create($request->credit_card ?? '', $request->expiry_year ?? '');

        $response = $vault->update($request->key, $card);

        if (count($response->errors) > 0) {
            return response()->json($response->errors);
        }

        return response()->json($response->transaction->response->receipt);
    }

    public function destroy(Request $request)
    {
        $vault = $this->gateway->cards();

        $response = $vault->delete($request->key);

        if (count($response->errors) > 0) {
            return response()->json($response->errors);
        }

        return response()->json($response->transaction->response->receipt);
    }
}
