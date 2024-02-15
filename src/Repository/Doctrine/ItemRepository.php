<?php

namespace App\Repository\Doctrine;

use App\Domain\Item;
use App\Domain\ItemRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class ItemRepository implements ItemRepositoryInterface
{
	public function __construct(private EntityManagerInterface $entityManager) {}

	public function add(Item $item): void
	{
		$this->entityManager->persist($item);
	}

	/**
	 * @return Item[]
	 */
	public function loadAll(): array
	{
		/** @var Item[] */
		return $this->entityManager
			->createQueryBuilder()
			->from(Item::class, 'i')
			->select('i')
			->getQuery()
			->getResult()
		;
	}

	public function loadFilteredByTitle(string $titleFilter): array
	{
		/** @var Item[] */
		return $this->entityManager
			->createQueryBuilder()
			->from(Item::class, 'i')
			->select('i')
			->where('i.title LIKE :titleFilter')
			->setParameter('titleFilter', $titleFilter . '%')
			->getQuery()
			->getResult()
		;
	}
}
