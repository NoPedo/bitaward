<?php

namespace App\Services\Payment;

use Coinbase\Wallet\Client;
use Coinbase\Wallet\Configuration;

/**
 * Class CoinbaseManager
 * @package App\Services\Payment
 */
class CoinbaseManager
{
	/** @var Client */
	private $client;

	/**
	 * CoinbaseManager constructor.
	 * @param Configuration $configuration
	 */
	public function __construct(Configuration $configuration)
	{
		$this->client = Client::create($configuration);
	}
}
