<?php

namespace Valutazione\Alunno\Command;
use Valutazione\Alunno\Entity\Materia;

use Ramsey\Uuid\Uuid;

class AggiungiAlunnoCommand extends BaseAlunnoCommand
{
    /**
     * @var Materia 
     */
    private $materia;
    
    /**
     * @return AggiungiAlunnoCommand
     */
    public static function getCommand(): self
    {
        $command = new self;
        $command->setId(Uuid::uuid4());
        return $command;
    }
    
    /**
     * @return Materia
     */
    public function getMateria(): ?Materia
    {
        return $this->materia;
    }

    /**
     * @param Materia $materia
     */
    public function setMateria(Materia $materia): void
    {
        $this->materia = $materia;
    }
}
