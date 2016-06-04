<?php
namespace App\Model\Payment;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\Attributes\Identifier;
use Nette\Object;

/**
 * @ORM\Entity
 */
class Checkout extends Object
{
	use Identifier;

	/**
	 * @var \DateTime
	 * @ORM\Column(type="datetime")
	 */
	protected $createdAt;

	/**
	 * @var \DateTime
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $paidAt;

	/**
	 * @var float
	 * @ORM\Column(type="decimal", precision=10, scale=6)
	 */
	protected $amount = 0;

	/**
	 * @var string
	 * @ORM\Column(type="string")
	 */
	protected $checkoutId;

	/**
	 * @var string
	 * @ORM\Column(type="string")
	 */
	protected $embedCode;


	/**
	 * @var Award[]|\Doctrine\Common\Collections\Collection
	 * @ORM\OneToMany(targetEntity=Award::class, mappedBy="checkout")
	 */
	protected $awards;


	public function __construct()
	{
		$this->createdAt = new \DateTime();
		$this->awards = new ArrayCollection();
	}


	public function addAmount($amount)
	{
		$this->amount += $amount;
	}


	/**
	 * @return float
	 */
	public function getAmount()
	{
		return $this->amount;
	}


	/**
	 * @return \DateTime
	 */
	public function getCreatedAt()
	{
		return $this->createdAt;
	}


	/**
	 * @return \DateTime
	 */
	public function getPaidAt()
	{
		return $this->paidAt;
	}


	/**
	 * @param string
	 */
	public function setEmbedCode($embedCode)
	{
		$this->embedCode = $embedCode;
	}


	/**
	 * @param string
	 */
	public function setCheckoutId($checkoutId)
	{
		$this->checkoutId = $checkoutId;
	}

	

	/**
	 * @return string
	 */
	public function getCheckoutId()
	{
		return $this->checkoutId;
	}


	/**
	 * @return string
	 */
	public function getEmbedCode()
	{
		return $this->embedCode;
	}


	public function pay()
	{
		$this->paidAt = new \DateTime();
	}

}
