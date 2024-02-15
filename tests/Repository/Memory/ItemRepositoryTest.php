<?php

namespace App\Tests\Repository\Memory;

use App\Domain\ItemRepositoryInterface;
use App\Repository\Memory\ItemRepository;
use App\Tests\Repository\AbstractItemRepositoryTest;

class ItemRepositoryTest extends AbstractItemRepositoryTest
{
	protected function flush(): void {}

	protected function createItemRepository(): ItemRepositoryInterface
	{
		return new ItemRepository();
	}
}
