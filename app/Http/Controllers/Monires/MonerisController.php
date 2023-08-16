<?php

namespace App\Http\Controllers\Monires;

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
}
