<?php

namespace App\Service;

use App\Entity\Product;
use App\Repository\ProductRepository;

class ProductService 
{

  private $productRepository;

  public function __construct(ProductRepository $productRepository) 
  {
    $this->productRepository = $productRepository;  
  }

  public function getProductsWithFilters(?array $params): array
  {
    return $this->productRepository->filters();  
  }

  public function createProduct(array $params): Product
  {
    return $this->productRepository->createProduct($params);
  }

}
