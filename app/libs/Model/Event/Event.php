<?php
namespace App\Model\Event;

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
	 * @var string
	 * @ORM\Column(type="string", length=10)
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


	public function __construct($name)
	{
		$this->speakers = new ArrayCollection();
		$this->name = $name;
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

}
