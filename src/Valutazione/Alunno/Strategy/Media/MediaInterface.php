<?php

namespace Valutazione\Alunno\Strategy\Media;

use Valutazione\Alunno\Entity\Alunno;

interface MediaInterface
{
    const MEDIA_NON_ESISTENTE = -1;
    /** 
     * @param Alunno $alunno
     * @return bool
     */
    public function isApplicabile(Alunno $alunno): bool;
    /** 
     * @param Alunno $alunno
     * @return float
     */
    public function calcolaMedia(Alunno $alunno): float;
}
