<?php

namespace Tests\Valutazione\Alunno\Command;

use PHPUnit\Framework\TestCase;
use Valutazione\Alunno\Command\AggiungiAlunnoHandler;
use Valutazione\Alunno\Command\AggiungiAlunnoCommand;

/**
 * @group unit
 * @group dominio
 * @group command
 */
class AggiungiAlunnoHandlerTest extends TestCase
{
    public function testHandle()
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
                ->method("save")
                ->with($alunno)
                ->willReturn(null);
        
        $factory = $this
                ->getMockBuilder('Valutazione\Alunno\Factory\Factory')
                ->disableOriginalConstructor()
                ->getMock();
        $factory->expects($this->once())
                ->method("createAlunnoFromCommand")
                ->with($command)
                ->willReturn($alunno);
        
        $handler = new AggiungiAlunnoHandler($repository, $factory);
        $this->assertNull($handler->handle($command));
    }
    
    
    private function getCommand()
    {
        $command = new AggiungiAlunnoCommand();
        $command->setId("abcd");
        $command->setNome("cnome");
        $command->setCognome("ccognome");
        $command->setEmail("email");
        $command->setMateria($this
                ->getMockBuilder('Valutazione\Alunno\Entity\Materia')
                ->disableOriginalConstructor()
                ->getMock());
        return $command;
    }
}
