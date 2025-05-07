<?php
require_once "conecta.php";

/* Lógica/Funções para o CRUD de Fabricantes */


function listarFabricantes(PDO $conexao):array {
    $sql = "SELECT * FROM fabricantes ORDER BY nome";

    try {
        $consulta = $conexao->prepare($sql);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $erro) {
        die("Erro: ".$erro->getMessage());
    }   
}


// inserirFabricante: usada pela página fabricantes/inserir.php
                                                        // void indica que não tem retorno
function inserirFabricante(PDO $conexao, string $nomeDoFabricante):void { 
    $sql = "INSERT INTO fabricantes(nome) VALUES(:nome)";

    try {
        $consulta = $conexao->prepare($sql);
        $consulta->bindValue(":nome", $nomeDoFabricante, PDO::PARAM_STR);        
        $consulta->execute();
    } catch (Exception $erro) {
        die("Erro ao inserir: ".$erro->getMessage());
    }
}


// listarUmFabricante: usada pela página fabricantes/atualizar.php
function listarUmFabricante(PDO $conexao, int $idFabricante):array {
    $sql = "SELECT * FROM fabricantes WHERE id = :id";

    try {
        $consulta = $conexao->prepare($sql);
        $consulta->bindValue(":id", $idFabricante, PDO::PARAM_INT);
        $consulta->execute();

        /* Usamos o fetch para garantir o retorno
        de um único array associativo com o resultado */
        return $consulta->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $erro) {
        die("Erro ao carregar fabricante: ".$erro->getMessage());
    }
}

// atualizarFabricante: usada em fabricantes/atualizar.php
function atualizarFabricante(
    PDO $conexao, int $idFabricante, string $nomeDoFabricante
    ):void {
    $sql = "UPDATE fabricantes SET nome = :nome WHERE id = :id";

    try {
        $consulta = $conexao->prepare($sql);
        $consulta->bindValue(":nome", $nomeDoFabricante, PDO::PARAM_STR);
        $consulta->bindValue(":id", $idFabricante, PDO::PARAM_INT);
        $consulta->execute();
    } catch (Exception $erro) {
        die("Erro ao atualizar fabricante: ".$erro->getMessage());
    }
}


// excluirFabricante: usada em fabricantes/excluir.php
function excluirFabricante(PDO $conexao, int $idFabricante):void {
    $sql = "DELETE FROM fabricantes WHERE id = :id";
    
    try {
        $consulta = $conexao->prepare($sql);
        $consulta->bindValue(":id", $idFabricante, PDO::PARAM_INT);
        $consulta->execute();
    } catch (Exception $erro) {
        die("Erro ao excluir fabricante: ".$erro->getMessage());
    }
}






