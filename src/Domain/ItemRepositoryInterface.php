<?php

namespace App\Domain;

use App\Domain\Item;

interface ItemRepositoryInterface
{
	public function add(Item $item): void;

	/**
	 * @return Item[]
	 */
	public function loadAll(): array;

	/**
	 * @return Item[]
	 */
	public function loadFilteredByTitle(string $titleFilter): array;
}
