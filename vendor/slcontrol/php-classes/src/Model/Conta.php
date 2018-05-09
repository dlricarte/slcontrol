<?php 

namespace slcontrol\Model;

use \slcontrol\DB\Sql;
use \slcontrol\Model;

/**
* 
*/
class Conta extends User
{
	
	public static function verifyLoginFunc()
	{

		if (
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

		return $sql->select("SELECT * FROM conta");

	}

	public function getConta($idconta)
	{

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM conta WHERE IDCONTA = :IDCONTA;", array(
			":IDCONTA"=>$idconta
		));

		$this->setData($results[0]);

	}

	public function save()
	{

		$sql = new Sql();

		$results = $sql->query("INSERT INTO conta (DESC_CONTA, SALDO) VALUES (:DESC_CONTA, :SALDO)", array(
			":DESC_CONTA"=>$this->getdesc_conta(),
			":SALDO"=>$this->getsaldo()
		));

			// $this->setData($results[0]);

			// return var_dump($this->setData($results[0]));

		}

	public function update()
	{

		$sql = new Sql();

		$results = $sql->query("UPDATE conta SET DESC_CONTA = :DESC_CONTA, SALDO = :SALDO WHERE IDCONTA = :IDCONTA;", array(
			":DESC_CONTA"=>$this->getdesc_conta(),
			":SALDO"=>$this->getsaldo(),
			":IDCONTA"=>$this->getIDCONTA()
		));

			// $this->setData($results[0]);

	}

}

 ?>