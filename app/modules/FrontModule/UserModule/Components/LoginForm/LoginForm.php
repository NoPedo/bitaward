<?php
namespace App\FrontModule\UserModule\Components\LoginForm;

use App\Components\BaseControl;
use App\Core\Form\FormFactory;
use Kdyby\Doctrine\EntityManager;
use Nette\Application\UI\Form;
use Nette\Security\AuthenticationException;
use Nette\Security\User;

/**
 * @author Jiri Travnicek
 *
 * @method onLogin()
 */
class LoginForm extends BaseControl
{

	/** @var callable[] */
	public $onLogin = [];

	/** @var FormFactory */
	private $formFactory;

	/** @var EntityManager */
	private $entityManager;

	/** @var User */
	private $user;


	/**
	 * LoginForm constructor.
	 * @param FormFactory $formFactory
	 * @param EntityManager $entityManager
	 * @param User $user
	 * @internal param UserRepository $userRepository
	 */
	public function __construct(FormFactory $formFactory, EntityManager $entityManager, User $user)
	{
		parent::__construct();
		$this->formFactory = $formFactory;
		$this->entityManager = $entityManager;
		$this->user = $user;
	}

	/**
	 * @return Form
	 * @throws \Nette\Security\AuthenticationException
	 */
	protected function createComponentForm()
	{
		$form = $this->formFactory->create();
		$form->addText('email', 'E-mail')
			->setRequired('Please enter an email')
			->addRule($form::EMAIL, 'E-mail is not valid');

		$form->addPassword('password', 'Password')
			->setRequired('Please enter a password');
		$form->addSubmit('ok', 'Register');
		$form->onSuccess[] = function (Form $form, $values) {
			try {
				$this->user->login($values->email, $values->password);
				$this->onLogin();
			} catch (AuthenticationException $e) {
				$form->addError($e->getMessage());
			}
		};

		return $form;
	}


	public function render()
	{
		$this['form']->render();
	}

}
