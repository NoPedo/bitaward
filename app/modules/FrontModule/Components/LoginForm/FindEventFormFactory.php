<?php
namespace App\FrontModule\Components\FindEventForm;

/**
 * @author Jiri Travnicek
 */
interface FindEventFormFactory
{

	/**
	 * @return FindEventForm
	 */
	public function create();

}
