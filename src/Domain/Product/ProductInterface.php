<?php

namespace App\Domain\Product;

interface ProductInterface
{
    public function getId(): ?string;

    public function getName(): ?string;

    public function setName(string $name): static;

    public function getPrice(): ?string;

    public function setPrice(string $price): static;

    public function getQuantity(): ?int;

    public function setQuantity(int $quantity): static;

    public function getIncome(): ?int;

    public function setIncome(int $income): static;
}