<?php

namespace App\Tests\Repository\Doctrine;

use App\Domain\ItemRepositoryInterface;
use App\Repository\Doctrine\ItemRepository;
use App\Tests\Repository\AbstractItemRepositoryTest;
use Doctrine\ORM\EntityManagerInterface;

class ItemRepositoryTest extends AbstractItemRepositoryTest
{
	public function setUp(): void
	{
		/** @var EntityManagerInterface */
		$entityManger = $this->getContainer()->get(EntityManagerInterface::class);
		$entityManger->getConnection()->beginTransaction();
	}

	public function tearDown(): void
	{
		/** @var EntityManagerInterface */
		$entityManger = $this->getContainer()->get(EntityManagerInterface::class);
		$entityManger->getConnection()->rollBack();
	}

	protected function flush(): void
	{
		$this->getContainer()->get(EntityManagerInterface::class)->flush();
	}

	protected function createItemRepository(): ItemRepositoryInterface
	{
		return new ItemRepository($this->getContainer()->get(EntityManagerInterface::class));
	}
}
