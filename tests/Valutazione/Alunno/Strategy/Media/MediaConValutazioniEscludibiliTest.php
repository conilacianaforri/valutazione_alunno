<?php

namespace Tests\Valutazione\Alunno\Strategy\Media;

use PHPUnit\Framework\TestCase;
use Valutazione\Alunno\Strategy\Media\MediaConValutazioniEscludibili;
use Valutazione\Alunno\Strategy\Media\MediaInterface;

/**
 * @group unit
 * @group dominio
 * @group media_strategy
 */
class MediaConValutazioniEscludibiliTest extends TestCase
{
    public function testCalcolaMediaTuttiInMedia()
    {
        $voti = [
                    ['valutazione' => 7,'in_media' => true],
                    ['valutazione' => 6,'in_media' => true],
                    ['valutazione' => 4,'in_media' => true]
                ];
        $calcolaMedia = new MediaConValutazioniEscludibili();
        $this->assertEquals(
            5.67,
                $calcolaMedia->calcolaMedia($this->getAlunno($voti))
        );
    }
    
    public function testCalcolaMediaValoriMisti1()
    {
        $voti = [
                    ['valutazione' => 7,'in_media' => true],
                    ['valutazione' => 6,'in_media' => true],
                    ['valutazione' => 4,'in_media' => false]
                ];
        $calcolaMedia = new MediaConValutazioniEscludibili();
        $this->assertEquals(
            6.5,
                $calcolaMedia->calcolaMedia($this->getAlunno($voti))
        );
    }
    
    public function testCalcolaMediaValoriMisti2()
    {
        $voti = [
                    ['valutazione' => 7,'in_media' => true],
                    ['valutazione' => 6,'in_media' => false],
                    ['valutazione' => 4,'in_media' => false]
                ];
        $calcolaMedia = new MediaConValutazioniEscludibili();
        $this->assertEquals(
            7,
                $calcolaMedia->calcolaMedia($this->getAlunno($voti))
        );
    }
    
    public function testCalcolaMediaNessunvalore()
    {
        $voti = [
                    ['valutazione' => 7,'in_media' => false],
                    ['valutazione' => 6,'in_media' => false],
                    ['valutazione' => 4,'in_media' => false]
                ];
        $calcolaMedia = new MediaConValutazioniEscludibili();
        $this->assertEquals(
            MediaInterface::MEDIA_NON_ESISTENTE,
                $calcolaMedia->calcolaMedia($this->getAlunno($voti))
        );
    }
    
    public function testAllievoIncompatibileThrowsException()
    {
        $calcolaMedia = new MediaConValutazioniEscludibili();
        $this->expectException(\InvalidArgumentException::class);
        $calcolaMedia->calcolaMedia($this->getAlunno([], true, false));
    }
    
    public function testAllievoSenzaVotiReturnMediaNonEsistente()
    {
        $calcolaMedia = new MediaConValutazioniEscludibili();
        $this->assertEquals(
            MediaInterface::MEDIA_NON_ESISTENTE,
                $calcolaMedia->calcolaMedia($this->getAlunno([]))
        );
    }
    
    private function getAlunno(
    
        $parametriVoti = [],
    
        $hasValutazione = true,
            $hasVotiFuoriMedia = true
    
    ) {
        $alunno = $this->getMockBuilder('Valutazione\Alunno\Entity\Alunno')
                ->disableOriginalConstructor()->getMock();
        $alunno->expects($this->once())->method("hasValutazione")
                ->willReturn($hasValutazione);
        $alunno->expects($this->once())->method("hasVotiFuoriMedia")
                ->willReturn($hasVotiFuoriMedia);
        
        if (!$hasValutazione || ! $hasVotiFuoriMedia) {
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
                $voto->expects($this->once())->method("isInMedia")
                        ->willReturn($parametroVoto["in_media"]);
                if ($parametroVoto["in_media"]) {
                    $voto->expects($this->once())->method("getValutazione")
                        ->willReturn($parametroVoto["valutazione"]);
                } else {
                    $voto->expects($this->never())->method("getValutazione");
                }
                $voti[] = $voto;
            }
            $alunno->expects($this->any())->method("getVoti")
                ->willReturn($voti);
        }
        return $alunno;
    }
}
