<?php
namespace App\Model\Payment;

use Doctrine\ORM\EntityManager;
use Nette\Object;

class PayoutSender extends Object
{

	/** @var EntityManager */
	private $entityManager;

	/** @var MoneyTransferer */
	private $moneyTransferer;


	public function __construct(EntityManager $entityManager, MoneyTransferer $moneyTransferer)
	{

		$this->entityManager = $entityManager;
		$this->moneyTransferer = $moneyTransferer;
	}


	public function send(Wallet $wallet)
	{
		$qb = $this->entityManager->getRepository(Award::class)->createQueryBuilder('award');
		$qb->andWhere('award.wallet = :wallet')
			->setParameter('wallet', $wallet->getId());
		$qb->andWhere('award.payoutAt IS NULL');

		$amount = 0;
		/** @var Award $award */
		foreach ($qb->getQuery()->getResult() as $award) {
			$amount += $award->getAmount();
			$award->pay();
		}
		if ($amount > 0) {
			$this->moneyTransferer->send($wallet, $amount);
		}
		$this->entityManager->flush();
	}
}
