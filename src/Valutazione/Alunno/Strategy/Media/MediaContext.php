<?php

namespace Valutazione\Alunno\Strategy\Media;

use Valutazione\Alunno\Entity\Alunno;

class MediaContext
{
    /**
     * @var iterable 
     */
    private $strategie = [];
    
    /** 
     * @param iterable $strategie
     */
    public function __construct(iterable $strategie)
    {
        $this->strategie = $strategie;
    }
    
    /**
     * @param Alunno $alunno
     * @return float
     * @throws \LogicException
     */
    public function calcolaMedia(Alunno $alunno): float
    {
        if (count($this->strategie) == 0) {
            throw new \LogicException("Nessuna strategia per calcolo media");
        }
        foreach ($this->strategie as $strategia) {
            /** @var MediaInterface $strategia **/
            if ($strategia->isApplicabile($alunno)) {
                return $strategia->calcolaMedia($alunno);
            }
        }
        throw new \LogicException("Alunno non compatibile con il calcolo della media");
    }
}
