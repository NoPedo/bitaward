<?php
namespace App\Model\Event;

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

}
