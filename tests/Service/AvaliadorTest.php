<?php

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Service\Avaliador;
use PHPUnit\Framework\TestCase;

class AvaliadorTest extends TestCase
{
    private $leiloeiro;

    protected function setUp(): void
    {
        $this->leiloeiro = New Avaliador();
    }

    /**
     * @dataProvider leilaoEmOrdemCrescente
     * @dataProvider leilaoEmOrdemDecrescente
     * @dataProvider leilaoEmOrdemAleatoria
     */
    public function testAvaliadorDeveEncontrarMaiorValor(Leilao $leilao)
    {
        // Executa - When
        $this->leiloeiro->avalia($leilao);
        $maiorValor = $this->leiloeiro->getMaiorValor();

        // Verifica - Then
        self::assertEquals(5000, $maiorValor);
    }

    /**
     * @dataProvider leilaoEmOrdemCrescente
     * @dataProvider leilaoEmOrdemDecrescente
     * @dataProvider leilaoEmOrdemAleatoria
     */
    public function testAvaliadorDeveEncontrarMenorValor(Leilao $leilao)
    {
        // Executa - When
        $this->leiloeiro->avalia($leilao);
        $menorValor = $this->leiloeiro->getMenorValor();

        // Verifica - Then
        self::assertEquals(3000, $menorValor);
    }

    /**
     * @dataProvider leilaoEmOrdemCrescente
     * @dataProvider leilaoEmOrdemDecrescente
     * @dataProvider leilaoEmOrdemAleatoria
     */
    public function testAvaliadorDeveEncontrarOsTresMaioresLances(Leilao $leilao)
    {
        // Executa - When
        $this->leiloeiro->avalia($leilao);

        $maioresLances = $this->leiloeiro->getMaioresLances();

        // Verifica - Then
        self::assertCount(3, $maioresLances);
        self::assertEquals(5000, $maioresLances[0]->getValor());
        self::assertEquals(4500, $maioresLances[1]->getValor());
        self::assertEquals(4000, $maioresLances[2]->getValor());
    }

    public function leilaoEmOrdemCrescente()
    {
        $leilao = new Leilao('Fusca 89');

        $maria = new Usuario("Maria");
        $jose = new Usuario("José");
        $ana = new Usuario("Ana");

        $leilao->recebeLance(new Lance($ana, 3000));
        $leilao->recebeLance(new Lance($maria, 4000));
        $leilao->recebeLance(new Lance($ana, 4500));
        $leilao->recebeLance(new Lance($jose, 5000));

        return [
            'ordem-crescente' => [$leilao]
        ];
    }

    public function leilaoEmOrdemDecrescente()
    {
        $leilao = new Leilao('Fusca 89');

        $maria = new Usuario("Maria");
        $jose = new Usuario("José");
        $ana = new Usuario("Ana");

        $leilao->recebeLance(new Lance($jose, 5000));
        $leilao->recebeLance(new Lance($ana, 4500));
        $leilao->recebeLance(new Lance($maria, 4000));
        $leilao->recebeLance(new Lance($ana, 3000));

        return [
            'ordem-decrescente' => [$leilao]
        ];
    }

    public function leilaoEmOrdemAleatoria()
    {
        $leilao = new Leilao('Fusca 89');

        $maria = new Usuario("Maria");
        $jose = new Usuario("José");
        $ana = new Usuario("Ana");

        $leilao->recebeLance(new Lance($jose, 5000));
        $leilao->recebeLance(new Lance($ana, 4500));
        $leilao->recebeLance(new Lance($ana, 3000));
        $leilao->recebeLance(new Lance($maria, 4000));

        return [
            'ordem-aleatoria' => [$leilao]
        ];
    }
}
