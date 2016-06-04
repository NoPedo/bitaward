<?php
namespace App\Core\Form;

use Nette\Application\UI\Form;

/**
 * @author David Matejka
 */
interface FormFactory
{

	/**
	 * @return Form
	 */
	public function create();

}
