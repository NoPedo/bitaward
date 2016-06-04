<?php
namespace App\FrontModule\EventModule\Presenters;

use App\FrontModule\EventModule\Components\AwardForm\AwardFormFactory;
use App\FrontModule\Presenters\BasePresenter;
use App\Model\Event\Event;
use App\Model\Payment\Checkout;
use Doctrine\ORM\EntityManager;

class DetailPresenter extends BasePresenter
{
	/** @var EntityManager */
	private $entityManager;

	/** @var Event */
	private $event;


	public function __construct(EntityManager $entityManager)
	{
		$this->entityManager = $entityManager;
	}


	public function actionDefault($id)
	{
		$this->event = $this->entityManager->find(Event::class, $id);
	}


	public function renderDefault()
	{
		$this->template->event = $this->event;
	}


	protected function createComponentAwardForm(AwardFormFactory $factory)
	{
		$control = $factory->create($this->event);
		$control->onCheckout[] = function ($control, Checkout $checkout) {
			$this->redirectUrl('https://sandbox.coinbase.com/checkouts/' . $checkout->getEmbedCode());
		};

		return $control;
	}

}
