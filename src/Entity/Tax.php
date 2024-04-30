<?php

namespace App\Entity;

use App\Repository\TaxRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaxRepository::class)]
class Tax
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'integer')]
    private int $value;

    public function getId(): ?int
    {
        return $this->id;
    }

	public function getValue() : int {
		return $this->value;
	}

	public function setValue(int $value): static {
		$this->value = $value;

        return $this;
	}
}