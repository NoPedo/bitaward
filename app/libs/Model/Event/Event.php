<?php
namespace App\Model\Event;

use App\Model\Payment\Wallet;
use App\Model\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\Attributes\Identifier;
use Nette\Object;

/**
 * @ORM\Entity
 */
class Event extends Object
{
	use Identifier;


	/**
	 * @var string
	 * @ORM\Column(type="string")
	 */
	protected $name;

	/**
	 * @var User
	 * @ORM\ManyToOne(targetEntity=User::class)
	 */
	protected $owner;

	/**
	 * @var string
	 * @ORM\Column(type="string", length=15)
	 */
	protected $hashtag;

	/**
	 * @var \DateTime
	 * @ORM\Column(type="date", nullable=true)
	 */
	protected $date;

	/**
	 * @var Speaker[]|\Doctrine\Common\Collections\Collection
	 * @ORM\OneToMany(targetEntity=Speaker::class, mappedBy="event")
	 */
	protected $speakers;

	/**
	 * @var Wallet
	 * @ORM\ManyToOne(targetEntity=Wallet::class)
	 * @ORM\JoinColumn(nullable=false)
	 */
	protected $wallet;


	public function __construct($name, User $owner)
	{
		$this->speakers = new ArrayCollection();
		$this->name = $name;
		$this->owner = $owner;
	}


	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}


	/**
	 * @return \DateTime
	 */
	public function getDate()
	{
		return $this->date;
	}


	/**
	 * @return Speaker[]|\Doctrine\Common\Collections\Collection
	 */
	public function getSpeakers()
	{
		return $this->speakers;
	}


	/**
	 * @param string $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}


	/**
	 * @param \DateTime $date
	 */
	public function setDate($date)
	{
		$this->date = $date;
	}


	/**
	 * @return string
	 */
	public function getHashtag()
	{
		return $this->hashtag;
	}


	/**
	 * @param string $hashtag
	 */
	public function setHashtag($hashtag)
	{
		$this->hashtag = $hashtag;
	}


	/**
	 * @return Wallet
	 */
	public function getWallet()
	{
		return $this->wallet;
	}

	/**
	 * @param Wallet $wallet
	 */
	public function setWallet($wallet)
	{
		$this->wallet = $wallet;
	}

}
