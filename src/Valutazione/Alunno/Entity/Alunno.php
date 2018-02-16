<?php
namespace Valutazione\Alunno\Entity;

class Alunno
{
    /**
     * @var string
     */
    private $id;
    /**
     *
     * @var string
     */
    private $nome;
    /**
     *
     * @var string
     */
    private $cognome;
    /**
     *
     * @var string
     */
    private $email;
    /**
     *
     * @var Materia
     */
    private $materia;
    
    /**
     * @var array
     */
    private $voti;
    
    /** 
     * @param string $id
     * @param string $nome
     * @param string $cognome
     * @param string $email
     * @param Materia $materia
     */
    public function __construct(
        string $id,
        string $nome,
        string $cognome,
        string $email,
        Materia $materia
    ) {
        $this->id = $id;
        $this->nome = $nome;
        $this->cognome = $cognome;
        $this->email = $email;
        $this->materia = $materia;
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
    public function getNome(): string
    {
        return $this->nome;
    }

    /** 
     * @return string
     */
    public function getCognome(): string
    {
        return $this->cognome;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /** 
     * @return Materia
     */
    public function getMateria(): Materia
    {
        return $this->materia;
    }
    
    /**
     * @return array
     */
    public function getVoti(): iterable
    {
        return $this->voti;
    }
    
    /**
     * @param string $nome
     * @param string $cognome
     * @param string $email
     */
    public function aggiorna(
        string $nome,
        string $cognome,
        string $email
    ): void {
        $this->nome = $nome;
        $this->cognome = $cognome;
        $this->email = $email;
    }
    
    /**
     * @return bool
     */
    public function hasValutazione(): bool
    {
        return $this->materia->hasValutazione();
    }
    
    public function hasVotiFuoriMedia(): bool
    {
        return $this->materia->hasVotiFuoriMedia();
    }
    
    /**
     * @param string $votoId
     * @return Voto|null
     */
    public function getVoto(string $votoId = null): ?Voto
    {
        if (empty($votoId) || count($this->voti) == 0) {
            return null;
        }
        foreach ($this->voti as $voto) {
            if ($voto->getId() == $votoId) {
                return $voto;
            }
        }
        return null;
    }
    
    /**
     * @param Voto $voto
     */
    public function addVoto(Voto $voto): void
    {
        $this->voti[] = $voto;
    }
}
