<?php

namespace Tests\Valutazione\Alunno\Strategy\Media;

use PHPUnit\Framework\TestCase;
use Valutazione\Alunno\Strategy\Media\MediaContext;

/**
 * @group unit
 * @group dominio
 * @group media_strategy
 */
class MediaContextTest extends TestCase
{
    public function testCalcolaMedia()
    {
        $alunno = $this->getMockBuilder("Valutazione\Alunno\Entity\Alunno")
                ->disableOriginalConstructor()->getMock();
        $strategia = $this
                ->createMock("Valutazione\Alunno\Strategy\Media\MediaInterface");
        $strategia->expects($this->once())->method("isApplicabile")
                ->with($alunno)->willReturn(true);
        $strategia->expects($this->once())->method("calcolaMedia")
                ->with($alunno)->willReturn(5);
        
        $context = new MediaContext([$strategia]);
        $this->assertEquals(5, $context->calcolaMedia($alunno));
    }
    
    public function testCalcolaMediaSenzaStrategieThrowsException()
    {
        $alunno = $this->getMockBuilder("Valutazione\Alunno\Entity\Alunno")
                ->disableOriginalConstructor()->getMock();
        $context = new MediaContext([]);
        $this->expectException(\LogicException::class);
        $context->calcolaMedia($alunno);
    }
    
    public function testCalcolaMediaNessunaStrategiaApplicabileThrowsException()
    {
        $alunno = $this->getMockBuilder("Valutazione\Alunno\Entity\Alunno")
                ->disableOriginalConstructor()->getMock();
        $strategia = $this
                ->createMock("Valutazione\Alunno\Strategy\Media\MediaInterface");
        $strategia->expects($this->once())->method("isApplicabile")
                ->with($alunno)->willReturn(false);
        $strategia->expects($this->never())->method("calcolaMedia");
        
        $context = new MediaContext([$strategia]);
        $this->expectException(\LogicException::class);
        $context->calcolaMedia($alunno);
    }
}
