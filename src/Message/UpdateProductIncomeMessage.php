<?php

namespace App\Message;

final class UpdateProductIncomeMessage
{
    public function __construct(
        protected string $productId,
        protected int $quantity
    )
    {
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}