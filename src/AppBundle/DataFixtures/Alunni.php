<?php

namespace AppBundle\DataFixtures;

use Valutazione\Alunno\Entity\Alunno;
use Valutazione\Alunno\Entity\Voto;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Fixtures per Valutazione\Alunno\Entity\Alunno
 */
class Alunni extends Fixture implements DependentFixtureInterface
{
    /**
     * @inheritdoc
     */
    public function load(ObjectManager $manager): void
    {
        $alunno = new Alunno(
            'alunno_ita',
            'Alunno',
            'Italiano',
            'mail1@uu.zz',
            $this->getReference('materia_ita')
        );
          
        $voto = new Voto($alunno, 'voto_1_alunno_ita', 'descrizione uno');
        $alunno->addVoto($voto);
        $voto = new Voto($alunno, 'voto_2_alunno_ita', 'descrizione due');
        $alunno->addVoto($voto);
        
        $manager->persist($alunno);
        
        $alunno = new Alunno(
            'alunno_storia',
            'Alunno',
            'Storia',
            'mail2@uu.zz',
            $this->getReference('materia_storia')
        );
          
        $voto = new Voto($alunno, 'voto_1_alunno_storia', 'descrizione uno', 7);
        $alunno->addVoto($voto);
        $voto = new Voto($alunno, 'voto_2_alunno_storia', 'descrizione due', 4);
        $alunno->addVoto($voto);
        
        $manager->persist($alunno);
        
        $alunno = new Alunno(
            'alunno_mate',
            'Alunno',
            'Matematica',
            'mail3@uu.zz',
            $this->getReference('materia_mate')
        );
          
        $voto = new Voto($alunno, 'voto_1_alunno_mate', 'descrizione uno', 7, true);
        $alunno->addVoto($voto);
        $voto = new Voto($alunno, 'voto_2_alunno_mate', 'descrizione due', 4, false);
        $alunno->addVoto($voto);
        
        $manager->persist($alunno);
        
        $manager->flush();
    }
    
    /*
     * @inheritdoc
     */
    public function getDependencies(): array
    {
        return array(
            Materie::class,
        );
    }
}
