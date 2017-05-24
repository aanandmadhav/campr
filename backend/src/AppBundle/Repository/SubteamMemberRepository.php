<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Project;
use AppBundle\Entity\User;

class SubteamMemberRepository extends BaseRepository
{
    public function findByUserAndProject(User $user, Project $project)
    {
        return $this
            ->createQueryBuilder('sm')
            ->innerJoin('sm.subteam', 's')
            ->where('sm.user = :user')
            ->andWhere('s.project = :project')
            ->setParameters(['user' => $user, 'project' => $project])
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByWithLike(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $qb = $this
            ->createQueryBuilder('sm')
            ->leftJoin('sm.user', 'u')
        ;

        foreach ($criteria as $key => $value) {
            if (empty($value)) {
                continue;
            }

            if ($key === 'findIn') {
                foreach ($criteria[$key] as $column => $vals) {
                    $qb
                        ->andWhere($qb->expr()->in('u.'.$column, ':vals'))
                        ->setParameter('vals', $vals)
                    ;
                }

                continue;
            }

            $qb->andWhere(
                $qb->expr()->like(
                    'u.'.$key,
                    $qb->expr()->literal('%'.$value.'%')
                )
            );
        }

        if ($orderBy) {
            foreach ($orderBy as $key => $value) {
                $qb->orderBy('u.'.$key, $value);
            }
        }

        if ($limit) {
            $qb->setMaxResults($limit);
        }

        if ($offset) {
            $qb->setFirstResult($offset);
        }

        return $qb->getQuery()->getResult();
    }
}