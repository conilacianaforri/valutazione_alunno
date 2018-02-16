<?php

namespace Tests\Valutazione\Alunno\Subscriber;

use PHPUnit\Framework\TestCase;
use Valutazione\Alunno\Subscriber\InviaEmailQuandoVotoAggiornato;
use Valutazione\Alunno\Event\VotoAggiornato;
use Valutazione\Alunno\Strategy\Media\MediaInterface;

/**
 * @group unit
 * @group dominio
 * @group subscriber
 */
class inviaEmailQuandoVotoAggiornatoTest extends TestCase
{
    public function testNotify()
    {
        list($alunno, $voto, $message, $mailer) = $this->getMocks();
        
        $body = 'Ciao Nome Cognome, c’è una variazione nel voto con id id_voto.  
                Entra nella tua area riservata per vederla.
                ';
        $message->expects($this->once())->method("setBody")->with($body);
        
        $calcolatoreMedia = $this
                ->getMockBuilder('Valutazione\Alunno\Strategy\Media\MediaContext')
                ->disableOriginalConstructor()->getMock();
        $calcolatoreMedia->expects($this->once())->method("calcolaMedia")
                ->with($alunno)->willReturn(7);
        
        $event = new VotoAggiornato($voto);
        
        $subscriber = new InviaEmailQuandoVotoAggiornato($mailer, $calcolatoreMedia);
        $this->assertNull($subscriber->notify($event));
    }
    
    public function testNotifyWithNoMedia()
    {
        list($alunno, $voto, $message, $mailer) = $this->getMocks();
        
        $body = 'Ciao Nome Cognome, c’è una variazione nel voto con id id_voto.  
                Entra nella tua area riservata per vederla.
                ';
        $message->expects($this->once())->method("setBody")->with($body);
        
        $calcolatoreMedia = $this
                ->getMockBuilder('Valutazione\Alunno\Strategy\Media\MediaContext')
                ->disableOriginalConstructor()->getMock();
        $calcolatoreMedia->expects($this->once())->method("calcolaMedia")
                ->with($alunno)->willReturn(MediaInterface::MEDIA_NON_ESISTENTE);
        
        $event = new VotoAggiornato($voto);
        
        $subscriber = new InviaEmailQuandoVotoAggiornato($mailer, $calcolatoreMedia);
        $this->assertNull($subscriber->notify($event));
    }
    
    public function testNotifyRischioBocciatura()
    {
        list($alunno, $voto, $message, $mailer) = $this->getMocks();
        
        $body = 'Ciao Nome Cognome, c’è una variazione nel voto con id id_voto.  
                Entra nella tua area riservata per vederla.
                La tua media voti è 3.00. Sei a rischio di bocciatura.';
        $message->expects($this->once())->method("setBody")->with($body);
        
        $calcolatoreMedia = $this
                ->getMockBuilder('Valutazione\Alunno\Strategy\Media\MediaContext')
                ->disableOriginalConstructor()->getMock();
        $calcolatoreMedia->expects($this->once())->method("calcolaMedia")
                ->with($alunno)->willReturn(3);
        
        $event = new VotoAggiornato($voto);
        
        $subscriber = new InviaEmailQuandoVotoAggiornato($mailer, $calcolatoreMedia);
        $this->assertNull($subscriber->notify($event));
    }
    
    private function getMocks()
    {
        $alunno = $this->getMockBuilder('Valutazione\Alunno\Entity\Alunno')
                ->disableOriginalConstructor()->getMock();
        $alunno->expects($this->once())->method("getEmail")
                ->willReturn("test@te.st");
        $alunno->expects($this->once())->method("getNome")
                ->willReturn("nome");
        $alunno->expects($this->once())->method("getCognome")
                ->willReturn("cognome");
        
        $voto = $this->getMockBuilder('Valutazione\Alunno\Entity\Voto')
                ->disableOriginalConstructor()->getMock();
        $voto->expects($this->any())->method("getAlunno")->willReturn($alunno);
        $voto->expects($this->any())->method("getId")->willReturn('id_voto');
        
        $message = $this->getMockBuilder('\Swift_Message')
                ->disableOriginalConstructor()->getMock();
        $message->expects($this->once())->method("setTo")->with("test@te.st");
        $message->expects($this->once())->method("setSubject")->with("Variazione voto");
        
        $mailer = $this->getMockBuilder('\Swift_Mailer')
                ->disableOriginalConstructor()->getMock();
        $mailer->expects($this->once())->method("createMessage")->willReturn($message);
        $mailer->expects($this->once())->method("send")->with($message);
        
        return [$alunno, $voto, $message, $mailer];
    }
}
