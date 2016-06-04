<?php
namespace App\Model\Payment;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\Attributes\Identifier;
use Nette\Object;

/**
 * @ORM\Entity
 */
class Wallet extends Object
{
	use Identifier;

	/**
	 * @var string
	 * @ORM\Column(type="string")
	 */
	protected $address;


	/**
	 * @param string
	 */
	public function __construct($address)
	{
		$this->address = $address;
	}


	/**
	 * @return string
	 */
	public function getAddress()
	{
		return $this->address;
	}


}
