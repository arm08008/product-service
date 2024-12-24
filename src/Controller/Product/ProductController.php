<?php

namespace App\Controller\Product;

use App\Command\CreateProductCommand;
use App\Controller\ApiController;
use App\Domain\Product\Response\ProductResponseBuilder;
use App\Domain\Product\Validation\PostProductValidator;
use App\Message\UpdateProductIncomeMessage;
use App\Query\GetProductByIdQuery;
use App\Query\GetProductsListQuery;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends ApiController
{
    public function __construct(
        private readonly ProductResponseBuilder $productResponseBuilder,
        private readonly MessageBusInterface $messageBus,
    )
    {
    }

    #[Route(path: "/products", name: "create_product", methods: [Request::METHOD_POST])]
    public function create(
        Request $request,
        PostProductValidator $validator,
        CreateProductCommand $createProductCommand,
    ): JsonResponse
    {
        $payload = $this->getRequestPayload($request);

        $violations = $validator->validate($payload);
        if ($violations->count() > 0) {
            $message = [];
            foreach ($violations as $violation) {
                $message[] = $violation->getPropertyPath() . $violation->getMessage();
            }

            throw new HttpException(
                Response::HTTP_BAD_REQUEST,
                json_encode($message),
            );
        }

        try {
            $product = ($createProductCommand) ($payload);
        }
        catch (\Exception $exception){
            throw new HttpException(
                Response::HTTP_INTERNAL_SERVER_ERROR,
                $exception->getMessage()
            );
        }

        return $this->json($this->productResponseBuilder->build($product));
    }

    #[Route(path:"/products", name: "list_products", methods: [Request::METHOD_GET])]
    public function list(
        GetProductsListQuery $getProductsListQuery
    ): JsonResponse
    {
        try {
           $products = ($getProductsListQuery)();
        }
        catch (\Exception $exception) {
            throw new HttpException(
                Response::HTTP_INTERNAL_SERVER_ERROR,
                $exception->getMessage()
            );
        }

        return $this->json($this->productResponseBuilder->buildAsArray($products));
    }

    #[Route(path: "/product/{id}", name: "update_product", methods: [Request::METHOD_PATCH])]
    public function update(
        string $id,
        Request $request,
        GetProductByIdQuery $getProductByIdQuery,
    ): JsonResponse
    {
        $payload = $this->getRequestPayload($request);

        try {
            $product = ($getProductByIdQuery) ($id);

            if ($product->getQuantity() < $payload['orderQty']) {
                throw new HttpException(Response::HTTP_BAD_REQUEST, 'Order quantity out of stock');
            }

            $this->messageBus->dispatch(new UpdateProductIncomeMessage(
                $product->getId(),
                $payload['orderQty']
            ));

            return $this->json($this->productResponseBuilder->build($product));
        } catch (EntityNotFoundException $exception) {
            throw new HttpException( Response::HTTP_NOT_FOUND, $exception->getMessage());
        }
    }
}
