<?php

namespace Alura\Leilao\Tests\Model;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use PHPUnit\Framework\TestCase;

class LeilaoTest extends TestCase
{
    public function testLeilaoNaoDeveRecberLancesRepetidos()
    {
        $leilao = new Leilao("Variante");
        $ana = new Usuario("Ana");

        $leilao->recebeLance(new Lance($ana, 1000));
        $leilao->recebeLance(new Lance($ana, 2000));

        static::assertCount(1, $leilao->getLances());
        static::assertEquals(1000, $leilao->getLances()[0]->getValor());
    }

    /**
     * @dataProvider gerarLances()
     */
    public function testLeilaoDeveReceberLances(int $qtdLances, Leilao $leilao, array $valores)
    {
        static::assertCount($qtdLances, $leilao->getLances());

        foreach ($valores as $i => $value) {
            static::assertEquals($value, $leilao->getLances()[$i]->getValor());
        }
    }

    public function testLeilaoNaoDeveAceitarMaisDe5LancesPorUsuario()
    {
        $leilao = new Leilao('Brasilia Amarela');
        $joao = new Usuario("Joao");
        $maria = new Usuario("Maria");

        $leilao->recebeLance(new Lance($joao, 1000));
        $leilao->recebeLance(new Lance($maria, 1500));
        $leilao->recebeLance(new Lance($joao, 2000));
        $leilao->recebeLance(new Lance($maria, 2500));
        $leilao->recebeLance(new Lance($joao, 3000));
        $leilao->recebeLance(new Lance($maria, 3500));
        $leilao->recebeLance(new Lance($joao, 4000));
        $leilao->recebeLance(new Lance($maria, 4500));
        $leilao->recebeLance(new Lance($joao, 5000));
        $leilao->recebeLance(new Lance($maria, 5500));

        $leilao->recebeLance(new Lance($joao, 6000));

        static::assertCount(10, $leilao->getLances());
        static::assertEquals(5500, $leilao->getLances()[array_key_last($leilao->getLances())]->getValor());
    }

    public function gerarLances()
    {
        $joao = new Usuario("Joao");
        $maria = new Usuario("Maria");

        $leilaoCom2Lances = new Leilao("Fusca 1979");
        $leilaoCom2Lances->recebeLance(new Lance($joao, 2000));
        $leilaoCom2Lances->recebeLance(new Lance($maria, 3000));

        $leilaoCom1Lance = new Leilao("Brasilia 89");
        $leilaoCom1Lance->recebeLance(new Lance($joao, 4000));

        return [
            '2-lances' => [2, $leilaoCom2Lances, [2000, 3000]],
            '1-lance' => [1, $leilaoCom1Lance, [4000]]
        ];
    }
}