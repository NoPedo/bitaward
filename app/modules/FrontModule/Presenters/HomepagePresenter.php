<?php
namespace App\FrontModule\Presenters;

use App\FrontModule\Components\FindEventForm\FindEventForm;
use App\FrontModule\Components\FindEventForm\FindEventFormFactory;

class HomepagePresenter extends BasePresenter
{

	/**
	 * @param FindEventFormFactory $factory
	 * @return FindEventForm
	 */
	public function createComponentFindEventForm(FindEventFormFactory $factory)
	{
		$control = $factory->create();
		$control->onSuccess[] = function ($event) {
			if ($event === null) {
				$this->flashMessage('This event does not exists', 'danger');
				$this->redirect('this');
			}
			$this->redirect(':Front:Event:Detail:', $event->getId());
		};

		return $control;
	}

}
