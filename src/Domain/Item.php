<?php

namespace App\Domain;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\Uid\Uuid;

#[Entity]
class Item
{
	#[Id]
	#[Column(type: 'uuid')]
	private Uuid $id;

	public function __construct(
		#[Column]
		private string $title,
		#[Column]
		private string $description,
	) {
		$this->id = Uuid::v4();
	}

	public function getId(): Uuid
	{
		return $this->id;
	}

	public function getTitle(): string
	{
		return $this->title;
	}

	public function getDescription(): string
	{
		return $this->description;
	}
}
