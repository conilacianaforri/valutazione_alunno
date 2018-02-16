<?php

namespace Tests\Valutazione\Alunno\Command;

use PHPUnit\Framework\TestCase;
use Valutazione\Alunno\Command\AggiornaAlunnoHandler;
use Valutazione\Alunno\Command\AggiornaAlunnoCommand;

/**
 * @group unit
 * @group dominio
 * @group command
 */
class AggiornaAlunnoHandlerTest extends TestCase
{
    public function testHandle()
    {
        $command = $this->getCommand();
        
        $alunno = $this->getMockBuilder('Valutazione\Alunno\Entity\Alunno')
                ->disableOriginalConstructor()
                ->getMock();
        $alunno->expects($this->once())->method("aggiorna")
                ->with("cnome", "ccognome", "email")
                ->willReturn(null);
        
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
        
        $handler = new AggiornaAlunnoHandler($repository);
        $this->assertNull($handler->handle($command));
    }
    
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
        
        $handler = new AggiornaAlunnoHandler($repository);
        $this->expectException(\InvalidArgumentException::class);
        $handler->handle($command);
    }
    
    private function getCommand()
    {
        $command = new AggiornaAlunnoCommand();
        $command->setId("abcd");
        $command->setNome("cnome");
        $command->setCognome("ccognome");
        $command->setEmail("email");
        return $command;
    }
}
