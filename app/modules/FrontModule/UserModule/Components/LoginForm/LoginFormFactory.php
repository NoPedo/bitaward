<?php
namespace App\FrontModule\UserModule\Components\LoginForm;

/**
 * @author Jiri Travnicek
 */
interface LoginFormFactory
{

	/**
	 * @return LoginForm
	 */
	public function create();

}
