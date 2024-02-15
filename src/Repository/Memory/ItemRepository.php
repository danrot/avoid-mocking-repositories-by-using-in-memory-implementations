<?php

namespace App\Repository\Memory;

use App\Domain\Item;
use App\Domain\ItemRepositoryInterface;

class ItemRepository implements ItemRepositoryInterface
{
	/**
	 * @var Item[]
	 */
	private array $items = [];

	public function add(Item $item): void
	{
		if (in_array($item, $this->items)) {
			return;
		}

		array_push($this->items, $item);
	}

	public function loadAll(): array
	{
		return $this->items;
	}

	public function loadFilteredByTitle(string $titleFilter): array
	{
		return array_values(array_filter($this->items, function (Item $item) use ($titleFilter) {
			return str_starts_with($item->getTitle(), $titleFilter);
		}));
	}
}
