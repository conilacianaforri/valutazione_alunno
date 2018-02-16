<?php

namespace Tests\Valutazione\Alunno\Strategy\Media;

use PHPUnit\Framework\TestCase;
use Valutazione\Alunno\Strategy\Media\MediaNonPrevista;
use Valutazione\Alunno\Strategy\Media\MediaInterface;

/**
 * @group unit
 * @group dominio
 * @group media_strategy
 */
class MediaNonPrevistaTest extends TestCase
{
    public function testCalcolaMedia()
    {
        $calcolaMedia = new MediaNonPrevista();
        $this->assertEquals(
            MediaInterface::MEDIA_NON_ESISTENTE,
                $calcolaMedia->calcolaMedia($this->getAlunno())
        );
    }
    
    public function testAllievoIncompatibileThrowsException()
    {
        $calcolaMedia = new MediaNonPrevista();
        $this->expectException(\InvalidArgumentException::class);
        $calcolaMedia->calcolaMedia($this->getAlunno(true));
    }
    
    private function getAlunno($hasValutazione = false)
    {
        $alunno = $this->getMockBuilder('Valutazione\Alunno\Entity\Alunno')
                ->disableOriginalConstructor()->getMock();
        $alunno->expects($this->once())->method("hasValutazione")
                ->willReturn($hasValutazione);
        $alunno->expects($this->any())->method("hasVotiFuoriMedia")
                ->willReturn(false);
        $alunno->expects($this->never())->method("getVoti");
        
        return $alunno;
    }
}
