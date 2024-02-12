<?php

namespace App\Repository\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class FlushEventSubscriber implements EventSubscriberInterface
{
	public function __construct(private EntityManagerInterface $entityManager) {}

	public static function getSubscribedEvents(): array
	{
		return [
			KernelEvents::RESPONSE => ['flush'],
		];
	}

	public function flush(): void
	{
		$this->entityManager->flush();
	}
}
