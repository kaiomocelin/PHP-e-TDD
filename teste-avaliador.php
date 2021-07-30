<?php

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Service\Avaliador;

require 'vendor/autoload.php';

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
$valorEsperado = 5000;

if($valorEsperado == $maiorValor) {
    echo "TESTE OK";
} else {
    echo "TESTE FALHOU";
}