<?php

namespace App\Domain\Product\Validation;

use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

class PostProductValidator
{
    public function __construct(private readonly ValidatorInterface $validator)
    {
    }

    public function validate(mixed $data): ConstraintViolationListInterface
    {
        $constraints = new Assert\Collection([
            'name'   => [
                new Assert\NotBlank(),
                new Assert\NotNull(),
                new Assert\Type(['string']),
                new Assert\Length(['min' => 3, 'max' => 255]),
            ],
            'price' => [
                new Assert\NotBlank(),
                new Assert\NotNull(),
                new Assert\Type(['float', 'integer']),
                new Assert\Positive()
            ],
            'quantity' => [
                new Assert\NotBlank(),
                new Assert\NotNull(),
                new Assert\Type(['integer']),
                new Assert\Positive()
            ]
        ]);

        return $this->validator->validate($data, $constraints);
    }
}