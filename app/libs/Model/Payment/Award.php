<?php
namespace App\Model\Payment;

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
	 * @var Wallet
	 * @ORM\ManyToOne(targetEntity=Wallet::class, inversedBy="transactions")
	 */
	protected $wallet;

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


	public function __construct(Wallet $wallet, $amount)
	{
		$this->wallet = $wallet;
		$this->amount = $amount;
		$this->createdAt = new \DateTime();
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

}
