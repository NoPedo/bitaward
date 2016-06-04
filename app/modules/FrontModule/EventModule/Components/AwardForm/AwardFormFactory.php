<?php
namespace App\FrontModule\EventModule\Components\AwardForm;

use App\Model\Event\Event;

/**
 * @author David Matejka
 */
interface AwardFormFactory
{

	/**
	 * @param Event
	 * @return AwardForm
	 */
	public function create(Event $event);

}
