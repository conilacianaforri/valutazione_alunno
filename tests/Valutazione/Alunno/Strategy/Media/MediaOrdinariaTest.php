<?php

namespace Tests\Valutazione\Alunno\Strategy\Media;

use PHPUnit\Framework\TestCase;
use Valutazione\Alunno\Strategy\Media\MediaOrdinaria;
use Valutazione\Alunno\Strategy\Media\MediaInterface;

/**
 * @group unit
 * @group dominio
 * @group media_strategy
 */
class MediaOrdinariaTest extends TestCase
{
    public function testCalcolaMedia()
    {
        $voti = [
                    ['valutazione' => 7],
                    ['valutazione' => 6],
                    ['valutazione' => 4]
                ];
        $calcolaMedia = new MediaOrdinaria();
        $this->assertEquals(
            5.67,
                $calcolaMedia->calcolaMedia($this->getAlunno($voti))
        );
    }
    
    public function testAllievoIncompatibileThrowsException()
    {
        $calcolaMedia = new MediaOrdinaria();
        $this->expectException(\InvalidArgumentException::class);
        $calcolaMedia->calcolaMedia($this->getAlunno([], false));
    }
    
    public function testAllievoSenzaVotiReturnMediaNonEsistente()
    {
        $calcolaMedia = new MediaOrdinaria();
        $this->assertEquals(
            MediaInterface::MEDIA_NON_ESISTENTE,
                $calcolaMedia->calcolaMedia($this->getAlunno([]))
        );
    }
    
    private function getAlunno($parametriVoti = [], $hasValutazione = true)
    {
        $alunno = $this->getMockBuilder('Valutazione\Alunno\Entity\Alunno')
                ->disableOriginalConstructor()->getMock();
        $alunno->expects($this->once())->method("hasValutazione")
                ->willReturn($hasValutazione);
        $alunno->expects($this->any())->method("hasVotiFuoriMedia")
                ->willReturn(false);
        
        if (!$hasValutazione) {
            return $alunno;
        }
        
        if (count($parametriVoti) == 0) {
            $alunno->expects($this->once())->method("getVoti")
                ->willReturn([]);
        } else {
            $voti = [];
            foreach ($parametriVoti as $parametroVoto) {
                $voto = $this->getMockBuilder('Valutazione\Alunno\Entity\Voto')
                    ->disableOriginalConstructor()->getMock();
                $voto->expects($this->never())->method("isInMedia");
                $voto->expects($this->once())->method("getValutazione")
                        ->willReturn($parametroVoto["valutazione"]);
                $voti[] = $voto;
            }
            $alunno->expects($this->any())->method("getVoti")
                ->willReturn($voti);
        }
        return $alunno;
    }
}
