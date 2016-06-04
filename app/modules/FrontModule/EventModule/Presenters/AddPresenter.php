<?php
namespace App\FrontModule\EventModule\Presenters;

use App\FrontModule\EventModule\Components\EventForm\EventForm;
use App\FrontModule\EventModule\Components\EventForm\EventFormFactory;
use App\FrontModule\Presenters\BasePresenter;

/**
 * @author Jiri Travnicek
 * @package App\FrontModule\EventModule\Presenters
 */
class AddPresenter extends BasePresenter
{

	public function actionDefault()
	{
	}

	/**
	 * @param EventFormFactory $factory
	 * @return EventForm
	 * @throws \Nette\Application\AbortException
	 */
	protected function createComponentAddEventForm(EventFormFactory $factory)
	{
		$control = $factory->create();
		$control->onSuccess[] = function () {
			$this->flashMessage('Event has been added');
			$this->redirect(':Front:Event:List:');
		};

		return $control;
	}
}
