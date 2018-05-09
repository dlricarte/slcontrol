<?php 

session_start();

require_once("vendor/autoload.php");

use \Slim\Slim;
use \slcontrol\Page;
use \slcontrol\PageAdmin;
use \slcontrol\PageApplication;
use \slcontrol\Model\User;
use \slcontrol\Model\Func;
use \slcontrol\Model\Conta;
use \slcontrol\Model\Cliente;
use \slcontrol\Model\Fornecedor;
use \slcontrol\Model\Veiculo;

$app = new Slim();

$app->config('debug', true);

$app->get('/', function() {

	$page = new Page();

	$page->setTpl("index");
    
});

$app->get('/admin', function() {

	User::verifyLogin();
	
	$page = new PageAdmin();

	$page->setTpl("index");
    
});

$app->get('/admin/login', function() {

	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);

	$page->setTpl("login");
    
});

$app->post('/admin/login', function(){

	User::login($_POST["login"], $_POST["password"]);

	header("Location: /admin");
	exit;

});

$app->get('/admin/logout', function(){

	User::logout();

	header("Location: /admin/login");
	
	exit;

});

$app->get('/admin/users', function(){

	User::verifyLogin();

	$users = User::listAll();

	$page = new PageAdmin();

	$page->setTpl("users", array(
		"users" => $users
	));

});

$app->get('/admin/users/create', function(){

	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("users-create");

});

$app->get('/admin/users/:iduser/delete', function($iduser){

	User::verifyLogin();

});

$app->get('/admin/users/:iduser', function($iduser){

	User::verifyLogin();

	$page = new PageAdmin();

	$user = new User();

	$user->getUser((int)$iduser);

	$page->setTpl("users-update", 
		array(
			"user"=>$user->getData()
			// "users"=>$users
		)
	);

});

$app->post('/admin/users/create', function(){

	User::verifyLogin();

	$user = new User();

	$_POST["id_nivelacesso"] = (isset($_POST["id_nivelacesso"]))?1:0;

	$user->setData($_POST);

	$user->save();

	header("Location: /admin/users");
	exit;

});


$app->post('/admin/users/:iduser', function($iduser){

	User::verifyLogin();

	$user = new User();

	$user->getUser((int)$iduser);

	$user->setData($_POST);

	$user->update();

	header("Location: /admin/users");
	exit;

});


$app->get('/admin/contas', function(){

	User::verifyLogin();

	$contas = Conta::listAll();

	$page = new PageAdmin();

	$page->setTpl("contas", array(
		"contas" => $contas
	));

});

$app->get('/admin/contas/create', function(){

	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("contas-create");

});

$app->get('/admin/contas/:idconta/delete', function($idconta){

	User::verifyLogin();

});

$app->get('/admin/contas/:idconta', function($idconta){

	User::verifyLogin();

	$page = new PageAdmin();

	$conta = new Conta();

	$conta->getConta((int)$idconta);

	$page->setTpl("contas-update", 
		array(
			"conta"=>$conta->getData()
			// "users"=>$users
		)
	);

});

$app->post('/admin/contas/create', function(){

	User::verifyLogin();

	$conta = new Conta();

	$conta->setData($_POST);

	$conta->save();

	header("Location: /admin/contas");
	exit;

});


$app->post('/admin/contas/:idconta', function($idconta){

	User::verifyLogin();

	$conta = new Conta();

	$conta->getConta((int)$idconta);

	$conta->setData($_POST);

	$conta->update();

	header("Location: /admin/contas");
	exit;

});

$app->get('/admin/clientes', function(){

	User::verifyLogin();

	$clientes = Cliente::listAll();

	$page = new PageAdmin();

	$page->setTpl("clientes", array(
		"clientes" => $clientes
	));

});

$app->get('/admin/clientes/create', function(){

	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("clientes-create");

});

$app->get('/admin/clientes/:iduser/delete', function($idcliente){

	User::verifyLogin();

});

$app->get('/admin/clientes/:idcliente', function($idcliente){

	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("clientes-update");

});

$app->post('/admin/clientes/create', function(){

	User::verifyLogin();

	$user = new User();

	// $_POST["id_nivelacesso"] = (isset($_POST["id_nivelacesso"]))?1:0;

	$user->setData($_POST);

	$user->save();

	header("Location: /admin/clientes");
	exit;

});


$app->post('/admin/clientes/:idcliente', function($idcliente){

	User::verifyLogin();

});

$app->get('/admin/fornecedores', function(){

	User::verifyLogin();

	$fornecedores = Fornecedor::listAll();

	$page = new PageAdmin();

	$page->setTpl("fornecedores", array(
		"fornecedores" => $fornecedores
	));

});

$app->get('/admin/fornecedores/create', function(){

	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("fornecedores-create");

});

$app->get('/admin/fornecedores/:idfornecedor/delete', function($idfornecedor){

	User::verifyLogin();

});

$app->get('/admin/fornecedores/:idfornecedor', function($idfornecedor){

	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("fornecedores-update");

});

$app->post('/admin/fornecedores/create', function(){

	User::verifyLogin();

	$user = new User();

	// $_POST["id_nivelacesso"] = (isset($_POST["id_nivelacesso"]))?1:0;

	$user->setData($_POST);

	$user->save();

	header("Location: /admin/fornecedores");
	exit;

});


$app->post('/admin/fornecedores/:idfornecedor', function($idfornecedor){

	User::verifyLogin();

});

$app->get('/admin/veiculos', function(){

	User::verifyLogin();

	$veiculos = Veiculo::listAll();

	$page = new PageAdmin();

	$page->setTpl("veiculos", array(
		"veiculos" => $veiculos
	));

});

$app->get('/admin/veiculos/create', function(){

	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("veiculos-create");

});

$app->get('/admin/veiculos/:idveiculo/delete', function($idveiculo){

	User::verifyLogin();

});

$app->get('/admin/veiculos/:idveiculo', function($idveiculo){

	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("veiculos-update");

});

$app->post('/admin/veiculos/create', function(){

	User::verifyLogin();

	$user = new User();

	// $_POST["id_nivelacesso"] = (isset($_POST["id_nivelacesso"]))?1:0;

	$user->setData($_POST);

	$user->save();

	header("Location: /admin/veiculos");
	exit;

});


$app->post('/admin/veiculos/:idveiculo', function($idveiculo){

	User::verifyLogin();

});

$app->get('/application', function() {

	Func::verifyLoginFunc();
	
	$page = new PageApplication();

	$page->setTpl("index");
    
});

$app->get('/application/login', function() {

	$page = new PageApplication([
		"header"=>false,
		"footer"=>false
	]);

	$page->setTpl("login");
    
});

$app->post('/application/login', function(){

	Func::login($_POST["login"], $_POST["password"]);

	header("Location: /application");
	exit;

});

$app->get('/application/logout', function(){

	Func::logout();

	header("Location: /application/login");
	
	exit;

});

$app->get('/application/despesas', function(){

	Func::verifyLoginFunc();

	$despesas = Func::listAll();

	$page = new PageApplication();

	$page->setTpl("despesas", array(
		"despesas" => $despesas
	));

});

$app->get('/application/despesas/create', function(){

	Func::verifyLoginFunc();

	$page = new PageApplication();

	$users = Func::listUsers();

	$contas = Func::listContas();

	$page->setTpl("despesas-create", array(
		"users"=>$users,
		"contas"=>$contas
	));

});

$app->get('/application/despesas/:iddespesa/delete', function($iddespesa){

	Func::verifyLoginFunc();

	$despesa = new Func();

	$despesa->getDespesa((int)$iddespesa);

	$despesa->deleteDespesa();

	header("Location: /application/despesas");
	exit;

});

$app->get('/application/despesas/:idespesa', function($iddespesa){

	Func::verifyLoginFunc();

	$despesa = new Func();

	$despesa->getDespesa((int)$iddespesa);

	$users = Func::listUsers();

	$contas = Func::listContas();

	$page = new PageApplication();

	$page->setTpl("despesas-update", 
		array(
			"despesa"=>$despesa->getData(),
			"users"=>$users,
			"contas"=>$contas
		)
	);

});

$app->post('/application/despesas/create', function(){

	Func::verifyLoginFunc();

	$despesa = new Func();

	$despesa->setData($_POST);

	var_dump($despesa);

	$despesa->saveDespesa();

	 // var_dump($receita);

	header("Location: /application/despesas");
	exit;

});


$app->post('/application/despesas/:iddespesa', function($iddespesa){

	Func::verifyLoginFunc();

	$despesa = new Func();

	$despesa->getDespesa((int)$iddespesa);

	$despesa->setData($_POST);

	$despesa->updateDespesa();

	header("Location: /application/despesas");
	exit;

});

$app->get('/application/receitas', function(){

	Func::verifyLoginFunc();

	$receitas = Func::listAllReceitas();

	$page = new PageApplication();

	$page->setTpl("receitas", array(
		"receitas" => $receitas
	));

});

$app->get('/application/receitas/create', function(){

	Func::verifyLoginFunc();

	$page = new PageApplication();

	$users = Func::listUsers();

	$page->setTpl("receitas-create", array(
		"users"=>$users
	));

});

$app->get('/application/receitas/:idreceita/delete', function($idreceita){

	Func::verifyLoginFunc();

	$receita = new Func();

	$receita->get((int)$idreceita);

	$receita->delete();

	header("Location: /application/receitas");
	exit;

});

$app->get('/application/receitas/:idreceita', function($idreceita){

	Func::verifyLoginFunc();

	$receita = new Func();

	$receita->get((int)$idreceita);

	$users = Func::listUsers();

	$page = new PageApplication();

	$page->setTpl("receitas-update", 
		array(
			"receita"=>$receita->getData(),
			"users"=>$users
		)
	);

});

$app->post('/application/receitas/create', function(){

	Func::verifyLoginFunc();

	$receita = new Func();

	$receita->setData($_POST);

	var_dump($receita);

	$receita->save();

	 // var_dump($receita);

	header("Location: /application/receitas");
	exit;

});


$app->post('/application/receitas/:idreceita', function($idreceita){

	Func::verifyLoginFunc();

	$receita = new Func();

	$receita->get((int)$idreceita);

	$receita->setData($_POST);

	$receita->update();

	header("Location: /application/receitas");
	exit;

});


$app->run();

 ?>