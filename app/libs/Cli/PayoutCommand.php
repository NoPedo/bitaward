<?php
namespace App\Cli;

use App\Model\Payment\PayoutSender;
use App\Model\Payment\Wallet;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PayoutCommand extends Command
{
	
	/** @var EntityManager @inject */
	public $entityManager;
	
	/** @var PayoutSender @inject */
	public $payoutSender;

	protected function configure()
	{
		$this->setName('app:payout');
		$this->addArgument('wallet');
	}


	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$wallet = $this->entityManager->find(Wallet::class, $input->getArgument('wallet'));
		if (!$wallet) {
			throw new \RuntimeException;
		}
		$this->payoutSender->send($wallet);
		
		
	}

}
