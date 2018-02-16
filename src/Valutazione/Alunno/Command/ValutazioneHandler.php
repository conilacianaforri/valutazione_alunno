<?php
namespace Valutazione\Alunno\Command;

use Valutazione\Alunno\Repository\AlunnoRepository;
use Valutazione\Alunno\Factory\Factory;

class ValutazioneHandler
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
     *
     * @param \Valutazione\Alunno\Command\ValutazioneCommand $command
     * @throws \InvalidArgumentException
     *
     * @see Valutazione\Alunno\Entity\Voto::eventiAlCambiamento
     * le entità voto modificate notificano a EventBus di inviare una email
     * all'alunno (dopo il commit della transazione)
     *
     */
    public function handle(ValutazioneCommand $command): void
    {
        $alunno = $this->repository->findById($command->getId());
        if (is_null($alunno)) {
            throw new \InvalidArgumentException();
        }
        if (count($command->getItemCommands()) == 0) {
            return;
            //da gestire se si attiva il delete dei voti
        }
        foreach ($command->getItemCommands() as $commandVoto) {
            $votoEsistente = $alunno->getVoto($commandVoto->getId());
            if ($votoEsistente) {
                /** @var Valutazione\Alunno\Entity\Voto $voto*/
                /** @var ValutazioneItemCommand $commandVoto */
                $votoEsistente->modifica(
                    $commandVoto->getDescrizione(),
                        $commandVoto->getValutazione(),
                        $commandVoto->isInMedia()
                        );
            } else {
                $voto = $this->alunnoFactory->createVotoFromCommand($commandVoto, $alunno);
                $alunno->addVoto($voto);
            }
        }
        $this->repository->save($alunno);
    }
}
