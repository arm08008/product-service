<?php

namespace App\Query;

use App\Repository\Product\ProductRepositoryInterface;

class GetProductsListQuery
{
    /**
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(
        protected ProductRepositoryInterface $productRepository,
    ) {
    }


    /**
     * @return array
     */
    public function __invoke(): array
    {
        return $this->productRepository->findAll();
    }
}