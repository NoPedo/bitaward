<?php

namespace App;

use Nette;
use Nette\Application\Routers\RouteList;
use Nette\Application\Routers\Route;


class RouterFactory
{

	/**
	 * @return Nette\Application\IRouter
	 */
	public static function createRouter()
	{
		$router = new RouteList;
		$router[] = $frontRouter = new RouteList('Front');
		$frontRouter[] = new Route('<presenter>/<action>[/<id>]', 'Homepage:default');
		
		return $router;
	}

}
