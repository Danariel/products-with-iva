<?php

namespace App\Service;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Repository\TaxRepository;

class ProductService 
{

  private $productRepository;
  private $taxRepository;

  public function __construct(ProductRepository $productRepository, TaxRepository $taxRepository) 
  {
    $this->productRepository = $productRepository;
    $this->taxRepository = $taxRepository;
  }

  public function getProductsWithFilters(?array $params = []): ?array
  {
    return $this->productRepository->filters($params);  
  }

  public function createProduct(array $params): Product
  {
    if (array_key_exists("tax_id", $params)) {
      $params["tax_id"] = $this->taxRepository->find($params["tax_id"]);
    } else {
      throw new \Exception("No Valid Tax provided");
    }
    return $this->productRepository->createProduct($params);
  }

}
