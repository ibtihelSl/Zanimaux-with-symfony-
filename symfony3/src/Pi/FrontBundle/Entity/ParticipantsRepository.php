<?php
/**
 * Created by PhpStorm.
 * User: abdelaziz
 * Date: 19/02/2018
 * Time: 22:54
 */

namespace Pi\FrontBundle\Entity;
use Doctrine\ORM\EntityRepository;

class ParticipantsRepository extends EntityRepository
{


    public function notification($g)
    {
        $query=$this->createQueryBuilder("m")
            ->where('m.participant = :participant AND m.dateDebut  BETWEEN CURRENT_DATE() AND CURRENT_DATE()')
            ->setParameter('participant',$g);

        return $query->getQuery()->getResult();

    }
}