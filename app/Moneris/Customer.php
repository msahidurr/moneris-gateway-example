<?php

namespace App\Moneris;

use App\Moneris\Gettable;
use App\Moneris\Settable;

class Customer
{
    use Gettable, Settable;

    /**
     * The Customer ID.
     *
     * @var string
     */
    protected $id;

    /**
     * The Customer email.
     *
     * @var string
     */
    protected $email;

    /**
     * The Customer phone.
     *
     * @var string
     */
    protected $phone;

    /**
     * The Customer note.
     *
     * @var string
     */
    protected $note;
    protected $avs_street_name;
    protected $avs_street_number;
    protected $avs_zipcode;
    protected $cust_id;

    /**
     * Create a new Customer instance.
     *
     * @param array $params
     *
     * @return void
     */
    public function __construct(array $params = [])
    {
        $this->id = $params['id'] ?? null;
        $this->email = $params['email'] ?? null;
        $this->phone = $params['phone'] ?? null;
        $this->note = $params['note'] ?? null;
        $this->avs_street_name = $params['avs_street_name'] ?? null;
        $this->avs_street_number = $params['avs_street_number'] ?? null;
        $this->avs_zipcode = $params['avs_zipcode'] ?? null;
        $this->cust_id = $params['cust_id'] ?? null;
    }

    /**
     * Create a new Customer instance.
     *
     * @param array $params
     *
     */
    public static function create(array $params = [])
    {
        return new static($params);
    }
}
