<?php

namespace App\Command;

use App\Domain\Product\ProductInterface;
use App\Entity\Product;
use App\Repository\Product\ProductRepositoryInterface;

class CreateProductCommand
{
    public function __construct(private readonly ProductRepositoryInterface $productRepository)
    {
    }

    /**
     * @param array<string,mixed> $payload
     * @return ProductInterface
     */
    public function __invoke(array $payload): ProductInterface
    {
        $product = new Product();
        $product->setName($payload['name']);
        $product->setPrice($payload['price']);
        $product->setQuantity($payload['quantity']);

        $this->productRepository->save($product, true);
        return  $product;
    }
}