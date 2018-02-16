<?php

namespace Valutazione\Alunno\Strategy\Media;

use Valutazione\Alunno\Entity\Alunno;

class MediaConValutazioniEscludibili extends AbstractMedia
{
    /** 
     * @inheritdoc
     */
    public function calcolaMedia(Alunno $alunno): float
    {
        if (!$this->isApplicabile($alunno)) {
            throw new \InvalidArgumentException;
        }
        
        if (count($alunno->getVoti()) == 0) {
            return MediaInterface::MEDIA_NON_ESISTENTE;
        }
        $voti = [];
        //esclusione dei valori fuori media
        foreach ($alunno->getVoti() as $voto) {
            /** @var Valutazione\Alunno\Entity\Voto $voto */
            if ($voto->isInMedia()) {
                $voti[] = $voto;
            }
        }
        return $this->calcolaDaiVoti($voti);
    }
    
    /** 
     * @inheritdoc
     */
    public function isApplicabile(Alunno $alunno): bool
    {
        return $alunno->hasValutazione() &&
                $alunno->hasVotiFuoriMedia()
                ;
    }
}
