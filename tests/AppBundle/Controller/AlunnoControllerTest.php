<?php
namespace Tests\AppBundle\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

/**
 * @group functional
 * @group valutazione_alunno
 */
class AlunnoControllerTest extends WebTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->loadFixtures(array(
            'AppBundle\DataFixtures\Alunni'
        ));
    }
    
    public function testIndex()
    {
        $crawler = $this->fetchCrawler('/');
        
        $this->assertCount(3, $crawler->filter("table.alunni tbody tr"));
    }
    
    public function testNewAlunno()
    {
        $client = $this->makeClient();
        $crawler = $client->request('GET', '/');
        $this->assertCount(3, $crawler->filter("table.alunni tbody tr"));
        $crawler = $client->click($crawler->filter("a.nuovo-alunno")->link());
        $form = $crawler->filter("button[type='submit']")->form([
            'aggiungi_alunno[nome]' => 'test_nome',
            'aggiungi_alunno[cognome]' => 'test_cognome',
            'aggiungi_alunno[email]' => 'test@te.st',
            'aggiungi_alunno[materia]' => 'id_italiano',
        ]);
        $crawler = $client->submit($form);
        $crawler = $client->followRedirect();
        $this->assertCount(4, $crawler->filter("table.alunni tbody tr"));
    }
    
    public function testNewAlunnoError()
    {
        $client = $this->makeClient();
        $crawler = $client->request('GET', '/alunno/new');
        $form = $crawler->filter("button[type='submit']")->form([
        ]);
        $crawler = $client->submit($form);
        $this->assertCount(4, $crawler->filter("form div.has-error"));
    }
    
    public function testShow()
    {
        $client = $this->makeClient();
        $crawler = $client->request('GET', '/');
        $client->click($crawler->filter("a.show-alunno")->link());
        $this->assertTrue($client->getResponse()->isOk());
    }
    
    public function testEditAlunno()
    {
        $client = $this->makeClient();
        $crawler = $client->request('GET', '/alunno/alunno_ita/voti');
        $this->assertCount(1, $crawler->filter("dd.dati_cognome:contains('Italiano')"));
        $this->assertCount(0, $crawler->filter("dd.dati_cognome:contains('Modificato')"));
        $crawler = $client->click($crawler->filter("a.modifica-alunno")->link());
        $form = $crawler->filter("button[type='submit']")->form([
            'aggiorna_alunno[cognome]' => 'modificato',
        ]);
        $crawler = $client->submit($form);
        $crawler = $client->followRedirect();
        $this->assertCount(0, $crawler->filter("dd.dati_cognome:contains('Italiano')"));
        $this->assertCount(1, $crawler->filter("dd.dati_cognome:contains('Modificato')"));
    }
    
    public function testEditAlunnoError()
    {
        $client = $this->makeClient();
        $crawler = $client->request('GET', '/alunno/alunno_ita/aggiorna');
        $form = $crawler->filter("button[type='submit']")->form([
            'aggiorna_alunno[nome]' => '',
            'aggiorna_alunno[cognome]' => '',
            'aggiorna_alunno[email]' => '',
        ]);
        $crawler = $client->submit($form);
        $this->assertCount(3, $crawler->filter("form div.has-error"));
    }
    
    public function testEditVoti()
    {
        $client = $this->makeClient();
        $crawler = $client->request('GET', 'alunno/alunno_mate/voti');
        $row = $crawler->filter("table.voti tbody tr:contains('voto_2_alunno_mate')");
        $this->assertCount(1, $row
                ->filter("td.voto-descrizione:contains('descrizione due')"));
        $this->assertCount(1, $row
                ->filter("td.voto-valutazione:contains('4')"));
        $this->assertCount(0, $row
                ->filter("td.voto-inmedia i.fa-check"));
        $crawler = $client->click($crawler->filter("a.modifica-voti")->link());
        $form = $crawler->filter("button[type='submit']")->form([
            'valutazione[itemCommands][1][descrizione]' => 'modificato',
            'valutazione[itemCommands][1][valutazione]' => '8',
            'valutazione[itemCommands][1][isInMedia]' => '1',
        ]);
        $crawler = $client->submit($form);
        $crawler = $client->followRedirect();
        $row = $crawler->filter("table.voti tbody tr:contains('voto_2_alunno_mate')");
        $this->assertCount(1, $row
                ->filter("td.voto-descrizione:contains('modificato')"));
        $this->assertCount(1, $row
                ->filter("td.voto-valutazione:contains('8')"));
        $this->assertCount(1, $row
                ->filter("td.voto-inmedia i.fa-check"));
    }
    
    public function testEditVotiError()
    {
        $client = $this->makeClient();
        $crawler = $client->request('GET', '/alunno/alunno_mate/valuta');
        $form = $crawler->filter("button[type='submit']")->form([
            'valutazione[itemCommands][1][valutazione]' => '',
        ]);
        $crawler = $client->submit($form);
        $this->assertCount(1, $crawler->filter("form div.has-error"));
    }
    
    public function testEditVotiNoVotiFuoriMedia()
    {
        $client = $this->makeClient();
        $crawler = $client->request('GET', 'alunno/alunno_storia/voti');
        $row = $crawler->filter("table.voti tbody tr:contains('voto_2_alunno_storia')");
        $this->assertCount(1, $row
                ->filter("td.voto-descrizione:contains('descrizione due')"));
        $this->assertCount(1, $row
                ->filter("td.voto-valutazione:contains('4')"));
        $this->assertCount(0, $row
                ->filter("td.voto-inmedia"));
        $crawler = $client->click($crawler->filter("a.modifica-voti")->link());
        $form = $crawler->filter("button[type='submit']")->form([
            'valutazione[itemCommands][1][descrizione]' => 'modificato',
            'valutazione[itemCommands][1][valutazione]' => '8',
        ]);
        $crawler = $client->submit($form);
        $crawler = $client->followRedirect();
        $row = $crawler->filter("table.voti tbody tr:contains('voto_2_alunno_storia')");
        $this->assertCount(1, $row
                ->filter("td.voto-descrizione:contains('modificato')"));
        $this->assertCount(1, $row
                ->filter("td.voto-valutazione:contains('8')"));
    }
    
    public function testEditVotiSoloDescrizione()
    {
        $client = $this->makeClient();
        $crawler = $client->request('GET', 'alunno/alunno_ita/voti');
        $row = $crawler->filter("table.voti tbody tr:contains('voto_2_alunno_ita')");
        $this->assertCount(1, $row
                ->filter("td.voto-descrizione:contains('descrizione due')"));
        $this->assertCount(0, $row
                ->filter("td.voto-valutazione"));
        $this->assertCount(0, $row
                ->filter("td.voto-inmedia"));
        $crawler = $client->click($crawler->filter("a.modifica-voti")->link());
        $form = $crawler->filter("button[type='submit']")->form([
            'valutazione[itemCommands][1][descrizione]' => 'modificato',
        ]);
        $crawler = $client->submit($form);
        $crawler = $client->followRedirect();
        $row = $crawler->filter("table.voti tbody tr:contains('voto_2_alunno_ita')");
        $this->assertCount(1, $row
                ->filter("td.voto-descrizione:contains('modificato')"));
    }
    
    public function testModificaVotoSendMail()
    {
        $client = $this->makeClient();
        $client->enableProfiler();
        
        $crawler = $client->request('GET', '/alunno/alunno_mate/valuta');
        $form = $crawler->filter("button[type='submit']")->form([
            'valutazione[itemCommands][1][valutazione]' => '8',
        ]);
        
        $client->followRedirects(false);
        $crawler = $client->submit($form);
        $mailCollector = $client->getProfile()->getCollector('swiftmailer');
        $this->assertSame(1, $mailCollector->getMessageCount());

        $collectedMessages = $mailCollector->getMessages();
        $message = $collectedMessages[0];

        $this->assertInstanceOf('Swift_Message', $message);
        $this->assertSame('Variazione voto', $message->getSubject());
        $this->assertSame('mail3@uu.zz', key($message->getTo()));
        $this->assertSame(
            'Ciao Alunno Matematica, c’è una variazione nel voto con id voto_2_alunno_mate.  
                Entra nella tua area riservata per vederla.
                ',
            $message->getBody()
        );
    }
    
    public function testInviaMailAvvisoBocciatura()
    {
        $client = $this->makeClient();
        $client->enableProfiler();
        $crawler = $client->request('GET', '/alunno/alunno_mate/valuta');
        $form = $crawler->filter("button[type='submit']")->form([
            'valutazione[itemCommands][0][valutazione]' => '3',
        ]);
        $client->followRedirects(false);
        $crawler = $client->submit($form);
        $mailCollector = $client->getProfile()->getCollector('swiftmailer');
        $this->assertSame(1, $mailCollector->getMessageCount());
        $collectedMessages = $mailCollector->getMessages();
        $message = $collectedMessages[0];
        $this->assertContains(
            'La tua media voti è 3.00. Sei a rischio di bocciatura.',
            $message->getBody()
        );
    }
}
