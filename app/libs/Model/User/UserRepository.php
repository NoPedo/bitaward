<?php
namespace App\Model\User;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\EntityManager;
use Kdyby\Doctrine\EntityRepository;


class UserRepository
{
	/**
	 * @var EntityManager
	 */
	private $entityManager;

	/**
	 * UserRepository constructor.
	 * @param EntityManager $entityManager
	 */
	public function __construct(EntityManager $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	/**
	 * @param int $id
	 * @return User|null
	 */
	public function getById($id)
	{
		$repository = $this->getRepository();
		return $repository->findOneBy(['id' => $id]);
	}

	/**
	 * @param string $email
	 * @return User|null
	 */
	public function findByEmail($email)
	{
		$repository = $this->getRepository();
		return $repository->findOneBy(['email' => $email]);
	}

	/**
	 * @return EntityRepository
	 */
	public function getRepository()
	{
		return $this->entityManager->getRepository(User::class);
	}
}
