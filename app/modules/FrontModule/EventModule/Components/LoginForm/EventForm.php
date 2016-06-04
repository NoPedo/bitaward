<?php
namespace App\FrontModule\EventModule\Components\EventForm;

use App\Components\BaseControl;
use App\Core\Form\FormFactory;
use App\Model\Event\Event;
use App\Model\Payment\Wallet;
use Kdyby\Doctrine\EntityManager;
use Nette\Application\UI\Form;

/**
 * @author Jiri Travnicek
 *
 * @method onSuccess()
 */
class EventForm extends BaseControl
{

	/** @var callable[] */
	public $onSuccess = [];

	/** @var FormFactory */
	private $formFactory;

	/**
	 * @var EntityManager
	 */
	private $entityManager;


	/**
	 * LoginForm constructor.
	 * @param FormFactory $formFactory
	 * @param EntityManager $eventManager
	 * @internal param EventRepository $eventRepository
	 */
	public function __construct(FormFactory $formFactory, EntityManager $eventManager)
	{
		parent::__construct();
		$this->formFactory = $formFactory;
		$this->entityManager = $eventManager;
	}

	/**
	 * @return Form
	 * @throws \Nette\Security\AuthenticationException
	 */
	protected function createComponentForm()
	{
		$form = $this->formFactory->create();
		$form->addText('name', 'Name')
			->setRequired('Please enter event name');

		$form->addText('hashtag', 'hashtag')
			->setRequired('Please enter event hashtag');

		$form->addText('date', 'Date')
			->setRequired('Please set event date');

		$form->addText('wallet_address', 'BTC wallet address')
			->setRequired('Please enter your BTC wallet address');

		$form->addSubmit('ok', 'Save');
		$form->onSuccess[] = function (Form $form, $values) {
			try {
				$event = new Event($values->name);
				$event->setDate(new \DateTime($values->date));
				$event->setHashtag($values->hashtag);

				$wallet = new Wallet($values->wallet_address);
				$event->setWallet($wallet);

				$this->entityManager->persist($wallet);
				$this->entityManager->persist($event);
				$this->entityManager->flush();

				$this->onSuccess();
			} catch (\Exception $e) {
				$form->addError($e->getMessage());
			}
		};

		return $form;
	}


	public function render()
	{
		$this['form']->render();
	}

}
