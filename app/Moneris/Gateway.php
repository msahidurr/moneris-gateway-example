<?php

namespace App\Moneris;

use App\Moneris\Gettable;
use App\Moneris\Settable;
use App\Moneris\Vault;
use App\Moneris\Crypt;
use App\Moneris\Transaction;

class Gateway
{
    use Gettable, Settable;

    /**
     * Determine if we will use the Address Verification Service.
     *
     * @var bool
     */
    protected $avs = false;

    /**
     * @var array
     */
    protected $avsCodes = ['A', 'B', 'D', 'M', 'P', 'W', 'X', 'Y', 'Z'];

    /**
     * Determine if we will use the Card Validation Digits.
     *
     * @var bool
     */
    protected $cvd = false;

    /**
     * @var array
     */
    protected $cvdCodes = ['M', 'Y', 'P', 'S', 'U'];

    /**
     * The environment used for connecting to the Moneris API.
     *
     * @var string
     */
    protected $environment;

    /**
     * The Moneris Store ID.
     *
     * @var string
     */
    protected $id;

    /**
     * The Moneris API Token.
     *
     * @var string
     */
    protected $token;


    protected $transaction;

    /**
     * Create a new Moneris instance.
     *
     * @param string $id
     * @param string $token
     * @param string $environment
     *
     * @return void
     */
    public function __construct(string $id, string $token, string $environment)
    {
        $this->id = $id;
        $this->token = $token;
        $this->environment = $environment;
    }

    public function capture($transaction, string $order = null, $amount = null)
    {
        if ($transaction instanceof Transaction) {
            $order = $transaction->order();
            $amount = $amount ?? $transaction->amount();
            $transaction = $transaction->number();
        }

        $params = [
            'type' => 'completion',
            'crypt_type' => Crypt::SSL_ENABLED_MERCHANT,
            'comp_amount' => $amount,
            'txn_number' => $transaction,
            'order_id' => $order,
        ];

        $transaction = $this->transaction($params);

        return $this->process($transaction);
    }

    public function cards()
    {
        $vault = new Vault($this->id, $this->token, $this->environment);

        if (isset($this->avs)) {
            $vault->avs = boolval($this->avs);
        }

        if (isset($this->cvd)) {
            $vault->cvd = boolval($this->cvd);
        }

        return $vault;
    }

    public function preauth(array $params = [])
    {
        $params = array_merge($params, [
            'type' => 'preauth',
            'crypt_type' => Crypt::SSL_ENABLED_MERCHANT,
        ]);

        $transaction = $this->transaction($params);

        return $this->process($transaction);
    }

    /**
     * Make a purchase.
     *
     * @param array $params
     *
     */
    public function purchase(array $params = [])
    {
        $params = array_merge($params, [
            'type' => 'purchase',
            'crypt_type' => Crypt::SSL_ENABLED_MERCHANT,
        ]);

        $transaction = $this->transaction($params);

        return $this->process($transaction);
    }

    /**
     * Process a transaction through the Moneris API.
     */
    protected function process(Transaction $transaction)
    {
        return Processor::process($transaction);
    }

    /**
     * Refund a transaction.
     *
     * @param string|null $order
     *
     */
    public function refund($transaction, string $order = null, $amount = null)
    {
        if ($transaction instanceof Transaction) {
            $order = $transaction->order();
            $amount = $amount ?? $transaction->amount();
            $transaction = $transaction->number();
        }

        $params = [
            'type' => 'refund',
            'crypt_type' => Crypt::SSL_ENABLED_MERCHANT,
            'amount' => $amount,
            'txn_number' => $transaction,
            'order_id' => $order,
        ];

        $transaction = $this->transaction($params);

        return $this->process($transaction);
    }

    /**
     * Get or create a new Transaction instance.
     *
     * @param array|null $params
     *
     */
    protected function transaction(array $params = null)
    {
        if (is_null($this->transaction) || !is_null($params)) {
            return $this->transaction = new Transaction($this, $params);
        }

        return $this->transaction;
    }

    /**
     * Validate CVD and/or AVS prior to attempting a purchase.
     *
     * @param array $params
     *
     */
    public function verify(array $params = [])
    {
        $params = array_merge($params, [
            'type' => 'card_verification',
            'crypt_type' => Crypt::SSL_ENABLED_MERCHANT,
        ]);

        $transaction = $this->transaction($params);

        return $this->process($transaction);
    }

    /**
     * Void a transaction.
     *
     * @param string|null $order
     *
     */
    public function void($transaction, string $order = null)
    {
        if ($transaction instanceof Transaction) {
            $order = $transaction->order();
            $transaction = $transaction->number();
        }

        $params = [
            'type' => 'purchasecorrection',
            'crypt_type' => Crypt::SSL_ENABLED_MERCHANT,
            'txn_number' => $transaction,
            'order_id' => $order,
        ];

        $transaction = $this->transaction($params);

        return $this->process($transaction);
    }
}
