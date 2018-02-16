<?php

namespace Valutazione\Alunno\Strategy\Media;

use Valutazione\Alunno\Entity\Alunno;

class MediaOrdinaria extends AbstractMedia
{
    /** 
     * @inheritdoc
     */
    public function calcolaMedia(Alunno $alunno): float
    {
        if (!$this->isApplicabile($alunno)) {
            throw new \InvalidArgumentException;
        }
        return $this->calcolaDaiVoti($alunno->getVoti());
    }
    
    /** 
     * @inheritdoc
     */
    public function isApplicabile(Alunno $alunno): bool
    {
        return $alunno->hasValutazione() &&
                !$alunno->hasVotiFuoriMedia()
                ;
    }
}
