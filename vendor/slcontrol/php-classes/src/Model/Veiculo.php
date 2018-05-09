<?php 

namespace slcontrol\Model;

use \slcontrol\DB\Sql;
use \slcontrol\Model;

/**
* 
*/
class Veiculo extends User
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

}

 ?>