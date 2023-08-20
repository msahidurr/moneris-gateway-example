<?php

namespace App\Http\Controllers\Monires;

use App\Moneris\Customer;
use App\Moneris\CreditCard;
use Illuminate\Http\Request;

class CustomerController extends MonerisController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function store(Request $request)
    {
        $params = [
            'id' => uniqid('customer-', true),
            'cust_id' => $request->cust_id ?? uniqid('customer-', true),
            'email' => $request->email,
            'phone' => $request->phone,
            'note' => $request->note,
            'avs_street_number' => $request->avs_street_number,
            'avs_street_name' => $request->avs_street_name,
            'avs_zipcode' => $request->avs_zipcode,
        ];
        
        $vault = $this->gateway->cards();
        
        $customer = Customer::create($params);
        $card = CreditCard::create($request->credit_card, $request->expiry_year);
        $card = $card->attach($customer);
        $response = $vault->add($card);

        if(count($response->errors) > 0) {
            return response()->json($response->errors);
        }

        return response()->json($response->transaction->response->receipt);
    }
    
    public function update(Request $request, $key = null)
    {
        $params = [
            'id' => uniqid('customer-', true),
            'cust_id' => $request->cust_id ?? uniqid('customer-', true),
            'email' => $request->email,
            'phone' => $request->phone,
            'note' => $request->note,
            'avs_street_number' => $request->avs_street_number,
            'avs_street_name' => $request->avs_street_name,
            'avs_zipcode' => $request->avs_zipcode,
        ];
        
        $vault = $this->gateway->cards();
        
        $customer = Customer::create($params);
        $card = CreditCard::create($request->credit_card, $request->expiry_year);
        $card = $card->attach($customer);
        
        $response = $vault->update($key ?? $request->key, $card);

        if(count($response->errors) > 0) {
            return response()->json($response->errors);
        }

        return response()->json($response->transaction->response->receipt);
    }

    public function show(Request $request, $key = null)
    {        
        $vault = $this->gateway->cards();
        
        $response = $vault->peek($key ?? $request->key);

        if(count($response->errors) > 0) {
            return response()->json($response->errors);
        }

        return response()->json($response->receipt());
    }
}
