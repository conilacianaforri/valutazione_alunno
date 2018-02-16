<?php

namespace Valutazione\Alunno\Factory;

use PHPUnit\Framework\TestCase;
use Valutazione\Alunno\Factory\Factory;
use Valutazione\Alunno\Entity\Alunno;
use Valutazione\Alunno\Entity\Voto;

/**
 * @group unit
 * @group dominio
 * @group factory
 */
class FactoryTest extends TestCase
{
    public function testCreateAlunnoFromCommand()
    {
        $materia = $this
                ->getMockBuilder('Valutazione\Alunno\Entity\Materia')
                ->disableOriginalConstructor()
                ->getMock();
        $command = $this
                ->getMockBuilder('Valutazione\Alunno\Command\AggiungiAlunnoCommand')
                ->disableOriginalConstructor()
                ->getMock();
        $command->expects($this->once())->method("getId")
                ->willReturn("alunno_id");
        $command->expects($this->once())->method("getNome")
                ->willReturn("nome");
        $command->expects($this->once())->method("getCognome")
                ->willReturn("cognome");
        $command->expects($this->once())->method("getEmail")
                ->willReturn("email");
        $command->expects($this->once())->method("getMateria")
                ->willReturn($materia);
        
        $alunno = new Alunno("alunno_id", "nome", "cognome", "email", $materia);
        
        $factory = new Factory();
        $this->assertEquals($alunno, $factory->createAlunnoFromCommand($command));
    }
    
    public function testCreateVotoFromCommand()
    {
        $alunno = $this
                ->getMockBuilder('Valutazione\Alunno\Entity\Alunno')
                ->disableOriginalConstructor()
                ->getMock();
        $alunno->expects($this->any())->method("hasValutazione")->willReturn(true);
        $alunno->expects($this->any())->method("hasVotiFuoriMedia")->willReturn(true);
        $command = $this
                ->getMockBuilder('Valutazione\Alunno\Command\ValutazioneItemCommand')
                ->disableOriginalConstructor()
                ->getMock();
        $command->expects($this->once())->method("getId")
                ->willReturn("voto_id");
        $command->expects($this->once())->method("getDescrizione")
                ->willReturn("descrizione");
        $command->expects($this->once())->method("getValutazione")
                ->willReturn(6);
        $command->expects($this->once())->method("isInMedia")
                ->willReturn(false);
        
        $voto = new Voto($alunno, "voto_id", "descrizione", 6, false);
        
        $factory = new Factory();
        $this->assertEquals(
            $voto,
                $factory->createVotoFromCommand($command, $alunno)
        );
    }
}
