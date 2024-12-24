<?php

namespace App\Repository\Product;

use App\Domain\Product\ProductInterface;

interface ProductRepositoryInterface
{
    public function save(ProductInterface $entity, bool $flush = false): void;

    public function remove(ProductInterface $entity, bool $flush = false): void;
}