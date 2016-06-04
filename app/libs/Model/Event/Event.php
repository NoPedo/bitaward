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

}
