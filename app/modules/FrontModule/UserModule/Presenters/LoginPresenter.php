<?php
namespace App\FrontModule\UserModule\Presenters;

use App\FrontModule\Presenters\BasePresenter;
use App\FrontModule\UserModule\Components\LoginForm\LoginFormFactory;

/**
 * @author Jiri Travnicek
 *
 * @package App\FrontModule\UserModule\Presenters
 */
class LoginPresenter extends BasePresenter
{

	public function actionDefault()
	{

	}

	/**
	 * @param LoginFormFactory $factory
	 * @return \App\FrontModule\UserModule\Components\LoginForm\LoginForm
	 * @throws \Nette\Application\AbortException
	 */
	protected function createComponentLoginForm(LoginFormFactory $factory)
	{
		$control = $factory->create();
		$control->onLogin[] = function () {
			$this->flashMessage('You have been logged');
			$this->redirect(':Front:Dashboard:');
		};

		return $control;
	}
}
