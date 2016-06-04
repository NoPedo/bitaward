<?php
namespace App\FrontModule\EventModule\Components\EventForm;

/**
 * @author Jiri Travnicek
 */
interface EventFormFactory
{

	/**
	 * @return EventForm
	 */
	public function create();

}
