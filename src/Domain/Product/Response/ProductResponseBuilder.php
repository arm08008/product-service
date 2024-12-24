<?php

namespace App\Domain\Product\Response;

use App\Domain\Product\ProductInterface;

class ProductResponseBuilder
{
    public function build(ProductInterface $product): array
    {
        return [
            'id' => $product->getId(),
            'name' => $product->getName(),
            'qty' => $product->getQuantity(),
            'price' => $product->getPrice(),
            'income' => $product->getIncome(),
        ];
    }

    public function buildAsArray(array $products): array
    {
        $data = [];

        foreach ($products as $product) {
            $data[] = $this->build($product);
        }

        return $data;
    }
}