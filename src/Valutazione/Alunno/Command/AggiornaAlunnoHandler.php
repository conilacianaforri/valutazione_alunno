<?php
namespace Valutazione\Alunno\Command;

use Valutazione\Alunno\Repository\AlunnoRepository;
use Valutazione\Alunno\Entity\Alunno;

class AggiornaAlunnoHandler
{
    /**
     * @var AlunnoRepository
     */
    private $repository;
    
    /**
     * @param AlunnoRepository $repository
     */
    public function __construct(AlunnoRepository $repository)
    {
        $this->repository = $repository;
    }
    
    /**
     * @param AggiornaAlunnoCommand $command
     * @throws \InvalidArgumentException
     */
    public function handle(AggiornaAlunnoCommand $command): void
    {
        $alunno = $this->repository->findById($command->getId());
        if (is_null($alunno)) {
            throw new \InvalidArgumentException();
        }
        $alunno->aggiorna(
            $command->getNome(),
            $command->getCognome(),
                $command->getEmail()
        );
        $this->repository->save($alunno);
    }
}
