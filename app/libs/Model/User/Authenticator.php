<?php

namespace App\Model\User;

use Nette\Security\AuthenticationException;
use Nette\Security\IAuthenticator;
use Nette\Security\IIdentity;

/**
 * @author Jiri Travnicek
 *
 * @package App\Model\User
 */
class Authenticator implements IAuthenticator
{
	/**
	 * @var UserRepository
	 */
	private $repository;

	/**
	 * Authenticator constructor.
	 * @param UserRepository $repository
	 */
	public function __construct(UserRepository $repository)
	{
		$this->repository = $repository;
	}


	/**
	 * Performs an authentication against e.g. database.
	 * and returns IIdentity on success or throws AuthenticationException
	 * @param array $credentials
	 * @return IIdentity
	 * @throws AuthenticationException
	 */
	public function authenticate(array $credentials)
	{
		list ($email, $password) = $credentials;
		$user = $this->repository->findByEmail($email);

		if ($user === null) {
			throw new AuthenticationException('User not found');
		}

		if ($user->verifyPassword($password)) {
			return $user;
		} else {
			throw new AuthenticationException('Invalid password.');
		}
	}
}
