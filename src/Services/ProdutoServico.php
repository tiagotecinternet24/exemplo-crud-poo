<?php
namespace ExemploCrud\Services;

use Exception;
use PDO;
use Throwable;

use ExemploCrud\Database\ConexaoBD;
use ExemploCrud\Models\Produto;

final class ProdutoServico
{
    private PDO $conexao;

    public function __construct()
    {
        $this->conexao = ConexaoBD::getConexao();
    }

    // Daqui pra baixo vem os métodos CRUD
}