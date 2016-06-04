<?php
namespace App\Model\Payment;

use App\Model\Event\Event;
use App\Model\Event\Speaker;
use Coinbase\Wallet\Client;
use Coinbase\Wallet\Resource\Checkout as CoinbaseCheckout;
use Coinbase\Wallet\Value\Money;
use Doctrine\ORM\EntityManager;
use Nette\Application\LinkGenerator;
use Nette\Object;

class AwardCheckout extends Object
{

	/** @var AccountProvider */
	private $accountProvider;

	/** @var Client */
	private $coinbaseClient;

	/** @var EntityManager */
	private $entityManager;

	/** @var LinkGenerator */
	private $linkGenerator;


	public function __construct(Client $coinbaseClient, AccountProvider $accountProvider, EntityManager $entityManager, LinkGenerator $linkGenerator)
	{
		$this->accountProvider = $accountProvider;
		$this->coinbaseClient = $coinbaseClient;
		$this->entityManager = $entityManager;
		$this->linkGenerator = $linkGenerator;
	}


	/**
	 * @param Event $event
	 * @param $organizerAmount
	 * @param array $speakersAmount
	 * @return Checkout
	 */
	public function createCheckout(Event $event, $organizerAmount, array $speakersAmount)
	{
		$checkout = new Checkout();
		if ($organizerAmount > 0) {
			$award = Award::forOrganizer($checkout, $event, $organizerAmount);
			$this->entityManager->persist($award);
			$checkout->addAmount($organizerAmount);
		}
		/** @var Speaker $speaker */
		foreach ($event->getSpeakers() as $speaker) {
			if (isset($speakersAmount[$speaker->getId()]) && $speakersAmount[$speaker->getId()] > 0) {
				$award = Award::forSpeaker($checkout, $speaker, $speakersAmount[$speaker->getId()]);
				$this->entityManager->persist($award);
				$checkout->addAmount($award->getAmount());
			}
		}
		if ($checkout->getAmount() === 0) {
			throw new \RuntimeException;
		}
		$coinbaseCheckout = new CoinbaseCheckout([
			'name' => $event->getName() . ' award',
			'amount' => Money::btc($checkout->getAmount()),
		]);
		$coinbaseCheckout->setSuccessUrl($this->linkGenerator->link('Front:Checkout:Success:default'));
		$this->coinbaseClient->createCheckout($coinbaseCheckout);
		$checkout->setCheckoutId($coinbaseCheckout->getId());
		$checkout->setEmbedCode($coinbaseCheckout->getEmbedCode());
		$this->entityManager->persist($checkout);
		$this->entityManager->flush();

		return $checkout;
	}


}
