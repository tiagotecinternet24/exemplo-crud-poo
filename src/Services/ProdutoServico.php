<?php

namespace ExemploCrud\Services;

use PDO;
use Exception;
use ExemploCrud\Database\ConexaoBD;
use ExemploCrud\Models\Produto;
use Throwable;

final class ProdutoServico
{
    private PDO $conexao;

    public function __construct()
    {
        $this->conexao = ConexaoBD::getConexao();
    }

    public function listarTodos(): array
    {
        $sql = "SELECT 
                    produtos.id, produtos.nome AS produto, 
                    produtos.preco, produtos.quantidade,
                    (produtos.preco * produtos.quantidade) AS total,
                    fabricantes.nome AS fabricante
                FROM produtos INNER JOIN fabricantes
                ON produtos.fabricante_id = fabricantes.id
                ORDER BY produto";

        try {
            $consulta = $this->conexao->prepare($sql);
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        } catch (Throwable $erro) {
            throw new Exception("Erro ao carregar produtos: " . $erro->getMessage());
        }
    }

    public function inserir(Produto $produto): void
    {
        $sql = "INSERT INTO produtos 
                (nome, preco, quantidade, descricao, fabricante_id) 
                VALUES (:nome, :preco, :quantidade, :descricao, :fabricanteId)";

        try {
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindValue(":nome", $produto->getNome(), PDO::PARAM_STR);
            $consulta->bindValue(":preco", $produto->getPreco(), PDO::PARAM_STR);
            $consulta->bindValue(":quantidade", $produto->getQuantidade(), PDO::PARAM_INT);
            $consulta->bindValue(":descricao", $produto->getDescricao(), PDO::PARAM_STR);
            $consulta->bindValue(":fabricanteId", $produto->getFabricanteId(), PDO::PARAM_INT);
            $consulta->execute();
        } catch (Throwable $erro) {
            throw new Exception("Erro ao inserir produto: " . $erro->getMessage());
        }
    }

    public function buscarPorId(int $id): ?array
    {
        $sql = "SELECT * FROM produtos WHERE id = :id";

        try {
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindValue(":id", $id, PDO::PARAM_INT);
            $consulta->execute();
            return $consulta->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (Throwable $erro) {
            throw new Exception("Erro ao buscar produto por ID: " . $erro->getMessage());
        }
    }

    public function atualizar(Produto $produto): void
    {
        $sql = "UPDATE produtos SET 
                    nome = :nome,
                    preco = :preco,
                    quantidade = :quantidade,
                    descricao = :descricao,
                    fabricante_id = :fabricanteId
                WHERE id = :id";

        try {
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindValue(':nome', $produto->getNome(), PDO::PARAM_STR);
            $consulta->bindValue(':preco',  $produto->getPreco(), PDO::PARAM_STR);
            $consulta->bindValue(':quantidade', $produto->getQuantidade(), PDO::PARAM_INT);
            $consulta->bindValue(':descricao', $produto->getDescricao(), PDO::PARAM_STR);
            $consulta->bindValue(':fabricanteId', $produto->getFabricanteId(), PDO::PARAM_INT);
            $consulta->bindValue(':id', $produto->getId(), PDO::PARAM_INT);
            $consulta->execute();
        } catch (Throwable $erro) {
            throw new Exception("Erro ao atualizar produto: " . $erro->getMessage());
        }
    }

    public function excluir(int $id): void
    {
        $sql = "DELETE FROM produtos WHERE id = :id";

        try {
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindValue(":id", $id, PDO::PARAM_INT);
            $consulta->execute();
        } catch (Throwable $erro) {
            throw new Exception("Erro ao excluir produto: " . $erro->getMessage());
        }
    }
}
