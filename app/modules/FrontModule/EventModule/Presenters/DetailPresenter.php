<?php
namespace App\FrontModule\EventModule\Presenters;

use App\FrontModule\Presenters\BasePresenter;
use App\Model\Event\Event;
use App\Model\Event\EventRepository;
use Kdyby\Doctrine\EntityManager;

/**
 * @author Jiri Travnicek
 * @package App\FrontModule\EventModule\Presenters
 */
class DetailPresenter extends BasePresenter
{
	/**
	 * @var EventRepository
	 */
	private $eventRepository;

	/**w
	 * @var Event
	 */
	private $event;
	/**
	 * @var EntityManager
	 */
	private $entityManager;

	/**
	 * EventListPresenter constructor.
	 * @param EventRepository $eventRepository
	 * @param EntityManager $eventManager
	 */
	public function __construct(EventRepository $eventRepository, EntityManager $eventManager)
	{
		$this->eventRepository = $eventRepository;
		$this->entityManager = $eventManager;
	}

	public function actionDefault($id)
	{
		$this->event = $this->eventRepository->findById($id);
	}

	public function renderDefault()
	{
		$this->template->event = $this->event;
	}
}
