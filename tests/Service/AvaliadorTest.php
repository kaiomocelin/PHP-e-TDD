<?php

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Service\Avaliador;
use PHPUnit\Framework\TestCase;

class AvaliadroTest extends TestCase
{
    public function testAvaliadorDeveEncontrarMaiorValorEmOrdemCrescente()
    {

        // Arruma - Given
        $leilao = new Leilao('Fusca 89');

        $maria = new Usuario("Maria");
        $jose = new Usuario("José");

        $leilao->recebeLance(new Lance($maria, 4000));
        $leilao->recebeLance(new Lance($jose, 5000));

        $leiloeiro = new Avaliador();

        // Executa - When
        $leiloeiro->avalia($leilao);

        $maiorValor = $leiloeiro->getMaiorValor();

        // Verifica - Then
        self::assertEquals(5000, $maiorValor);
    }

    public function testAvaliadorDeveEncontrarMaiorValorEmOrdemDecrescente()
    {

        // Arruma - Given
        $leilao = new Leilao('Fusca 89');

        $maria = new Usuario("Maria");
        $jose = new Usuario("José");

        $leilao->recebeLance(new Lance($jose, 5000));
        $leilao->recebeLance(new Lance($maria, 4000));

        $leiloeiro = new Avaliador();

        // Executa - When
        $leiloeiro->avalia($leilao);

        $maiorValor = $leiloeiro->getMaiorValor();

        // Verifica - Then
        self::assertEquals(5000, $maiorValor);
    }

    public function testAvaliadorDeveEncontrarMenorValorEmOrdemDescrescente()
    {
        // Arruma - Given
        $leilao = new Leilao('Fusca 89');

        $maria = new Usuario("Maria");
        $jose = new Usuario("José");

        $leilao->recebeLance(new Lance($jose, 4500));
        $leilao->recebeLance(new Lance($maria, 4000));
        $leilao->recebeLance(new Lance($jose, 3500));
        $leilao->recebeLance(new Lance($maria, 2000));

        $leiloeiro = new Avaliador();

        // Executa - When
        $leiloeiro->avalia($leilao);

        $menorValor = $leiloeiro->getMenorValor();

        // Verifica - Then
        self::assertEquals(2000, $menorValor);
    }

    public function testAvaliadorDeveEncontrarMenorValorEmOrdemCrescente()
    {
        // Arruma - Given
        $leilao = new Leilao('Fusca 89');

        $maria = new Usuario("Maria");
        $jose = new Usuario("José");

        $leilao->recebeLance(new Lance($maria, 2000));
        $leilao->recebeLance(new Lance($jose, 3500));
        $leilao->recebeLance(new Lance($maria, 4000));
        $leilao->recebeLance(new Lance($jose, 4500));

        $leiloeiro = new Avaliador();

        // Executa - When
        $leiloeiro->avalia($leilao);

        $menorValor = $leiloeiro->getMenorValor();

        // Verifica - Then
        self::assertEquals(2000, $menorValor);
    }

    public function testAvaliadorDeveEncontrarOsTresMaioresLances()
    {
        // Arruma - Given
        $leilao = new Leilao('Fusca 89');

        $maria = new Usuario("Maria");
        $jose = new Usuario("José");

        $leilao->recebeLance(new Lance($maria, 2000));
        $leilao->recebeLance(new Lance($jose, 3500));
        $leilao->recebeLance(new Lance($maria, 4000));
        $leilao->recebeLance(new Lance($jose, 4500));

        $leiloeiro = new Avaliador();

        // Executa - When
        $leiloeiro->avalia($leilao);

        $maioresLances = $leiloeiro->getMaioresLances();

        // Verifica - Then
        self::assertCount(3, $maioresLances);
        self::assertEquals(4500, $maioresLances[0]->getValor());
        self::assertEquals(4000, $maioresLances[1]->getValor());
        self::assertEquals(3500, $maioresLances[2]->getValor());
    }
}
