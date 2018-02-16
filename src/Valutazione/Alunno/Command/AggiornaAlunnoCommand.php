<?php

namespace Valutazione\Alunno\Command;

use Valutazione\Alunno\Entity\Alunno;

class AggiornaAlunnoCommand extends BaseAlunnoCommand
{
    /**
     * @param Alunno $alunno
     * @return AggiornaAlunnoCommand
     */
    public static function getCommand(Alunno $alunno):  self
    {
        $command = new self;
        $command->setId($alunno->getId());
        $command->setNome($alunno->getNome());
        $command->setCognome($alunno->getCognome());
        $command->setEmail($alunno->getEmail());
        return $command;
    }
}
