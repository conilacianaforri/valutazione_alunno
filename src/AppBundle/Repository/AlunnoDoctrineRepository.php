<?php
namespace AppBundle\Repository;

use Valutazione\Alunno\Repository\AlunnoRepository;
use Valutazione\Alunno\Entity\Alunno;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;

class AlunnoDoctrineRepository implements AlunnoRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    
    /**
     * @var EntityRepository
     */
    private $repository;
    
    /**
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $em->getRepository(Alunno::class);
    }
    
    public function findAll()
    {
        return $this->repository->createQueryBuilder("a")
                ->select("a, m")
                ->leftJoin("a.materia", "m")
                ->orderBy("a.cognome");
    }

    public function findById(string $id): ?Alunno
    {
        return $this->repository->findOneBy(['id' => $id]);
    }

    public function save(Alunno $alunno): void
    {
        $this->em->persist($alunno);
        $this->em->flush();
    }
}
