<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\ProjectTeam;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadProjectTeamData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 2; ++$i) {
            $projectTeam = (new ProjectTeam())
                ->setName('project-team'.$i)
            ;
            $this->setReference('project-team'.$i, $projectTeam);
            $manager->persist($projectTeam);
        }

        $manager->flush();
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 1;
    }
}