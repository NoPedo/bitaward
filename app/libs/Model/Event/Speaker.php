<?php
namespace App\Model\Event;

use App\Model\Payment\Wallet;
use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\Attributes\Identifier;
use Nette\Object;

/**
 * @ORM\Entity
 */
class Speaker extends Object
{
	use Identifier;

	/**
	 * @var Event
	 * @ORM\ManyToOne(targetEntity=Event::class, inversedBy="speakers")
	 */
	protected $event;

	/**
	 * @var string
	 * @ORM\Column(type="string")
	 */
	protected $name;

	/**
	 * @var string
	 * @ORM\Column(type="string")
	 */
	protected $talkTitle;

	/**
	 * @var Wallet
	 * @ORM\ManyToOne(targetEntity=Wallet::class)
	 * @ORM\JoinColumn(nullable=true)
	 */
	protected $wallet;


	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}


	/**
	 * @return string
	 */
	public function getTalkTitle()
	{
		return $this->talkTitle;
	}


	/**
	 * @return Wallet
	 */
	public function resolveWallet()
	{
		return $this->wallet ?: $this->event->getWallet();
	}


	/**
	 * @return Event
	 */
	public function getEvent()
	{
		return $this->event;
	}

	/**
	 * @param Event $event
	 */
	public function setEvent($event)
	{
		$this->event = $event;
	}

	/**
	 * @param string $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * @param string $talkTitle
	 */
	public function setTalkTitle($talkTitle)
	{
		$this->talkTitle = $talkTitle;
	}

	/**
	 * @param Wallet $wallet
	 */
	public function setWallet($wallet)
	{
		$this->wallet = $wallet;
	}


}
