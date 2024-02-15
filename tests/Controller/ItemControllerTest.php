<?php

namespace App\Tests\Controller;

use App\Domain\Item;
use App\Domain\ItemRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ItemControllerTest extends WebTestCase
{
	public function testList(): void
	{
		$client = static::createClient();

		/** @var ItemRepositoryInterface */
		$itemRepository = $this->getContainer()->get(ItemRepositoryInterface::class);
		$itemRepository->add(new Item('Title 1', 'Description 1'));
		$itemRepository->add(new Item('Title 2', 'Description 2'));

		$client->request('GET', '/items');
		$responseContent = $client->getResponse()->getContent();
		$this->assertNotFalse($responseContent);
		$responseData = json_decode($responseContent);

		$this->assertIsArray($responseData);
		$this->assertCount(2, $responseData);
		$this->assertEquals('Title 1', $responseData[0]->title);
		$this->assertEquals('Description 1', $responseData[0]->description);
		$this->assertEquals('Title 2', $responseData[1]->title);
		$this->assertEquals('Description 2', $responseData[1]->description);
	}

	public function testListFilter(): void
	{
		$client = static::createClient();

		/** @var ItemRepositoryInterface */
		$itemRepository = $this->getContainer()->get(ItemRepositoryInterface::class);
		$itemRepository->add(new Item('Title 1', 'Description 1'));
		$itemRepository->add(new Item('Title 2', 'Description 2'));

		$client->request('GET', '/items?titleFilter=Title 2');
		$responseContent = $client->getResponse()->getContent();
		$this->assertNotFalse($responseContent);
		$responseData = json_decode($responseContent);

		$this->assertIsArray($responseData);
		$this->assertCount(1, $responseData);
		$this->assertEquals('Title 2', $responseData[0]->title);
		$this->assertEquals('Description 2', $responseData[0]->description);
	}

	public function testAdd(): void
	{
		$client = static::createClient();

		/** @var ItemRepositoryInterface */
		$itemRepository = $this->getContainer()->get(ItemRepositoryInterface::class);

		$client->jsonRequest('POST', '/items', ['title' => 'Title', 'description' => 'Description']);

		$items = $itemRepository->loadAll();
		$this->assertCount(1, $items);
		$this->assertEquals('Title', $items[0]->getTitle());
		$this->assertEquals('Description', $items[0]->getDescription());
	}
}
