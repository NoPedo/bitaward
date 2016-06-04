<?php
namespace App\Model\Payment;

use App\Model\Event\Event;
use App\Model\Event\Speaker;
use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\Attributes\Identifier;
use Nette\Object;

/**
 * @ORM\Entity
 */
class Award extends Object
{
	use Identifier;

	/**
	 * @var Event
	 * @ORM\ManyToOne(targetEntity=Event::class)
	 * @ORM\JoinColumn(nullable=false)
	 */
	protected $event;

	/**
	 * @var Speaker
	 * @ORM\ManyToOne(targetEntity=Speaker::class)
	 * @ORM\JoinColumn(nullable=true)
	 */
	protected $speaker;

	/**
	 * @var Wallet
	 * @ORM\ManyToOne(targetEntity=Wallet::class, inversedBy="transactions")
	 * @ORM\JoinColumn(nullable=false)
	 */
	protected $wallet;

	/**
	 * @var Checkout
	 * @ORM\ManyToOne(targetEntity=Checkout::class)
	 * @ORM\JoinColumn(nullable=false)
	 */
	protected $checkout;

	/**
	 * Without fee
	 * @var float
	 * @ORM\Column(type="decimal", precision=10, scale=2)
	 */
	protected $amount;

	/**
	 * @var \DateTime
	 * @ORM\Column(type="datetime")
	 */
	protected $createdAt;

	/**
	 * @var \DateTime
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $payoutAt;


	private function __construct(Checkout $checkout, Event $event, Speaker $speaker = NULL, Wallet $wallet, $amount)
	{
		$this->wallet = $wallet;
		$this->amount = $amount;
		$this->createdAt = new \DateTime();
		$this->event = $event;
		$this->speaker = $speaker;
		$this->checkout = $checkout;
	}


	/**
	 * @return mixed
	 */
	public function getAmount()
	{
		return $this->amount;
	}


	public function pay()
	{
		if ($this->payoutAt !== NULL) {
			throw new \RuntimeException;
		}
		$this->payoutAt = new \DateTime();
	}


	public static function forOrganizer(Checkout $checkout, Event $event, $amount)
	{
		return new self($checkout, $event, NULL, $event->getWallet(), $amount);
	}


	public static function forSpeaker(Checkout $checkout, Speaker $speaker, $amount)
	{
		return new self($checkout, $speaker->getEvent(), $speaker, $speaker->resolveWallet(), $amount);
	}

}
