<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Project;
use Symfony\Component\HttpFoundation\ParameterBag;

class InfoRepository extends BaseRepository
{
    public function getQueryBuilderByProjectAndFilters(Project $project, ParameterBag $filters)
    {
        $qb = $this->createQueryBuilder('i');
        $qb->andWhere(
            $qb->expr()->eq(
                'i.project',
                $project->getId()
            )
        );

        $infoCategory = $this->getIntParam($filters, 'info_category', 0);
        $infoStatus = $this->getIntParam($filters, 'info_status', 0);
        $user = $this->getIntParam($filters, 'user', 0);

        if ($infoCategory) {
            $qb->andWhere(
                $qb->expr()->in(
                    'i.infoCategory',
                    (array) $infoCategory
                )
            );
        }

        if ($infoStatus) {
            $qb->andWhere(
                $qb->expr()->in(
                    'i.infoStatus',
                    (array) $infoStatus
                )
            );
        }

        if ($user) {
            $qb->innerJoin('i.users', 'u');
            $qb->andWhere(
                $qb->expr()->in(
                    'u.id',
                    (array) $user
                )
            );
        }

        return $qb;
    }
}