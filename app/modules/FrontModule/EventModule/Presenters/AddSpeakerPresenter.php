<?php
namespace App\FrontModule\EventModule\Presenters;

use App\FrontModule\EventModule\Components\SpeakerForm\SpeakerForm;
use App\FrontModule\EventModule\Components\SpeakerForm\SpeakerFormFactory;
use App\FrontModule\Presenters\BasePresenter;
use App\Model\Event\Event;
use App\Model\Event\EventRepository;

/**
 * @author Jiri Travnicek
 * @package App\FrontModule\EventModule\Presenters
 */
class AddSpeakerPresenter extends BasePresenter
{
	/** @var EventRepository */
	private $eventRepository;

	/** @var Event */
	private $event;


	/**
	 * AddSpeakerPresenter constructor.
	 * @param EventRepository $eventRepository
	 */
	public function __construct(EventRepository $eventRepository)
	{
		$this->eventRepository = $eventRepository;
	}

	public function actionDefault($id)
	{
		$this->event = $this->eventRepository->findById($id);
	}

	/**
	 * @param SpeakerFormFactory $factory
	 * @return SpeakerForm
	 * @throws \Nette\Application\AbortException
	 */
	protected function createComponentAddSpeakerForm(SpeakerFormFactory $factory)
	{
		$control = $factory->create();
		$control->setEvent($this->event);
		$control->onSuccess[] = function ($speaker) {
			$this->flashMessage('Speaker has been added');
			$this->redirect(':Front:Event:Detail:', $speaker->event->id);
		};

		return $control;
	}
}
