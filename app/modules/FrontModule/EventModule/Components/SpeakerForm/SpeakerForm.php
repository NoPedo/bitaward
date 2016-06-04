<?php
namespace App\FrontModule\EventModule\Components\SpeakerForm;

use App\Components\BaseControl;
use App\Core\Form\FormFactory;
use App\Model\Event\Event;
use App\Model\Event\Speaker;
use App\Model\Payment\Wallet;
use Kdyby\Doctrine\EntityManager;
use Nette\Application\UI\Form;

/**
 * @author Jiri Travnicek
 *
 * @method onSuccess(Speaker $speaker)
 */
class SpeakerForm extends BaseControl
{

	/** @var callable[] */
	public $onSuccess = [];

	/** @var FormFactory */
	private $formFactory;

	/** @var EntityManager */
	private $entityManager;

	/** @var Event */
	private $event;


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

	public function setEvent(Event $event)
	{
		$this->event = $event;
	}

	/**
	 * @return Form
	 * @throws \Nette\Security\AuthenticationException
	 */
	protected function createComponentForm()
	{
		$form = $this->formFactory->create();
		$form->addText('name', 'Name')
			->setRequired('Please enter speaker name');

		$form->addText('topic', 'Topic')
			->setRequired('Please enter topic');

		$form->addText('wallet_address', 'BTC wallet address');

		$form->addSubmit('ok', 'Save');
		$form->onSuccess[] = function (Form $form, $values) {
			try {
				$speaker = new Speaker;
				$speaker->name = $values->name;
				$speaker->talkTitle = $values->topic;
				$speaker->event = $this->event;

				if ($values->wallet_address !== '') {
					$wallet = new Wallet($values->wallet_address);
					$this->entityManager->persist($wallet);
					$speaker->setWallet($wallet);
				}

				$this->entityManager->persist($speaker);
				$this->entityManager->flush();
			} catch (\Exception $e) {
				$form->addError($e->getMessage());
			}
			$this->onSuccess($speaker);
		};

		return $form;
	}


	public function render()
	{
		$this['form']->render();
	}

}
