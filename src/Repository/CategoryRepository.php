<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    /**
     * @return  Returns an array 
     */
    public function findAllAndCount()
    {
        $conn = $this->getEntityManager()->getConnection();
        //$sql = 'SELECT c.name, c.id, count(p.id) as number_p FROM category c LEFT JOIN product p ON(p.category_id = c.id) GROUP BY c.name,c.id';
        $sql = 'SELECT c.name, c.id, c.product_number FROM category c';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        return $resultSet->fetchAllAssociative();
    }
}
