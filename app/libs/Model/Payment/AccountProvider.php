<?php
namespace App\Model\Payment;

use Coinbase\Wallet\Client;
use Coinbase\Wallet\Resource\Account;
use Nette\Object;

/**
 * @author David Matejka
 */
class AccountProvider extends Object
{

	/** @var string */
	private $accountId;

	/** @var Account|null */
	private $account;

	/** @var Client */
	private $client;


	public function __construct($accountId, Client $client)
	{

		$this->accountId = $accountId;
		$this->client = $client;
	}


	public function getAccount()
	{
		if ($this->account === NULL) {
			$this->doGetAccount();
		}

		return $this->account;
	}


	private function doGetAccount()
	{
		$this->account = $this->client->getAccount($this->accountId);
	}

}
