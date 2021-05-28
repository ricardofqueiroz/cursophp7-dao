<?php

//Criando a classe Usuário
class Usuario
{
	private $idusuario;
	private $deslogin;
	private $dessenha;
	private $dtcadastro;
	//Criando a função com "get e set" de idusuário
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
		//Obs: array são parâmetros

		//Validar a variável results
		//if(isset($results[0]))
		//Outra forma de fazer seria usando um count, qualquer uma das duas serve
		if(count($results) > 0)
		{
            //Obs: Como é um array sempre como a posição "0".
			/*
			$row = $results[0];
            //Pegar os dados e mandar para o sets
   			$this->setIdusuario($row['idusuario']);
			$this->setDeslogin($row['deslogin']);
			$this->setDessenha($row['dessenha']);
			//$this->setDtcadastro($row['dtcadastro']);
			//Colocar o dtcadastro no padrão de data e hora com "new date time"
			$this->setDtcadastro(new DateTime($row['dtcadastro']));
			*/
			$this->setData($results[0]);
		}
	}
	//Visualisar os dados vindo do banco

	//Criar um método para listar todos usários que estão na tabela

	public static function getlist() //Obs. Quando é estatico não precisa instanciar o objeto
	{
		$sql = new Sql();
		return $sql->select("SELECT * FROM tb_usuarios ORDER BY deslogin");
	}

	//Criar um método pra buscar um usuário no banco

	public static function search($login) //Obs. Também é estatico, não ira precisar instanciar
	{
		$sql = new Sql();
		return $sql->select("SELECT * FROM tb_usuarios WHERE deslogin LIKE :SEARCH ORDER BY deslogin", array(':SEARCH'=>"%".$login."%"));
	}

	//Criar um método pra obter os dados do usuário autenticado

	public function login($login, $password) //Obs. Neste caso não foi usado estatico porque esta sendo utilizado os "gets e sets".
	{
		$sql = new sql();
		$results = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN and dessenha = :PASSWORD", array(
			":LOGIN"=>$login, ":PASSWORD"=>$password));
		
		if(count($results) > 0)
		{
            //Obs: Como é um array sempre como a posição "0".
			//$row = $results[0];
            
            //Pegar os dados e mandar para o sets
   			/*
   			$this->setIdusuario($row['idusuario']);
			$this->setDeslogin($row['deslogin']);
			$this->setDessenha($row['dessenha']);
			$this->setDtcadastro(new DateTime($row['dtcadastro']));
			*/

			$this->setData($results[0]);
	    }
	    else
	    {
		throw new Exception("Login e/ou senha inválidos");
	}
}
//Método de insert
/*Para o insert funcionar com procedure como na função insert abaixo é preciso criar uma função para setar os dados primeiro.
Observe que para não ficar repetidos tantos set no decorrer do cógido como tem na função "login" acima e mais acima na função "loadById"
foram apagados nestas funções e substituido pelo código "$this->setData($results[0])" para o código ficar menor, neste caso por estar usando uma procedure, se não tivesse uma procedure seria de uma outra forma.*/
public function setData($data)
{
	$this->setIdusuario($data['idusuario']);
	$this->setDeslogin($data['deslogin']);
	$this->setDessenha($data['dessenha']);
	$this->setDtcadastro(new DateTime($data['dtcadastro']));
}

//Criar uma função de insert
public function insert()
{
	$sql = new Sql();
	/*Obs: De vez de usar uma query, vamos usar uma procedure dentro de um select. Dentro da procedure é usado dois parâmetros,
	que no caso é login e password. É usado um select porque quando a procedure é executada por ultimo ira usar uma função do banco
	de dados que irá trazer qual o id gerado na tabela. Também é preciso criar uma procedure no banco de dados.*/
	$results = $sql->select("CALL sp_usuarios_insert(:LOGIN, :PASSWORD)", array(
	    'LOGIN'=>$this->getDeslogin(),
	    'PASSWORD'=>$this->getDessenha()
	//Obs. Como esta usando o mysql na procedure é usado a palavra CALL e usado parênteses, se fosse no sqlserver seria execute.
	));
	if (count($results) > 0)
{
	$this->setData($results[0]);
}
}

//Criar uma função de update
//public function update()
//Usar esse função de outra forma, colocando a variável login e senha dentro do parâmetro
public function update($login, $password)
{
	//Usando os set
	$this->setDeslogin($login);
	$this->setDessenha($password);
	//Obs: Caso não colocasse as variávies no parâmetro não usaria os set

	$sql = new Sql();
	//Usaremos a query pra exibir o resultado
	$sql->query("UPDATE tb_usuarios SET deslogin = :LOGIN, dessenha = :PASSWORD WHERE idusuario = :ID", array(
	    ':LOGIN'=>$this->getDeslogin(),
	    ':PASSWORD'=>$this->getDessenha(),
	    ':ID'=>$this->getIdusuario()
	));
}

//Criar função delete
public function delete()
{
	$sql = new Sql();
	//Usaremos a querey
	$sql->query("DELETE FROM tb_usuarios WHERE idusuario = :ID", array(
	    ':ID'=>$this->getIdusuario()
	));
	//Obs: Caso queira zerar as informações depois que são apagadas do banco de dados, como é feito.
	$this->setIdusuario(0); //Deixar zerado
	$this->setDeslogin(""); //Deixar vazio
	$this->setDessenha(""); //Deixar vazio
	$this->setDtcadastro(new DateTime()); //Deixar data atual, ou seja vazia, poderia deixar nulo "null".

}
//Caso queira que passe por um método construtor
public function __construct($login = "", $password = "") 
//Obs. é usado = "", porque caso chame ou não retorna como vazio, evita da erro, não se torna obrigatório.
{
	$this->setDeslogin($login);
	$this->setDessenha($password);
} 


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