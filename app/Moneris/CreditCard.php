<?php

namespace App\Moneris;

use App\Moneris\Gettable;
use App\Moneris\Settable;

class CreditCard
{
    use Gettable, Settable;

    /**
     * @var int
     */
    protected $crypt;

    /**
     */
    protected $customer = null;

    /**
     * @var string
     */
    protected $expiry;

    /**
     * @var string
     */
    protected $number;

    /**
     * Create a new CreditCard instance.
     *
     * @param string $number
     * @param string $expiry
     * @param int $crypt
     *
     * @return void
     */
    public function __construct(string $number, string $expiry, int $crypt = 7)
    {
        $this->number = $number;
        $this->expiry = $expiry;
        $this->crypt = $crypt;
    }

    /**
     * Attach a provided customer to the CreditCard instance.
     *
     * @return $this
     */
    public function attach(Customer $customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Create a new CreditCard instance.
     *
     * @param string $number
     * @param string $expiry
     * @param int $crypt
     *
     * @return $this
     */
    public static function create(string $number, string $expiry, int $crypt = 7)
    {
        return new static($number, $expiry, $crypt);
    }
}
