<?php

//Criando uma classe Sql que irá extender de PDO
class Sql extends PDO
{
	private $conn;
	//Criar um método construtor
	//Esse método com o instaciamento abaixo já é suficiente pra conectar no banco
	public function __construct()
	{
		//Criando o instanciamento para conectar ao banco
		$this->conn = new PDO("mysql:host=localhost;dbname=dbphp7", "root", ""); //Caso tivesse senha colocaria root
	}
    //Criando métodos
	private function setParams($statment, $parameters = array())
	{
		//Criar um foreach
		foreach ($parameters as $key => $value)
		{
			$this->setParam($key, $value); 
		}
	}
	private function setParam($statment, $key, $value)
	{
		$statment->bindParam($key, $value);
	}
	//Fazer a execução dos comandos
	public function query($rawQuery, $params = array())
	{
		$stmt = $this->conn->prepare($rawQuery); //Obs: Como é uma classe extendida temos acesso ao prepare
		$this->setParams($stmt, $params);
		//Fazer o executar
        $stmt->execute();
		return $stmt;
	}
	//Criar um método para o select
	public function select($rawQuery, $params = array()):array
	{
		$stmt = $this->query($rawQuery, $params);
		return $stmt->fetchAll(PDO::FETCH_ASSOC); //Usar o "FETCH_ASSOC", que são os dados associativos
	}
}


?>