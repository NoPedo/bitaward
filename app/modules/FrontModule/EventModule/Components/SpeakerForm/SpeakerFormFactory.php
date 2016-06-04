<?php
namespace App\FrontModule\EventModule\Components\SpeakerForm;

/**
 * @author Jiri Travnicek
 */
interface SpeakerFormFactory
{

	/**
	 * @return SpeakerForm
	 */
	public function create();

}
