<?php

namespace Pi\FrontBundle\Repository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends \Doctrine\ORM\EntityRepository
{
    public function UpdateUserr()
    {
        $query = $this->getEntityManager()
            ->createQuery(" 
    select COUNT (s) AS nb from PiFrontBundle:User s
      ");
        return $query->getResult();

    }
}