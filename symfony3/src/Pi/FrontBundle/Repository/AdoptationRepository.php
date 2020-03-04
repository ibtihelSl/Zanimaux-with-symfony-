<?php

namespace Pi\FrontBundle\Repository;

/**
 * AdoptationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AdoptationRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAdoptionByNomprop($string){

        $query = $this->createQueryBuilder('d')
            ->select('d')
            ->where('d.nomprop LIKE :str')
            ->setParameter('str', '%'.$string.'%');
        ;



       // $query ->setParameter('1', '%'.$string.'%');
        return $query->getQuery()->getArrayResult();
    }

}