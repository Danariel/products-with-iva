<?php

namespace App\Controller;

use App\Service\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends AbstractController
{
    private ProductService $productService;

    public function __construct(ProductService $productService) 
    {
        $this->productService = $productService;
    }

    /**
    * @Route("/api/products", name="api_products_get", methods={"GET"})
    */
    public function getProductsAction(Request $request): JsonResponse
    {
        $params = $request->query->all();
        $data = $this->productService->getProductsWithFilters($params);
        return $this->json($data);
    }

    /**
     * @Route("/api/products", name="api_products_create_one", methods={"POST"})
     */
    public function createProductAction(Request $request): JsonResponse
    {
        $authorizationHeader = $request->headers->get('Authorization');
        if ($authorizationHeader !== 'Bearer admintoken') {
            return $this->json(['error' => 'Unauthorized'], 401); // Return 401 Unauthorized
        }

        $rawData = $request->getContent();
        $params = json_decode($rawData, true);
        // dd($params);
        if (!empty($params)) {
            $data = $this->productService->createProduct($params);
            return $this->json($data, 201);
        }

        return $this->json(['error' => 'No data provided'], 400);
    }
}
