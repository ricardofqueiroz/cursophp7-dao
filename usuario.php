<?php

//Criando a classe Usuário
class Usuario
{
	private $idusuario;
	private $deslogin;
	private $dessenha;
	private $dtcadastro;
	//Criando a função com "get e set" de usuário
	public function getIdusuario()
	{
		return $this->idusuario;
	}
	public function setIdusuario($value)
	{
		return $this->idusuario = $value;
	}
	//Criando a função com "get e set" de deslogin
	public function getDeslogin()
	{
		return $this->deslogin;
	}
	public function setDeslogin($value)
	{
		return $this->deslogin = $value;
	}
	//Criando a função com "get e set" de dessenha
	public function getDessenha()
	{
		return $this->dessenha;
	}
	public function setDessenha($value)
	{
		return $this->dessenha = $value;
	}
	//Criando a função com "get e set" de dtcadastro
	public function getDtcadastro()
	{
		return $this->dtcadastro;
	}
	public function setDtcadastro($value)
	{
		return $this->dtcadastro = $value;
	}
	//Criar uma função pra carregar o id do usuário
	public function loadById($id)
	{
		$sql = new sql();
		$results = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID", array(":ID"=>$id));
		//Obs: array são paraêmtros

		//Validar a variável resultas
		//if(isset($results[0]))
		//Outra forma de fazer seria usando um count, qualquer uma das duas serve
		if(count($results) > 0)
		{
            //Obs: Como é um array sempre como a posição "0".
			$row = $results[0];
            //Pegar os dados e mandar para o sets
   			$this->setIdusuario($row['idusuario']);
			$this->setDeslogin($row['deslogin']);
			$this->setDessenha($row['dessenha']);
			//$this->setDtcadastro($row['dtcadastro']);
			//Colocar o dtcadastro no padrão de data e hora com "new date time"
			$this->setDtcadastro(new DateTime($row['dtcadastro']));
		}
	}
	//Visualisar os dados vindo do banco
	//Criar uma função com o método mágiso __toString
	public function __toString()
	{
		//Ira retornar um json_encode de array
		return json_encode(array(
			//Chamando os dados com get
		    "idusuario"=>$this->getIdusuario(),
		    "deslogin"=>$this->getDeslogin(),
		    "dessenha"=>$this->getDessenha(),
		    "dtcadastro"=>$this->getDtcadastro()->format("d/m/Y H:i:s")));  //É preciso usar o format que é o formato de data e hora
	}
}


?>