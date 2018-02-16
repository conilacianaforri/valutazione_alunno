<?php
namespace Valutazione\Alunno\Command;

use Valutazione\Alunno\Repository\AlunnoRepository;
use Valutazione\Alunno\Factory\Factory;

class AggiungiAlunnoHandler
{
    /**
     * @var AlunnoRepository
     */
    private $repository;
    
    /**
     * @var Factory
     */
    private $alunnoFactory;
    
    /**
     * @param AlunnoRepository $repository
     * @param Factory $alunnoFactory
     */
    public function __construct(AlunnoRepository $repository, Factory $alunnoFactory)
    {
        $this->repository = $repository;
        $this->alunnoFactory = $alunnoFactory;
    }
    
    /**
     * @param AggiungiAlunnoCommand $command
     */
    public function handle(AggiungiAlunnoCommand $command): void
    {
        $alunno = $this->alunnoFactory->createAlunnoFromCommand($command);
        $this->repository->save($alunno);
    }
}
