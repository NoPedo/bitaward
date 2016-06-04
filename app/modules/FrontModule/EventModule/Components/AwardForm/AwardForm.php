<?php
namespace App\FrontModule\EventModule\Components\AwardForm;

use App\Components\BaseControl;
use App\Core\Form\FormFactory;
use App\Model\Event\Event;
use App\Model\Payment\AwardCheckout;
use Nette\Application\UI\Form;

/**
 * @author David Matejka
 */
class AwardForm extends BaseControl
{
	public $onCheckout = [];

	/** @var Event */
	private $event;

	/** @var FormFactory */
	private $formFactory;

	/** @var AwardCheckout */
	private $awardCreator;


	public function __construct(Event $event, FormFactory $formFactory, AwardCheckout $awardCreator)
	{

		$this->event = $event;
		$this->formFactory = $formFactory;
		$this->awardCreator = $awardCreator;
	}


	protected function createComponentForm()
	{
		$form = $this->formFactory->create();
		$form->addText('organizerAmount', 'Organizer award')
			->setDefaultValue(0);
		$speakers = $form->addContainer('speakers');
		foreach ($this->event->getSpeakers() as $speaker) {
			$speakers->addText($speaker->getId(), $speaker->getName())
				->setDefaultValue(0);
		}
		$form->addSubmit('pay', 'Pay');
		$form->onSuccess[] = function (Form $form, $values) {
			$checkout = $this->awardCreator->createCheckout($this->event, $values->organizerAmount, (array) $values->speakers);
			$this->onCheckout($this, $checkout);
		};


		return $form;
	}


	public function render()
	{
		$this->template->event = $this->event;
		$this->template->render(__DIR__ . '/awardForm.latte');
	}

}
