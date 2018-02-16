<?php

namespace Tests\Valutazione\Alunno\Command;

use PHPUnit\Framework\TestCase;
use Valutazione\Alunno\Command\ValutazioneCommand;
use Valutazione\Alunno\Command\ValutazioneItemCommand;

/**
 * @group unit
 * @group dominio
 * @group command
 */
class ValutazioneCommandTest extends TestCase
{
    public function testGetCommandWithItems()
    {
        $voto = $this->getMockBuilder('Valutazione\Alunno\Entity\Voto')
                ->disableOriginalConstructor()
                ->getMock();
        $voto->expects($this->once())->method("getId")
                ->willReturn("id_item");
        $voto->expects($this->once())->method("getDescrizione")
                ->willReturn("aaa");
        $voto->expects($this->once())->method("isInMedia")
                ->willReturn(true);
        $voto->expects($this->once())->method("getValutazione")
                ->willReturn(5);
        $alunno = $this->getMockBuilder('Valutazione\Alunno\Entity\Alunno')
                ->disableOriginalConstructor()
                ->getMock();
        $alunno->expects($this->once())->method("getId")
                ->willReturn("abcd");
        $alunno->expects($this->once())->method("hasValutazione")
                ->willReturn(true);
        $alunno->expects($this->once())->method("hasVotiFuoriMedia")
                ->willReturn(true);
        $alunno->expects($this->exactly(2))->method("getVoti")
                ->willReturn([$voto]);
        $this->assertEquals($this->getCommand(), ValutazioneCommand::getCommand($alunno));
    }
    
    public function testGetCommandWithoutItems()
    {
        $alunno = $this->getMockBuilder('Valutazione\Alunno\Entity\Alunno')
                ->disableOriginalConstructor()
                ->getMock();
        $alunno->expects($this->once())->method("getId")
                ->willReturn("abcd");
        $alunno->expects($this->once())->method("hasValutazione")
                ->willReturn(true);
        $alunno->expects($this->once())->method("hasVotiFuoriMedia")
                ->willReturn(true);
        $alunno->expects($this->once())->method("getVoti")
                ->willReturn([]);
        $this->assertEquals(
            $this->getCommand(false),
                ValutazioneCommand::getCommand($alunno)
        );
    }
    
    private function getCommand($withItem = true)
    {
        $command = new ValutazioneCommand('abcd', true, true);
        if ($withItem) {
            $item = new ValutazioneItemCommand("id_item");
            $item->setDescrizione("aaa");
            $item->setValutazione(5);
            $item->setIsInMedia(true);
            $command->addItemCommands($item);
        }
        return $command;
    }
}
