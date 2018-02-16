<?php

namespace AppBundle\DataFixtures;

use Valutazione\Alunno\Entity\Materia;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Fixtures per Valutazione\Alunno\Entity\Materia
 */
class Materie extends Fixture
{
    /**
     * @inheritdoc
     */
    public function load(ObjectManager $manager): void
    {
        $materia = new Materia('id_italiano', 'Italiano', false, false);
        $this->addReference('materia_ita', $materia);
        $manager->persist($materia);
        
        $materia = new Materia('id_storia', 'Storia', true, false);
        $this->addReference('materia_storia', $materia);
        $manager->persist($materia);
        
        $materia = new Materia('id_matematica', 'Matematica', true, true);
        $this->addReference('materia_mate', $materia);
        $manager->persist($materia);
        
        $manager->flush();
    }
}
