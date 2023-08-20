<?php

namespace App\Moneris;

use App\Moneris\Gettable;
use App\Moneris\CreditCard;

class Vault extends Gateway
{
    use Gettable;

    /**
     * Create a new Vault instance.
     *
     * @param string $id
     * @param string $token
     * @param string $environment
     *
     * @return void
     */
    public function __construct(string $id, string $token, string $environment)
    {
        parent::__construct($id, $token, $environment);
    }

    /**
     * Add a credit card to the Vault.
     *
     */
    public function add(CreditCard $card)
    {
        $params = [
            'type' => 'res_add_cc',
            'crypt_type' => $card->crypt,
            'pan' => $card->number,
            'expdate' => $card->expiry,
            'email' => $card->customer->email ?? '',
            'cust_id' => $card->customer->cust_id ?? '',
            'phone' => $card->customer->phone ?? '',
            'note' => $card->customer->note ?? '',
            'avs_street_number' => $card->customer->avs_street_number ?? '',
            'avs_street_name' => $card->customer->avs_street_name ?? '',
            'avs_zipcode' => $card->customer->avs_zipcode ?? '',
        ];

        $transaction = $this->transaction($params);

        return $this->process($transaction);
    }

    /**
     * Create a new Vault instance.
     *
     * @param string $id
     * @param string $token
     * @param string $environment
     *
     * @return $this
     */
    public static function create(string $id, string $token, string $environment)
    {
        return new static($id, $token, $environment);
    }

    /**
     * Delete a credit card from the Vault.
     *
     * @param string $key
     */
    public function delete(string $key)
    {
        $params = [
            'type' => 'res_delete',
            'data_key' => $key,
        ];

        $transaction = $this->transaction($params);

        return $this->process($transaction);
    }

    /**
     * Get all expiring credit cards from the Moneris Vault.
     *
     */
    public function expiring()
    {
        $params = ['type' => 'res_get_expiring'];

        $transaction = $this->transaction($params);

        return $this->process($transaction);
    }

    /**
     * Peek into the Moneris Vault and retrieve a credit card
     * profile associated with a given data key.
     *
     * @param string $key
     * @param bool $full
     *
     */
    public function peek(string $key, bool $full = false)
    {
        $params = [
            'type' => $full ? 'res_lookup_full' : 'res_lookup_masked',
            'data_key' => $key,
        ];

        $transaction = $this->transaction($params);

        return $this->process($transaction);
    }

    /**
     * Pre-authorize a purchase.
     *
     * @param array $params
     */
    public function preauth(array $params = [])
    {
        $params = array_merge($params, [
            'type' => 'res_preauth_cc',
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
            'type' => 'res_purchase_cc',
            'crypt_type' => Crypt::SSL_ENABLED_MERCHANT,
        ]);

        $transaction = $this->transaction($params);

        return $this->process($transaction);
    }

    /**
     * Tokenize a previous transaction to save the credit
     * card used in the Moneris Vault.
     *
     * @param $transaction
     * @param string|null $order
     */
    public function tokenize($transaction, string $order = null)
    {
        if ($transaction instanceof Transaction) {
            $order = $transaction->order();
            $transaction = $transaction->number();
        }

        $params = [
            'type' => 'res_tokenize_cc',
            'txn_number' => $transaction,
            'order_id' => $order,
        ];

        $transaction = $this->transaction($params);

        return $this->process($transaction);
    }

    /**
     * Update an existing credit card in the Vault.
     *
     * @param string $key
     */
    public function update(string $key, CreditCard $card)
    {
        $params = [
            'type' => 'res_update_cc',
            'data_key' => $key,
            'crypt_type' => $card->crypt,
            'pan' => $card->number,
            'expdate' => $card->expiry,
            'email' => $card->customer->email ?? '',
            'cust_id' => $card->customer->cust_id ?? '',
            'phone' => $card->customer->phone ?? '',
            'note' => $card->customer->note ?? '',
            'avs_street_number' => $card->customer->avs_street_number ?? '',
            'avs_street_name' => $card->customer->avs_street_name ?? '',
            'avs_zipcode' => $card->customer->avs_zipcode ?? '',
        ];

        $transaction = $this->transaction($params);

        return $this->process($transaction);
    }
}
