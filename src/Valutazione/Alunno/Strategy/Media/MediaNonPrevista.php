<?php

namespace Valutazione\Alunno\Strategy\Media;

use Valutazione\Alunno\Entity\Alunno;

class MediaNonPrevista implements MediaInterface
{
    /** 
     * @inheritdoc
     */
    public function calcolaMedia(Alunno $alunno): float
    {
        if (!$this->isApplicabile($alunno)) {
            throw new \InvalidArgumentException;
        }
        return MediaInterface::MEDIA_NON_ESISTENTE;
    }
    
    /** 
     * @inheritdoc
     */
    public function isApplicabile(Alunno $alunno): bool
    {
        return !$alunno->hasValutazione();
    }
}
