<?php
namespace App\FrontModule\Presenters;

use Kdyby\Autowired\AutowireComponentFactories;
use Nette\Application\UI\Presenter;
use Nextras\Application\UI\SecuredLinksPresenterTrait;

abstract class BasePresenter extends Presenter
{

	use AutowireComponentFactories;
	use SecuredLinksPresenterTrait;

	public function formatLayoutTemplateFiles()
	{
		return [__DIR__ . '/../templates/@layout.latte'];
	}

	public function handleLogout()
	{
		$this->getUser()->logout(true);
		$this->flashMessage('Logged out successfully', 'success');
		$this->redirect('this');
	}


}
