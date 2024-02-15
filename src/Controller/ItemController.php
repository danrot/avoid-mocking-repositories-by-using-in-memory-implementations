<?php

namespace App\Controller;

use App\Domain\Item;
use App\Domain\ItemRepositoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

#[AsController]
class ItemController
{
	#[Route('/items', methods: ['GET'])]
	public function list(Request $request, ItemRepositoryInterface $itemRepository): JsonResponse
	{
		$titleFilter = $request->query->getString('titleFilter');
		$items = $titleFilter ? $itemRepository->loadFilteredByTitle($titleFilter) : $itemRepository->loadAll();
		return new JsonResponse(array_map($this->transformItemToArray(...), $items));
	}

	#[Route('/items', methods: ['POST'])]
	public function create(Request $request, ItemRepositoryInterface $itemRepository): JsonResponse
	{
		/** @var \stdClass */
		$data = json_decode($request->getContent());
		$item = new Item($data->title, $data->description);

		$itemRepository->add($item);

		return new JsonResponse($this->transformItemToArray($item));
	}

	/**
	 * @return array{id: Uuid, title: string, description: string}
	 */
	private function transformItemToArray(Item $item): array
	{
		return ['id' => $item->getId(), 'title' => $item->getTitle(), 'description' => $item->getDescription()];
	}
}
