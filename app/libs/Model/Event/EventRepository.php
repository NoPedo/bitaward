<?php

namespace App\Model\Event;

use Kdyby\Doctrine\EntityManager;
use Kdyby\Doctrine\EntityRepository;

/**
 * @author Jiri Travnicek
 *
 * @package App\Model\Event
 */
class EventRepository
{
	/**
	 * @var EntityManager
	 */
	private $entityManager;

	/**
	 * EventRepository constructor.
	 * @param EntityManager $entityManager
	 */
	public function __construct(EntityManager $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	/**
	 * @return Event[]
	 */
	public function findAll()
	{
		$repository = $this->getRepository();
		return $repository->findAll();
	}

	/**
	 * @param $id
	 * @return Event[]|null
	 */
	public function findById($id)
	{
		$repository = $this->getRepository();
		return $repository->findOneBy(['id' => $id]);
	}

	/**
	 * @return EntityRepository
	 */
	public function getRepository()
	{
		return $this->entityManager->getRepository(Event::class);
	}
}
