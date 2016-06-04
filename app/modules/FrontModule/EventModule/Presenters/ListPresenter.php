<?php
namespace App\FrontModule\EventModule\Presenters;

use App\FrontModule\Presenters\BasePresenter;
use App\Model\Event\Event;
use App\Model\Event\EventRepository;
use Kdyby\Doctrine\EntityManager;
use Nette\Application\ForbiddenRequestException;

/**
 * @author Jiri Travnicek
 * @package App\FrontModule\EventModule\Presenters
 */
class ListPresenter extends BasePresenter
{
	/**
	 * @var EventRepository
	 */
	private $eventRepository;

	/**
	 * @var Event[]
	 */
	private $events;
	/**
	 * @var EntityManager
	 */
	private $entityManager;

	/**
	 * EventListPresenter constructor.
	 * @param EventRepository $eventRepository
	 * @param EntityManager $entityManager
	 */
	public function __construct(EventRepository $eventRepository, EntityManager $entityManager)
	{
		$this->eventRepository = $eventRepository;
		$this->entityManager = $entityManager;
	}

	/**
	 * @param int $id of Event
	 * @throws ForbiddenRequestException
	 * @secured
	 */
	public function handleRemove($id)
	{
		if (!$this->getUser()->isLoggedIn()) {
			throw new ForbiddenRequestException;
		}

		$event = $this->eventRepository->findById($id);
		$this->entityManager->remove($event);
		try {
			$this->entityManager->flush();
			$this->flashMessage('Event ' . $event->name . ' remove successfully', 'success');
		} catch (\Exception $e) {
			$this->flashMessage('Failed to remove event: ' . $e->getMessage(), 'error');
		}
		$this->redirect('default');
	}

	public function actionDefault()
	{
		$this->events = $this->eventRepository->findAll();
	}

	public function renderDefault()
	{
		$this->template->events = $this->events;
	}
}
