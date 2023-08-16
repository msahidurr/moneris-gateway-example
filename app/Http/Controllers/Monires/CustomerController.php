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
            'email' => $request->email ?? 'example@email.com',
            'phone' => $request->phone ??'555-555-5555',
            'note' => $request->note ??'Customer note',
        ];
        
        $customer = Customer::create($params);
        $card = CreditCard::create('4242424242424242', '2012');
        $card = $card->attach($customer);
        
        // $response = $vault->add($card);
        // $key = $response->receipt()->read('key');
        
        // $card->customer->email = 'example2@email.com';
        
        // $response = $vault->update($key, $card);
    }
}
