<?php
namespace App\Model\User;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\Attributes\Identifier;
use Nette\Object;
use Nette\Security\Passwords;


/**
 * @ORM\Entity
 */
class User extends Object
{
	use Identifier;


	/**
	 * @var string
	 * @ORM\Column(type="string")
	 */
	protected $name;

	/**
	 * @var string
	 * @ORM\Column(type="string")
	 */
	protected $email;

	/**
	 * @var string
	 * @ORM\Column(type="string")
	 */
	protected $password;


	public function __construct($name, $email, $password)
	{
		$this->email = $email;
		$this->name = $name;
		$this->changePassword($password);
	}


	public function changePassword($password)
	{
		$this->password = Passwords::hash($password);
	}


	public function verifyPassword($password)
	{
		return Passwords::verify($password, $this->password);
	}

}
