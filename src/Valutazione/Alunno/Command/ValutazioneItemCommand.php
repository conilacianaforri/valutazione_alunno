<?php

namespace Valutazione\Alunno\Command;

use Valutazione\Alunno\Entity\Voto;

class ValutazioneItemCommand
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $descrizione;
    /**
     * @var int
     */
    private $valutazione;
    /**
     * @var bool
     */
    private $isInMedia;
    
    /**
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }
    
    /**
     * @param Voto $voto
     * @return ValutazioneItemCommand
     */
    public static function getCommand(Voto $voto): self
    {
        $command = new self($voto->getId());
        $command->setDescrizione($voto->getDescrizione());
        $command->setIsInMedia($voto->isInMedia());
        $command->setValutazione($voto->getValutazione());
        return $command;
    }
    
    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getDescrizione(): ?string
    {
        return $this->descrizione;
    }

    /**
     * @return int|null
     */
    public function getValutazione(): ?int
    {
        return $this->valutazione;
    }

    /**
     * @return bool|null
     */
    public function isInMedia(): ?bool
    {
        return $this->isInMedia;
    }

    /**
     * @param string $descrizione
     */
    public function setDescrizione(string $descrizione = null): void
    {
        $this->descrizione = $descrizione;
    }

    /**
     * @param int $valutazione
     */
    public function setValutazione(int $valutazione = null): void
    {
        $this->valutazione = $valutazione;
    }

    /**
     * @param bool $isInMedia
     */
    public function setIsInMedia(bool $isInMedia = null): void
    {
        $this->isInMedia = $isInMedia;
    }
}
