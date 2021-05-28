<?php
//Chamando o arquivo
require_once("config.php");
//Encontrar a classe Sql
//Criar uma variável
/*
$sql = new sql();
//Executar um comando do banco de dados
//Criar uma variável pra receber nessa variável "$sql"
$usuarios = $sql->select("SELECT * FROM tb_usuarios");
//Fazer um echo json_encode da variável $usuarios
echo json_encode($usuarios);
*/

//Chamar apenas um usuário registrado no banco de dados
//Carrega um usuário
//Criar uma variável
//$root = new Usuario();
//Chamar o método que foi criado na classe Usuario
//$root->loadbyId(3);
//echo $root;

//Carrega uma lista de usuário
//$lista = Usuario::getlist(); //Obs. ::getlista porque é estatico. Quando é estatico não precisa instanciar o objeto
//echo json_encode($lista);

//Carregar uma lista de usuáriois buscando pelo login
//$search = Usuario::search("jo"); //No caso ira retornar todos os usuários que tem login com a "jo".
//echo json_encode($search);

//Carregar um usuário usando o login e a senha
//$usuario = new Usuario();
//$usuario->login("root", "!@#$"); //Caso login e senha não existe será exibido "login e ou senha inválidos". 
//echo $usuario;

//Inserir no banco de dados
/*
$aluno = new Usuario();
$aluno->setDeslogin("aluno");
$aluno->setDessenha("@lun0");
//Chamar o método insert pra mandar para o banco de dados
$aluno->insert();
echo $aluno;
*/
//Fazendo pelo método construtor feito no arquivo Usuario
//Criando um novo usuário
/*
$aluno = new Usuario("aluno", "@lun0");
$aluno->insert();
echo $aluno;
*/

//Fazer update
$usuario = new Usuario();
$usuario->loadById(8);
$usuario->update("professor", "!@#$%''&*");
echo $usuario;

?>  