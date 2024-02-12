<?php

namespace App\Controller;

use App\Domain\Item;
use App\Repository\Doctrine\ItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ItemController extends AbstractController
{
	#[Route('/items', methods: ['GET'])]
	public function list(ItemRepository $itemRepository): JsonResponse
	{
		return $this->json($itemRepository->loadAll());
	}

	#[Route('/items', methods: ['POST'])]
	public function create(Request $request, ItemRepository $itemRepository): JsonResponse
	{
		/** @var \stdClass */
		$data = json_decode($request->getContent());
		$item = new Item($data->title, $data->description);

		$itemRepository->add($item);

		return $this->json($item);
	}
}
