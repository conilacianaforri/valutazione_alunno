<?php

namespace Tests\Valutazione\Alunno\Command;

use PHPUnit\Framework\TestCase;
use Valutazione\Alunno\Command\AggiornaAlunnoCommand;

/**
 * @group unit
 * @group dominio
 * @group command
 */
class AggiornaAlunnoCommandTest extends TestCase
{
    public function testGetCommand()
    {
        $alunno = $this->getMockBuilder('Valutazione\Alunno\Entity\Alunno')
                ->disableOriginalConstructor()
                ->getMock();
        $alunno->expects($this->once())->method("getId")
                ->willReturn("abcd");
        $alunno->expects($this->once())->method("getNome")
                ->willReturn("cnome");
        $alunno->expects($this->once())->method("getCognome")
                ->willReturn("ccognome");
        $alunno->expects($this->once())->method("getEmail")
                ->willReturn("email");
        $this->assertEquals($this->getCommand(), AggiornaAlunnoCommand::getCommand($alunno));
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
