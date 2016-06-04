<?php
namespace App\Model\Payment;

use Coinbase\Wallet\Client;
use Coinbase\Wallet\Enum\CurrencyCode;
use Coinbase\Wallet\Resource\Transaction;
use Coinbase\Wallet\Value\Money;
use Nette\Object;

class MoneyTransferer extends Object
{

	/** @var AccountProvider */
	private $accountProvider;

	/** @var Client */
	private $coinbaseClient;


	public function __construct(Client $coinbaseClient, AccountProvider $accountProvider)
	{

		$this->accountProvider = $accountProvider;
		$this->coinbaseClient = $coinbaseClient;
	}


	public function send(Wallet $wallet, $amount)
	{
		$transaction = Transaction::send([
			'toBitcoinAddress' => $wallet->getAddress(),
			'amount' => new Money($amount, CurrencyCode::BTC),
			'description' => 'Money transfer from BitAward',
		]);
		$this->coinbaseClient->createAccountTransaction($this->accountProvider->getAccount(), $transaction);
		$transaction->getId();

	}

}
