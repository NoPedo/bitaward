<?php
namespace App\FrontModule\UserModule\Components\RegisterForm;

use App\Components\BaseControl;
use App\Core\Form\FormFactory;
use App\Model\User\User;
use Kdyby\Doctrine\EntityManager;
use Nette\Application\UI\Form;

/**
 * @author David Matejka
 *
 * @method onSave(RegisterForm $control, User $user)
 */
class RegisterForm extends BaseControl
{

	/** @var callable[] */
	public $onSave = [];

	/** @var FormFactory */
	private $formFactory;

	/** @var EntityManager */
	private $entityManager;


	public function __construct(FormFactory $formFactory, EntityManager $entityManager)
	{
		$this->formFactory = $formFactory;
		$this->entityManager = $entityManager;
	}


	protected function createComponentForm()
	{
		$form = $this->formFactory->create();
		$form->addText('email', 'E-mail')
			->setRequired('Please enter an email')
			->addRule($form::EMAIL, 'E-mail is not valid');

		$form->addText('name', 'Name')
			->setRequired('Please enter your name');

		$form->addPassword('password', 'Password')
			->setRequired('Please enter a password');
		$form->addSubmit('ok', 'Register');
		$form->onSuccess[] = function (Form $form, $values) {
			$user = new User($values->name, $values->email, $values->password);
			$this->entityManager->persist($user);
			$this->entityManager->flush();
			$this->onSave($this, $user);
		};

		return $form;
	}


	public function render()
	{
		$this['form']->render();
	}

}
