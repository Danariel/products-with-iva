<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    const ACCEPTED_FILTERS = [
        'name',
        'description',
        'price',
        'tax_id',
    ];
    
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function createProduct(array $params): Product
    {
        $product = new Product();
        $product->setName($params['name']);
        $product->setDescription($params['description']);
        $product->setPrice($params['price']);
        $product->setTaxId($params['tax_id']);

        $this->getEntityManager()->persist($product);
        $this->getEntityManager()->flush();

        return $product;
    }

   public function filters(?array $params = []): ?array
   {
        $pagesResults = 10;

        $query = $this->createQueryBuilder('p');

        if (!empty($params)) {
            if (array_key_exists('name', $params)) {
                $query->andWhere('p.name LIKE :name')
                    ->setParameter('name', '%'.$params['name'].'%');
            }
            if (array_key_exists('page', $params)) {
                $query->setFirstResult(($params['page'] - 1) * $pagesResults)
                    ->setMaxResults($pagesResults);
            }

        }

        $data = $query->getQuery()
           ->getResult();

        return $data ?? null;
   }
}
