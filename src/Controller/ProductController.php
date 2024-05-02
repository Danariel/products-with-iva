<?php

namespace App\Controller;

use App\Service\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends AbstractController
{
    public function __construct(ProductService $productService) 
    {
    }

    public function getProductsAction(Request $request): JsonResponse
    {
        $params = $request->query->all();
        $data = $this->productService->getProductsWithFilters($params);
        return $this->json($data);
    }

    public function createProductAction(Request $request): JsonResponse
    {
        $params = $request->request->all();
        $data = $this->productService->createProduct($params);
        return $this->json($data);
    }
}
