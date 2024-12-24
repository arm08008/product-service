<?php

namespace App\MessageHandler;

use App\Message\UpdateProductIncomeMessage;
use App\Query\GetProductByIdQuery;
use App\Repository\Product\ProductRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class UpdateProductIncomeMessageHandler
{

    public function __construct(
        protected ProductRepositoryInterface $productRepository,
        protected GetProductByIdQuery $getProductByIdQuery
    )
    {
    }

    public function __invoke(UpdateProductIncomeMessage $message): void
    {
        $product = ($this->getProductByIdQuery)($message->getProductId());
        $newIncome = $product->getPrice() * $message->getQuantity();
        $income = $product->getIncome() + $newIncome;
        $product->setIncome($income);

        $this->productRepository->save($product, true);
    }
}