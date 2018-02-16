<?php

namespace Valutazione\Alunno\Strategy\Media;

abstract class AbstractMedia implements MediaInterface
{
    /**
     * @param iterable $voti
     * @return float
     */
    protected function calcolaDaiVoti(iterable $voti): float
    {
        if (count($voti) == 0) {
            return MediaInterface::MEDIA_NON_ESISTENTE;
        }
        $totalePunteggi = 0;
        foreach ($voti as $voto) {
            $totalePunteggi += $voto->getValutazione();
        }
        return round($totalePunteggi / count($voti), 2);
    }
}
