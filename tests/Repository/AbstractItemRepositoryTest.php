<?php

namespace App\Tests\Repository;

use App\Domain\Item;
use App\Domain\ItemRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class AbstractItemRepositoryTest extends KernelTestCase
{
	abstract protected function flush(): void;

	abstract protected function createItemRepository(): ItemRepositoryInterface;

	public function testAddSameObjectMultipleTimes(): void
	{
		$itemRepository = $this->createItemRepository();

		$item = new Item('Title', 'Description');

		$itemRepository->add($item);
		$itemRepository->add($item);

		$this->flush();

		$loadedItems = $itemRepository->loadAll();

		$this->assertCount(1, $loadedItems);
		$this->assertEquals($item, $loadedItems[0]);
	}

	public function testAddMultipleObjects(): void
	{
		$itemRepository = $this->createItemRepository();

		$item1 = new Item('Title 1', 'Description 1');
		$item2 = new Item('Title 2', 'Description 2');

		$itemRepository->add($item1);
		$itemRepository->add($item2);

		$this->flush();

		$loadedItems = $itemRepository->loadAll();

		$this->assertCount(2, $loadedItems);
		$this->assertEquals($item1, $loadedItems[0]);
		$this->assertEquals($item2, $loadedItems[1]);
	}

	public function testLoadFilteredByTitle(): void
	{
		$itemRepository = $this->createItemRepository();

		$item1 = new Item('Title 1', 'Description 1');
		$item2 = new Item('Title 2', 'Description 2');

		$itemRepository->add($item1);
		$itemRepository->add($item2);

		$this->flush();

		$loadedItems = $itemRepository->loadFilteredByTitle('Title 1');

		$this->assertCount(1, $loadedItems);
		$this->assertEquals($item1, $loadedItems[0]);
	}
}
