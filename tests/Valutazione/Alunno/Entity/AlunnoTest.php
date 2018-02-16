<?php

namespace Tests\Valutazione\Alunno\Entity;

use PHPUnit\Framework\TestCase;
use Valutazione\Alunno\Entity\Alunno;

/**
 * @group unit
 * @group dominio
 * @group entity
 */
class AlunnoTest extends TestCase
{
    public function testAggiorna()
    {
        $materia = $this->getMockBuilder('Valutazione\Alunno\Entity\Materia')
                ->disableOriginalConstructor()->getMock();
        $expected = new Alunno('alunno_id', 'nome', 'cognome', 'email', $materia);
        $actual = new Alunno('alunno_id', 'fake', 'fake', 'fake', $materia);
        $actual->aggiorna('nome', 'cognome', 'email');
        $this->assertEquals($expected, $actual);
    }
    
    public function testGetVotiWithNullParamReturnNull()
    {
        $materia = $this->getMockBuilder('Valutazione\Alunno\Entity\Materia')
                ->disableOriginalConstructor()->getMock();
        $alunno = new Alunno('alunno_id', 'fake', 'fake', 'fake', $materia);
        $voto = $this->getMockBuilder('Valutazione\Alunno\Entity\Voto')
                ->disableOriginalConstructor()->getMock();
        $alunno->addVoto($voto);
        $this->assertNull($alunno->getVoto(null));
    }
    
    public function testGetVotiWithoutVotiReturnNull()
    {
        $materia = $this->getMockBuilder('Valutazione\Alunno\Entity\Materia')
                ->disableOriginalConstructor()->getMock();
        $alunno = new Alunno('alunno_id', 'fake', 'fake', 'fake', $materia);
        $this->assertNull($alunno->getVoto(null));
    }
    
    public function testGetVotiNotMatchingParamReturnNull()
    {
        $materia = $this->getMockBuilder('Valutazione\Alunno\Entity\Materia')
                ->disableOriginalConstructor()->getMock();
        $alunno = new Alunno('alunno_id', 'fake', 'fake', 'fake', $materia);
        $voto = $this->getMockBuilder('Valutazione\Alunno\Entity\Voto')
                ->disableOriginalConstructor()->getMock();
        $voto->expects($this->once())->method("getId")->willReturn("item_id");
        $alunno->addVoto($voto);
        $this->assertNull($alunno->getVoto("not_match"));
    }
    
    public function testGetVoti()
    {
        $materia = $this->getMockBuilder('Valutazione\Alunno\Entity\Materia')
                ->disableOriginalConstructor()->getMock();
        $alunno = new Alunno('alunno_id', 'fake', 'fake', 'fake', $materia);
        $voto = $this->getMockBuilder('Valutazione\Alunno\Entity\Voto')
                ->disableOriginalConstructor()->getMock();
        $voto->expects($this->once())->method("getId")->willReturn("item_id");
        $alunno->addVoto($voto);
        $this->assertEquals($voto, $alunno->getVoto("item_id"));
    }
}
