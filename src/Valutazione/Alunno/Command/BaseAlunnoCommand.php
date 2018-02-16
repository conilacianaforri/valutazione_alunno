<?php

namespace Valutazione\Alunno\Command;

abstract class BaseAlunnoCommand
{
    /**
     * @var string
     */
    protected $id;
    /**
     * @var string
     */
    protected $nome;
    /**
     * @var string
     */
    protected $cognome;
    /**
     * @var string
     */
    protected $email;
    
    /**
     * @return string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNome(): ?string
    {
        return $this->nome;
    }

    /**
     * @return string
     */
    public function getCognome(): ?string
    {
        return $this->cognome;
    }

    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $nome
     */
    public function setNome(string $nome = null): void
    {
        $this->nome = $nome;
    }

    /**
     * @param string $cognome
     */
    public function setCognome(string $cognome = null): void
    {
        $this->cognome = $cognome;
    }

    /** 
     * @param string $email
     */
    public function setEmail(string $email = null): void
    {
        $this->email = $email;
    }
}
