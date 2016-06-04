<?php
namespace App\FrontModule\UserModule\Presenters;

use App\FrontModule\Presenters\BasePresenter;
use App\FrontModule\UserModule\Components\RegisterForm\RegisterForm;
use App\FrontModule\UserModule\Components\RegisterForm\RegisterFormFactory;
use App\Model\User\User;

class RegisterPresenter extends BasePresenter
{

	public function actionDefault()
	{

	}


	protected function createComponentRegisterForm(RegisterFormFactory $factory)
	{
		$control = $factory->create();
		$control->onSave[] = function (RegisterForm $control, User $user) {
			$this->flashMessage('You have been registered');
			$this->redirect(':Front:Dashboard:');
		};

		return $control;
	}
}
