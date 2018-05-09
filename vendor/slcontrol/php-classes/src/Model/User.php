<?php 

	namespace slcontrol\Model;

	use \slcontrol\DB\Sql;
	use \slcontrol\Model;

	class User extends Model {

		const SESSION = "User";

		public static function login($login, $password)
		{

			$sql = new Sql();

			$results = $sql->select("SELECT * FROM usuario WHERE NOME = :NOME", array(
				":NOME"=>$login
			));

			if (count($results) === 0)
			{

				throw new \Exception("Usuário inexistente ou senha inválida!");
				
			}

			$data = $results[0];

			if (password_verify($password, $data["SENHA"]) === true)
			{

				$user = new User();

				$user->setData($data);

				$_SESSION[User::SESSION] = $user->getData();

				return $user;

			}else {
				
				throw new \Exception("Usuário inexistente ou senha inválida!");

			}

		}

		public static function verifyLogin()
		{

			if (
				!isset($_SESSION[User::SESSION]) 
				||
				!$_SESSION[User::SESSION] 
				||
				!(int)$_SESSION[User::SESSION]["IDUSUARIO"] > 0 
				||
				(int)$_SESSION[User::SESSION]["ID_NIVELACESSO"] !== 1
			){

				header("Location: /admin/login");
				exit;

			}			

		}
		
		public static function logout()
		{

			$_SESSION[User::SESSION] = NULL;

		}

		public static function listAll()
		{

			$sql = new Sql();

			return $sql->select("SELECT * FROM usuario u INNER JOIN nivel_acesso n WHERE u.ID_NIVELACESSO = n.IDNIVELACESSO");

		}

		public function save()
		{

			$sql = new Sql();

			$results = $sql->query("INSERT INTO usuario (nome, email, senha, id_nivelacesso) VALUES (:NOME, :EMAIL, :SENHA, :IDNIVELACESSO)", array(
				":NOME"=>$this->getnome(),
				":EMAIL"=>$this->getemail(),
				":SENHA"=>$this->getsenha(),
				":IDNIVELACESSO"=>$this->getid_nivelacesso()
			));

			$this->setData($results[0]);

			// return var_dump($this->setData($results[0]));

		}

		public function update()
		{

			$sql = new Sql();

			$results = $sql->query("UPDATE usuario SET NOME = :NOME, EMAIL = :EMAIL, ID_NIVELACESSO = :ID_NIVELACESSO WHERE IDUSUARIO = :IDUSUARIO;", array(
				":NOME"=>$this->getnome(),
				":EMAIL"=>$this->getemail(),
				":ID_NIVELACESSO"=>$this->getid_nivelacesso(),
				":IDUSUARIO"=>$this->getIDUSUARIO()
			));

			// $this->setData($results[0]);

		}

		public function getUser($iduser)
		{

			$sql = new Sql();

			$results = $sql->select("SELECT * FROM usuario WHERE IDUSUARIO = :IDUSUARIO;", array(
				":IDUSUARIO"=>$iduser
			));

			$this->setData($results[0]);

		}

		public static function listUsers()
		{

			$sql = new Sql();

			return $sql->select("SELECT IDUSUARIO, NOME FROM USUARIO WHERE ID_NIVELACESSO != 1;");

		}

	}

 ?>