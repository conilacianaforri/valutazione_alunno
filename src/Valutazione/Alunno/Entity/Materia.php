<?php
namespace Valutazione\Alunno\Entity;

class Materia
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $denominazione;
    /**
     * @var boolean
     */
    private $hasValutazione;
    /**
     * @var boolean
     */
    private $hasVotiFuoriMedia;
    
    /**
     * @param string $id
     * @param string $denominazione
     * @param bool $hasValutazione
     * @param bool $hasVotiFuoriMedia
     */
    public function __construct(
    
        string $id,
        string $denominazione,
        bool $hasValutazione,
        bool $hasVotiFuoriMedia
    ) {
        $this->id = $id;
        $this->denominazione = $denominazione;
        $this->hasValutazione = $hasValutazione;
        $this->hasVotiFuoriMedia = $hasVotiFuoriMedia;
    }
    
    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->denominazione;
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
    public function getDenominazione(): string
    {
        return $this->denominazione;
    }

    /** 
     * @return bool
     */
    public function hasValutazione(): bool
    {
        return $this->hasValutazione;
    }

    /**
     * @return bool
     */
    public function hasVotiFuoriMedia(): bool
    {
        return $this->hasVotiFuoriMedia;
    }
}
