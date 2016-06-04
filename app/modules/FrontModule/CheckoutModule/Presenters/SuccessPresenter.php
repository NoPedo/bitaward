<?php
namespace App\FrontModule\CheckoutModule\Presenters;

use App\FrontModule\Presenters\BasePresenter;
use App\Model\Payment\Checkout;
use Coinbase\Wallet\Client;
use Doctrine\ORM\EntityManager;

class SuccessPresenter extends BasePresenter
{

	/** @var Client */
	private $client;

	/** @var EntityManager */
	private $entityManager;


	public function __construct(Client $client, EntityManager $entityManager)
	{
		$this->client = $client;
		$this->entityManager = $entityManager;
	}


	public function actionDefault()
	{
		/** @var Checkout $checkout */
		$checkout = $this->entityManager->getRepository(Checkout::class)->findOneBy(['checkoutId' => $this->getParameter('order')['button']['uuid']]);
		if (!$checkout) {
			$this->error();
		}
		$order = $this->client->getOrder($this->getParameters()['order']['uuid']);
		if ($order->getStatus() === 'paid') {
			$checkout->pay();
			$this->entityManager->flush($checkout);
		}
	}
}
