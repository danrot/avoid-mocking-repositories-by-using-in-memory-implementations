<?php

namespace App\Tests\Controller;

use App\Controller\ItemController;
use App\Domain\Item;
use App\Repository\Doctrine\ItemRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class ItemControllerTest extends TestCase
{
	private ItemRepository&MockObject $itemRepository;

	private ItemController $itemController;

	public function setUp(): void
	{
		$this->itemRepository = $this->createMock(ItemRepository::class);
		$this->itemController = new ItemController();
	}

	public function testList(): void
	{
		$this->itemRepository->method('loadAll')->willReturn([
			new Item('Title 1', 'Description 1'),
			new Item('Title 2', 'Description 2'),
		]);

		$response = $this->itemController->list($this->itemRepository);
		$responseContent = $response->getContent();
		$this->assertNotFalse($responseContent);
		$responseData = json_decode($responseContent);

		$this->assertIsArray($responseData);
		$this->assertCount(2, $responseData);
		$this->assertEquals('Title 1', $responseData[0]->title);
		$this->assertEquals('Description 1', $responseData[0]->description);
		$this->assertEquals('Title 2', $responseData[1]->title);
		$this->assertEquals('Description 2', $responseData[1]->description);
	}

	public function testAdd(): void
	{
		$this->itemRepository
			->expects($this->once())
			->method('add')
			->with($this->callback(function (Item $item) {
				return $item->getTitle() === 'Title' && $item->getDescription() === 'Description';
			}))
		;

		$request = $this->createStub(Request::class);
		$request->method('getContent')->willReturn(json_encode(['title' => 'Title', 'description' => 'Description']));

		$this->itemController->create($request, $this->itemRepository);
	}
}
