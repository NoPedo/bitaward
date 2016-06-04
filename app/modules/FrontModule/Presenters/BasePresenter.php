<?php
namespace App\FrontModule\Presenters;

use Kdyby\Autowired\AutowireComponentFactories;
use Nette\Application\UI\Presenter;

abstract class BasePresenter extends Presenter
{

	use AutowireComponentFactories;


	public function formatLayoutTemplateFiles()
	{
		return [__DIR__ . '/../templates/@layout.latte'];
	}


}
