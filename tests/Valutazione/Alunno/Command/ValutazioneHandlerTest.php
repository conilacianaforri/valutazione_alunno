<?php

namespace Tests\Valutazione\Alunno\Command;

use PHPUnit\Framework\TestCase;
use Valutazione\Alunno\Command\ValutazioneHandler;
use Valutazione\Alunno\Command\ValutazioneCommand;
use Valutazione\Alunno\Command\ValutazioneItemCommand;

/**
 * @group unit
 * @group dominio
 * @group command
 */
class ValutazioneHandlerTest extends TestCase
{
    public function testHandleWillThrowExceptionWhenAlunnoNotFound()
    {
        $command = $this->getCommand();
        
        $repository = $this
                ->getMockBuilder('Valutazione\Alunno\Repository\AlunnoRepository')
                ->disableOriginalConstructor()
                ->getMock();
        $repository->expects($this->once())
                ->method("findById")
                ->with("abcd")
                ->willReturn(null);
        $repository->expects($this->never())
                ->method("save");
        $factory = $this
                ->getMockBuilder('Valutazione\Alunno\Factory\Factory')
                ->disableOriginalConstructor()
                ->getMock();
        $factory->expects($this->never())
                ->method("createVotoFromCommand");
        
        $handler = new ValutazioneHandler($repository, $factory);
        $this->expectException(\InvalidArgumentException::class);
        $handler->handle($command);
    }
    
    public function testCommandWithoutItemsWillReturn()
    {
        $command = $this->getCommand();
        
        $alunno = $this->getMockBuilder('Valutazione\Alunno\Entity\Alunno')
                ->disableOriginalConstructor()
                ->getMock();
        
        $repository = $this
                ->getMockBuilder('Valutazione\Alunno\Repository\AlunnoRepository')
                ->disableOriginalConstructor()
                ->getMock();
        $repository->expects($this->once())
                ->method("findById")
                ->with("abcd")
                ->willReturn($alunno);
        $repository->expects($this->never())
                ->method("save");
        $factory = $this
                ->getMockBuilder('Valutazione\Alunno\Factory\Factory')
                ->disableOriginalConstructor()
                ->getMock();
        $factory->expects($this->never())
                ->method("createVotoFromCommand");
        
        $handler = new ValutazioneHandler($repository, $factory);
        $this->assertNull($handler->handle($command));
    }
    
    public function testCommandUpdateItem()
    {
        $command = $this->getCommand(true);
        
        $voto = $this->getMockBuilder('Valutazione\Alunno\Entity\Voto')
                ->disableOriginalConstructor()
                ->getMock();
        $voto->expects($this->once())->method("modifica")
                ->with("aaa", 5, true)->willReturn(null);
        
        $alunno = $this->getMockBuilder('Valutazione\Alunno\Entity\Alunno')
                ->disableOriginalConstructor()
                ->getMock();
        $alunno->expects($this->once())->method("getVoto")
                ->with("id_item")->willReturn($voto);
        
        $repository = $this
                ->getMockBuilder('Valutazione\Alunno\Repository\AlunnoRepository')
                ->disableOriginalConstructor()
                ->getMock();
        $repository->expects($this->once())
                ->method("findById")
                ->with("abcd")
                ->willReturn($alunno);
        $repository->expects($this->once())
                ->method("save")
                ->with($alunno)
                ->willReturn(null);
        
        $factory = $this
                ->getMockBuilder('Valutazione\Alunno\Factory\Factory')
                ->disableOriginalConstructor()
                ->getMock();
        $factory->expects($this->never())
                ->method("createVotoFromCommand");
        
        $handler = new ValutazioneHandler($repository, $factory);
        $this->assertNull($handler->handle($command));
    }
    
    public function testCommandAddItem()
    {
        $command = $this->getCommand(true);
        
        $voto = $this->getMockBuilder('Valutazione\Alunno\Entity\Voto')
                ->disableOriginalConstructor()
                ->getMock();
        
        $alunno = $this->getMockBuilder('Valutazione\Alunno\Entity\Alunno')
                ->disableOriginalConstructor()
                ->getMock();
        $alunno->expects($this->once())->method("getVoto")
                ->with("id_item")->willReturn(null);
        $alunno->expects($this->once())->method("addVoto")
                ->with($voto)->willReturn(null);
        
        $repository = $this
                ->getMockBuilder('Valutazione\Alunno\Repository\AlunnoRepository')
                ->disableOriginalConstructor()
                ->getMock();
        $repository->expects($this->once())
                ->method("findById")
                ->with("abcd")
                ->willReturn($alunno);
        $repository->expects($this->once())
                ->method("save")
                ->with($alunno)
                ->willReturn(null);
        
        $factory = $this
                ->getMockBuilder('Valutazione\Alunno\Factory\Factory')
                ->disableOriginalConstructor()
                ->getMock();
        $factory->expects($this->once())
                ->method("createVotoFromCommand")
                ->willReturn($voto);
        
        $handler = new ValutazioneHandler($repository, $factory);
        $this->assertNull($handler->handle($command));
    }
    
    private function getCommand($withItem = false)
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
