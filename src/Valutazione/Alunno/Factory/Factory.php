<?php
namespace Valutazione\Alunno\Factory;

use Valutazione\Alunno\Entity\Alunno;
use Valutazione\Alunno\Entity\Voto;
use Valutazione\Alunno\Command\AggiungiAlunnoCommand;
use Valutazione\Alunno\Command\ValutazioneItemCommand;

class Factory
{
    /** 
     * @param AggiungiAlunnoCommand $command
     * @return Alunno
     */
    public function createAlunnoFromCommand(AggiungiAlunnoCommand $command): Alunno
    {
        return new Alunno(
            $command->getId(),
                $command->getNome(),
                $command->getCognome(),
                $command->getEmail(),
                $command->getMateria()
                );
    }
    
    /** 
     * @param ValutazioneItemCommand $commandVoto
     * @param Alunno $alunno
     * @return Voto
     */
    public function createVotoFromCommand(
    
        ValutazioneItemCommand $commandVoto,
            Alunno $alunno
    
    ): Voto {
        return new Voto($alunno,
            $commandVoto->getId(),
            $commandVoto->getDescrizione(),
            $commandVoto->getValutazione(),
            $commandVoto->isInMedia()
        );
    }
}
