<?php

namespace Valutazione\Alunno\Command;

use Valutazione\Alunno\Entity\Alunno;

class ValutazioneCommand
{
    /**
     * @var string 
     */
    private $id;
    /**
     * @var array 
     */
    private $itemCommands = [];
    /**
     * @var bool 
     */
    private $hasValutazioneField;
    /**
     * @var bool 
     */
    private $hasInMediaField;
    
    /**
     * @param string $id
     * @param bool $hasValutazioneField
     * @param bool $hasInMediaField
     */
    public function __construct(
    
        string $id,
            bool $hasValutazioneField,
            bool $hasInMediaField
    
    ) {
        $this->id = $id;
        $this->hasValutazioneField = $hasValutazioneField;
        $this->hasInMediaField = $hasInMediaField;
    }
    
    /**
     * @param Alunno $alunno
     * @return ValutazioneCommand
     */
    public static function getCommand(Alunno $alunno)
    {
        $command = new self(
            $alunno->getId(),
                $alunno->hasValutazione(),
                $alunno->hasVotiFuoriMedia()
        );
        if (count($alunno->getVoti()) == 0) {
            return $command;
        }
        foreach ($alunno->getVoti() as $voto) {
            $command->addItemCommands(ValutazioneItemCommand::getCommand($voto));
        }
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
     * @return array
     */
    public function getItemCommands(): array
    {
        return $this->itemCommands;
    }
    
    /**
     * @param array $itemCommands
     */
    public function setItemCommands(array $itemCommands): void
    {
        $this->itemCommands = $itemCommands;
    }
    
    /**
     * @param ValutazioneItemCommand $itemCommand
     */
    public function addItemCommands(ValutazioneItemCommand $itemCommand): void
    {
        $this->itemCommands[] = $itemCommand;
    }
    
    /**
     * @return bool
     */
    public function hasValutazioneField(): bool
    {
        return $this->hasValutazioneField;
    }
    
    /**
     * @return bool
     */
    public function hasInMediaField(): bool
    {
        return $this->hasInMediaField;
    }
}
