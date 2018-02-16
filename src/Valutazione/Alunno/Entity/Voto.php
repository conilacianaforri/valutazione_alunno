<?php

namespace Valutazione\Alunno\Entity;

use SimpleBus\Message\Recorder\ContainsRecordedMessages;
use SimpleBus\Message\Recorder\PrivateMessageRecorderCapabilities;

use Valutazione\Alunno\Event\VotoAggiornato;

class Voto implements ContainsRecordedMessages
{
    use PrivateMessageRecorderCapabilities;
    
    /**
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $descrizione;
    /**
     * @var integer
     */
    private $valutazione;
    /**
     * @var bool
     */
    private $inMedia;
    /**
     * @var Alunno
     */
    private $alunno;
    
    /**
     * @param Alunno $alunno
     * @param string $id
     * @param string $descrizione
     * @param int $valutazione
     * @param bool $inMedia
     * @throws \DomainException
     */
    public function __construct(
    
        Alunno $alunno,
        string $id,
        string $descrizione,
        int $valutazione = null,
        bool $inMedia = null
    ) {
        $this->alunno = $alunno;
        $this->id = $id;
        $this->descrizione = $descrizione;
        $this->valutazione = $valutazione;
        $this->inMedia = $inMedia;
        if (! $this->testaCoerenza()) {
            throw new \DomainException("Il voto non rispetta i vincoli di dominio");
        }
        $this->notificaRecordAggiornato();
    }
    
    /** 
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getDescrizione(): string
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
        return $this->inMedia;
    }

    /** 
     * @return Alunno
     */
    public function getAlunno(): Alunno
    {
        return $this->alunno;
    }
    
    /** 
     * @param string $descrizione
     * @param int $valutazione
     * @param bool $inMedia
     * @throws \DomainException
     */
    public function modifica(
    
        string $descrizione,
        int $valutazione = null,
        bool $inMedia = null
    ): void {
        $oldMe = clone $this;
        $this->descrizione = $descrizione;
        $this->valutazione = $valutazione;
        $this->inMedia = $inMedia;
        if (! $this->testaCoerenza()) {
            throw new \DomainException("Il voto non rispetta i vincoli di dominio");
        }
        if ($oldMe != $this) {
            $this->notificaRecordAggiornato();
        }
    }
    
    /**
     * @return bool
     */
    protected function testaCoerenza(): bool
    {
        $valutazioneCorente = $this->alunno->hasValutazione() ?
                !empty($this->valutazione) :
                empty($this->valutazione);
        $fuoriMediaCoerente = $this->alunno->hasVotiFuoriMedia() ?
                !is_null($this->inMedia) :
                is_null($this->inMedia);
        $punteggioCoerente = is_null($this->valutazione) ?:
                ($this->valutazione > 0) && ($this->valutazione <= 10);
        return $valutazioneCorente && $fuoriMediaCoerente && $punteggioCoerente;
    }
    
    /**
     * per notifica event doctrine con simple bus
     */
    protected function notificaRecordAggiornato(): void
    {
        $this->record(new VotoAggiornato($this));
    }
}
