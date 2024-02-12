<?php

namespace App\Controller;

use App\Domain\Item;
use App\Repository\Doctrine\ItemRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

#[AsController]
class ItemController
{
	#[Route('/items', methods: ['GET'])]
	public function list(ItemRepository $itemRepository): JsonResponse
	{
		return new JsonResponse(array_map($this->transformItemToArray(...), $itemRepository->loadAll()));
	}

	#[Route('/items', methods: ['POST'])]
	public function create(Request $request, ItemRepository $itemRepository): JsonResponse
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
