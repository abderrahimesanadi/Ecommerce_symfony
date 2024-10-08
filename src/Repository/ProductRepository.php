<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @return Product[] Returns an array of Product objects
     */

    public function findtheLatestProducts()
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC')
            ->getQuery();
    }

    /**
     * @return Product[] Returns an array of Product objects
     */

    public function searchProducts($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.title like :val')
            ->setParameter('val', '%' . $value . '%')
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function getProductsByCategory($id)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT * FROM product p  WHERE p.category_id = :p_id';

        $stmt = $conn->prepare($sql);

        $resultSet = $stmt->executeQuery(['p_id' => $id]);

        return $resultSet->fetchAllAssociative();
    }
    /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
