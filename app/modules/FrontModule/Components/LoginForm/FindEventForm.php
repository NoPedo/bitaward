<?php
namespace App\FrontModule\Components\FindEventForm;

use App\Components\BaseControl;
use App\Core\Form\FormFactory;
use App\Model\Event\Event;
use App\Model\Event\EventRepository;
use Kdyby\Doctrine\EntityManager;
use Nette\Application\UI\Form;
use Nette\Security\AuthenticationException;

/**
 * @author Jiri Travnicek
 *
 * @method onSuccess(Event $event)
 */
class FindEventForm extends BaseControl
{

	/** @var callable[] */
	public $onSuccess= [];

	/** @var FormFactory */
	private $formFactory;

	/** @var EventRepository */
	private $eventRepository;


	/**
	 * LoginForm constructor.
	 * @param FormFactory $formFactory
	 * @param EventRepository $eventRepository
	 * @internal param EventRepository $eventRepository
	 */
	public function __construct(FormFactory $formFactory, EventRepository $eventRepository)
	{
		parent::__construct();
		$this->formFactory = $formFactory;
		$this->eventRepository = $eventRepository;
	}

	/**
	 * @return Form
	 * @throws \Nette\Security\AuthenticationException
	 */
	protected function createComponentForm()
	{
		$form = $this->formFactory->create();

		$form->addText('hashtag', '#')
			->setRequired('Please enter event hashtag');

		$form->addSubmit('go', 'Go');
		$form->onSuccess[] = function (Form $form, $values) {
			$event = $this->eventRepository->findByHashtag($values->hashtag);
			$this->onSuccess($event);
		};

		return $form;
	}


	public function render()
	{
		$this['form']->render();
	}

}
