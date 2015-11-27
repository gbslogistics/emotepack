<?php

namespace GbsLogistics\Emotes\EmoteBundle\Entity;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;

class HistoryRepository extends EntityRepository
{
    public function findAllOrderedByDateCreated($limit = 0)
    {
        if (!is_integer($limit)) {
            throw new \InvalidArgumentException('Argument passed to findAllOrderedByDateCreated() must be an integer.');
        } elseif ($limit < 0) {
            throw new \InvalidArgumentException('Argument passed to findAllOrderedByDateCreated() must be a positive integer.');
        }
        $builder = $this->createQueryBuilder('h')
            ->orderBy('h.dateCreated', 'DESC');

        if (0 !== $limit) {
            $builder->setMaxResults($limit);
        }

        return $builder->getQuery()->getResult();
    }
}