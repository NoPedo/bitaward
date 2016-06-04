<?php
namespace App\FrontModule\UserModule\Components\RegisterForm;

/**
 * @author David Matejka
 */
interface RegisterFormFactory
{

	/**
	 * @return RegisterForm
	 */
	public function create();

}
