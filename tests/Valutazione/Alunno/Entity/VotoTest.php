<?php

namespace Tests\Valutazione\Alunno\Entity;

use PHPUnit\Framework\TestCase;
use Valutazione\Alunno\Entity\Voto;

/**
 * @group unit
 * @group dominio
 * @group entity
 */
class VotoTest extends TestCase
{
    public function testModificaOk()
    {
        $alunno = $this->getAlunno(true, true);
        $voto = new Voto($alunno, 'voto_id', 'aaa', 5, true);
        $this->assertNull($voto->modifica('aaa', 6, false));
        $alunno2 = $this->getAlunno(false, true);
        $voto2 = new Voto($alunno2, 'voto_id', 'aaa', null, true);
        $this->assertNull($voto2->modifica('aaa', null, false));
        $alunno3 = $this->getAlunno(true, false);
        $voto3 = new Voto($alunno3, 'voto_id', 'aaa', 5, null);
        $this->assertNull($voto3->modifica('aaa', 5, null));
        $alunno4 = $this->getAlunno(false, false);
        $voto4 = new Voto($alunno4, 'voto_id', 'aaa', null, null);
        $this->assertNull($voto4->modifica('aaa', null, null));
    }
    
    public function testModificaFail()
    {
        $alunno = $this->getAlunno(true, true);
        $voto = new Voto($alunno, 'voto_id', 'aaa', 5, true);
        $this->expectException(\DomainException::class);
        $this->assertNull($voto->modifica('aaa', null, false));
    }
    
    public function testModificaFail2()
    {
        $alunno = $this->getAlunno(true, true);
        $voto = new Voto($alunno, 'voto_id', 'aaa', 5, true);
        $this->expectException(\DomainException::class);
        $this->assertNull($voto->modifica('aaa', 5, null));
    }
    
    public function testModificaFail3()
    {
        $alunno = $this->getAlunno(true, true);
        $voto = new Voto($alunno, 'voto_id', 'aaa', 5, true);
        $this->expectException(\DomainException::class);
        $this->assertNull($voto->modifica('aaa', null, true));
    }
    
    public function testModificaFail4()
    {
        $alunno = $this->getAlunno(false, true);
        $voto = new Voto($alunno, 'voto_id', 'aaa', null, true);
        $this->expectException(\DomainException::class);
        $this->assertNull($voto->modifica('aaa', 5, true));
    }
    
    public function testModificaFail5()
    {
        $alunno = $this->getAlunno(false, false);
        $voto = new Voto($alunno, 'voto_id', 'aaa', null, null);
        $this->expectException(\DomainException::class);
        $this->assertNull($voto->modifica('aaa', null, true));
    }
    
    public function testModificaFail6()
    {
        $alunno = $this->getAlunno(true, true);
        $voto = new Voto($alunno, 'voto_id', 'aaa', 7, true);
        $this->expectException(\DomainException::class);
        $this->assertNull($voto->modifica('aaa', -1, true));
    }
    
    public function testModificaFail7()
    {
        $alunno = $this->getAlunno(true, true);
        $voto = new Voto($alunno, 'voto_id', 'aaa', 7, true);
        $this->expectException(\DomainException::class);
        $this->assertNull($voto->modifica('aaa', 11, true));
    }
    
    public function testCostruttoreSchedulaEvento()
    {
        $alunno = $this->getAlunno(true, true);
        $voto = new Voto($alunno, 'voto_id', 'aaa', 7, true);
        $this->assertCount(1, $voto->recordedMessages());
    }
    
    public function testModificaSchedulaEvento()
    {
        $alunno = $this->getAlunno(true, true);
        $voto = new Voto($alunno, 'voto_id', 'aaa', 7, true);
        $voto->eraseMessages();
        $voto->modifica('aaa', 8, false);
        $this->assertCount(1, $voto->recordedMessages());
    }
    
    public function testModificaSenzaCambiamentiNonSchedulaEvento()
    {
        $alunno = $this->getAlunno(true, true);
        $voto = new Voto($alunno, 'voto_id', 'aaa', 7, true);
        $voto->eraseMessages();
        $voto->modifica('aaa', 7, true);
        $this->assertCount(0, $voto->recordedMessages());
    }
    
    public function testErroreCostruttoreThrowsException()
    {
        $this->expectException(\DomainException::class);
        $alunno = $this->getAlunno(true, true);
        $voto = new Voto($alunno, 'voto_id', 'aaa', null, true);
    }
    
    public function getAlunno($hasValutazione, $hasVotiFuoriMedia)
    {
        $alunno = $this->getMockBuilder('Valutazione\Alunno\Entity\Alunno')
            ->disableOriginalConstructor()->getMock();
        $alunno->expects($this->any())
                    ->method("hasValutazione")->willReturn($hasValutazione);
        $alunno->expects($this->any())
                    ->method("hasVotiFuoriMedia")->willReturn($hasVotiFuoriMedia);
        return $alunno;
    }
}
