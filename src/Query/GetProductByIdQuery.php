<?php

namespace App\Query;

use App\Domain\Product\ProductInterface;
use App\Repository\Product\ProductRepositoryInterface;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class GetProductByIdQuery
{
    /**
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(
        protected ProductRepositoryInterface $productRepository,
    ) {
    }


    /**
     * @param string $productId
     * @return ProductInterface|null
     */
    public function __invoke(
        string $productId,
    ): ProductInterface|null {
       $product = $this->productRepository->find($productId);
       if (null === $product) {
           throw new EntityNotFoundException('Entity not found. ID: ' . $productId, Response::HTTP_NOT_FOUND);
       }
       return $product;
    }
}