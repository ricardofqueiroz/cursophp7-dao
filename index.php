<?php
//Chamando o arquivo
require_once("config.php");
//Encontrar a classe Sql
//Criar uma variável
$sql = new sql();
//Executar um comando do banco de dados
//Criar uma variável pra receber nessa variável "$sql"
$usuarios = $sql->select("SELECT * FROM tb_usuarios");
//Fazer um echo json_encode da variável $usuarios
echo json_encode($usuarios);

?>