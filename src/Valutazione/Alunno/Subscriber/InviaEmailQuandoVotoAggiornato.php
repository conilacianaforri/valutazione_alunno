<?php

namespace Valutazione\Alunno\Subscriber;

use Valutazione\Alunno\Event\VotoAggiornato;
use Valutazione\Alunno\Strategy\Media\MediaContext;
use Valutazione\Alunno\Strategy\Media\MediaInterface;

class InviaEmailQuandoVotoAggiornato
{
    const LIMITE_WARN_BOCCIATURA = 4;
    
    /**
     * @var type
     */
    private $mailer;
    
    /**
     * @var MediaContext
     */
    private $calcolatoreMedia;
    
    /**
     *
     * @param \Swift_Mailer $mailer
     * @param MediaContext $calcolatoreMedia
     */
    public function __construct(
        \Swift_Mailer $mailer,
            MediaContext $calcolatoreMedia
    ) {
        $this->mailer = $mailer;
        $this->calcolatoreMedia = $calcolatoreMedia;
    }
    
    /** 
     * @param VotoAggiornato $event
     */
    public function notify(VotoAggiornato $event): void
    {
        $voto = $event->getVoto();
        $message = $this->mailer->createMessage();
        $message->setTo($voto->getAlunno()->getEmail());
        $message->setSubject('Variazione voto');
        $message->setBody($this->getMessageBody($event));
        $this->mailer->send($message);
    }
    
    /** 
     * @param VotoAggiornato $event
     * @return string
     */
    private function getMessageBody(VotoAggiornato $event): string
    {
        $voto = $event->getVoto();
        $body = sprintf(
            'Ciao %s %s, c’è una variazione nel voto con id %s.  
                Entra nella tua area riservata per vederla.
                ',
                ucfirst($voto->getAlunno()->getNome()),
                ucfirst($voto->getAlunno()->getCognome()),
                $voto->getId()
                );
        //aggiunge warn per bocciatura
        $media = $this->calcolatoreMedia->calcolaMedia($voto->getAlunno());
        if ($media != MediaInterface::MEDIA_NON_ESISTENTE &&
                $media < self::LIMITE_WARN_BOCCIATURA) {
            $body .= sprintf(
                'La tua media voti è %.2f. Sei a rischio di bocciatura.',
                    $media
            );
        }
        return $body;
    }
}
