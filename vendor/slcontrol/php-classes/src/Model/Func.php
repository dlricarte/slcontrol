<?php 

namespace slcontrol\Model;

use \slcontrol\DB\Sql;
use \slcontrol\Model;

/**
* 
*/
class Func extends User
{
	
	public static function verifyLoginFunc()
	{

		if
		(
			!isset($_SESSION[User::SESSION]) 
			||
			!$_SESSION[User::SESSION] 
			||
			!(int)$_SESSION[User::SESSION]["IDUSUARIO"] > 0 
			||
			(int)$_SESSION[User::SESSION]["ID_NIVELACESSO"] !== 2
		){

			header("Location: /application/login");
			exit;

		}			

	}

	public static function listAll()
	{

	$sql = new Sql();

		return $sql->select("SELECT IDDESPESA, DESC_DESPESA, DATA_DESPESA, KM, VALOR, NOTA_FISCAL, NOME, DESC_CONTA FROM DESPESA INNER JOIN USUARIO INNER JOIN CONTA WHERE ID_USUARIO = IDUSUARIO AND ID_CONTA = IDCONTA;");

	}

	public static function listAllReceitas()
	{

	$sql = new Sql();

		$lista =  $sql->select("SELECT R.IDRECEITA, R.DESC_RECEITA, R.ORIGEM, R.DESTINO, R.DATA_INICIO, R.DATA_FIM, R.VALOR, R.NOTA_FISCAL, U.NOME FROM RECEITA R INNER JOIN USUARIO U WHERE ID_USUARIO = IDUSUARIO;");

		foreach ($lista as $key => $value) {
			$key['VALOR'].$value[] = 10.00;
		}
		return $lista;
	}

	public function save()
	{

		$sql = new Sql();

		$results = $sql->query("INSERT INTO receita (DESC_RECEITA, ORIGEM, DESTINO, DATA_INICIO, DATA_FIM, VALOR, NOTA_FISCAL, ID_USUARIO)
		VALUES (:DESC_RECEITA, :ORIGEM, :DESTINO, :DATA_INICIO, :DATA_FIM, :VALOR, :NOTA_FISCAL, :ID_USUARIO);", array(
			":DESC_RECEITA"=>$this->getdesc_receita(),
			":ORIGEM"=>$this->getorigem(),
			":DESTINO"=>$this->getdestino(),
			":DATA_INICIO"=>$this->getdata_inicio(),
			":DATA_FIM"=>$this->getdata_fim(),
			":VALOR"=>$this->getvalor(),
			":NOTA_FISCAL"=>$this->getnota_fiscal(),
			":ID_USUARIO"=>$this->getid_usuario()
		));




	}

	public static function listUsers()
	{

		$sql = new Sql();

		return $sql->select("SELECT IDUSUARIO, NOME FROM USUARIO WHERE ID_NIVELACESSO != 1;");

	}

	public static function listContas()
	{

		$sql = new Sql();

		return $sql->select("SELECT IDCONTA, DESC_CONTA FROM CONTA;");

	}

	public function get($idreceita)
	{

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM receita WHERE IDRECEITA = :IDRECEITA;", array(
			":IDRECEITA"=>$idreceita
		));

		$this->setData($results[0]);

	}

	public function update()
	{

		$sql = new Sql();

		$results = $sql->query("UPDATE receita SET DESC_RECEITA = :DESC_RECEITA, ORIGEM = :ORIGEM, DESTINO = :DESTINO, DATA_INICIO = :DATA_INICIO, DATA_FIM = :DATA_FIM, VALOR = :VALOR, NOTA_FISCAL = :NOTA_FISCAL, ID_USUARIO = :ID_USUARIO WHERE IDRECEITA = :IDRECEITA;", array(
			":IDRECEITA"=>$this->getIDRECEITA(),
			":DESC_RECEITA"=>$this->getdesc_receita(),
			":ORIGEM"=>$this->getorigem(),
			":DESTINO"=>$this->getdestino(),
			":DATA_INICIO"=>$this->getdata_inicio(),
			":DATA_FIM"=>$this->getdata_fim(),
			":VALOR"=>$this->getvalor(),
			":NOTA_FISCAL"=>$this->getnota_fiscal(),
			":ID_USUARIO"=>$this->getid_usuario()
		));

		// $this->setData($results[0]);

	}

	public function delete()
	{

		$sql = new Sql();

		$sql->query("DELETE FROM receita WHERE IDRECEITA = :IDRECEITA", array(
			":IDRECEITA"=>$this->getIDRECEITA()
		));

	}


	/* Despesas */

	public function saveDespesa()
	{

		$sql = new Sql();

		$results = $sql->query("INSERT INTO despesa (DESC_DESPESA, DATA_DESPESA, KM, VALOR, NOTA_FISCAL, ID_USUARIO, ID_CONTA)
		VALUES (:DESC_DESPESA, :DATA_DESPESA, :KM, :VALOR, :NOTA_FISCAL, :ID_USUARIO, :ID_CONTA);", array(
			":DESC_DESPESA"=>$this->getdesc_despesa(),
			":DATA_DESPESA"=>$this->getdata_despesa(),
			":KM"=>$this->getkm(),
			":VALOR"=>$this->getvalor(),
			":NOTA_FISCAL"=>$this->getnota_fiscal(),
			":ID_USUARIO"=>$this->getid_usuario(),
			":ID_CONTA"=>$this->getid_conta()
		));

	}

	public function getDespesa($iddespesa)
	{

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM despesa WHERE IDDESPESA = :IDDESPESA;", array(
			":IDDESPESA"=>$iddespesa
		));

		$this->setData($results[0]);

	}

	public function updateDespesa()
	{

		$sql = new Sql();

		$results = $sql->query("UPDATE despesa SET DESC_DESPESA = :DESC_DESPESA, DATA_DESPESA = :DATA_DESPESA, KM = :KM, VALOR = :VALOR, NOTA_FISCAL = :NOTA_FISCAL, ID_USUARIO = :ID_USUARIO, ID_CONTA = :ID_CONTA WHERE IDDESPESA = :IDDESPESA;", array(
			":IDDESPESA"=>$this->getIDDESPESA(),
			":DESC_DESPESA"=>$this->getdesc_despesa(),
			":DATA_DESPESA"=>$this->getdata_despesa(),
			":KM"=>$this->getkm(),
			":VALOR"=>$this->getvalor(),
			":NOTA_FISCAL"=>$this->getnota_fiscal(),
			":ID_USUARIO"=>$this->getid_usuario(),
			":ID_CONTA"=>$this->getid_conta(),
		));

		// $this->setData($results[0]);

	}

	public function deleteDespesa()
	{

		$sql = new Sql();

		$sql->query("DELETE FROM despesa WHERE IDDESPESA = :IDDESPESA", array(
			":IDDESPESA"=>$this->getIDDESPESA()
		));

	}


}

 ?>