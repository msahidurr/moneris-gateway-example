<?php

namespace App\Moneris;

use App\Moneris\Gateway;
use App\Moneris\Gettable;

class Moneris
{
    use Gettable;

    const ENV_LIVE    = 'live';
    const ENV_STAGING = 'staging';
    const ENV_TESTING = 'testing';

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
     * The extra parameters needed for Moneris.
     *
     * @var array
     */
    protected $params;

    /**
     * The Moneris API Token.
     *
     * @var string
     */
    protected $token;

    /**
     * Create a new Moneris instance.
     *
     * @param string $id
     * @param string $token
     * @param string $environment
     *
     * @return void
     */
    public function __construct(string $id, string $token, array $params = [])
    {
        $this->id = $id;
        $this->token = $token;
        $this->environment = $params['environment'] ?? self::ENV_LIVE;
        $this->params = $params;
    }

    /**
     * Create a new Moneris instance.
     *
     * @param string $id
     * @param string $token
     * @param array $params
     *
     */
    public static function create(string $id, string $token, array $params = [])
    {
        $moneris = new static($id, $token, $params);

        return $moneris->connect();
    }

    /**
     * Create and return a new Gateway instance.
     */
    public function connect()
    {
        $gateway = new Gateway($this->id, $this->token, $this->environment);

        if (isset($this->params['avs'])) {
            $gateway->avs = boolval($this->params['avs']);
        }

        if (isset($this->params['cvd'])) {
            $gateway->cvd = boolval($this->params['cvd']);
        }

        return $gateway;
    }
}
