<?php

namespace Valutazione\Alunno\Event;

use Valutazione\Alunno\Entity\Voto;

class VotoAggiornato
{
    
    /**
     * @var Voto
     */
    private $voto;
    
    /** 
     * @param Voto $voto
     */
    public function __construct(Voto $voto)
    {
        $this->voto = $voto;
    }
    
    /**
     * 
     * @return Voto
     */    
    public function getVoto(): Voto
    {
        return $this->voto;
    }
}
