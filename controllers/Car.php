<?php
namespace controllers
{
	/*
	Classe pessoa
	*/
	class Car
	{
		//Atributo para banco de dados
		private $PDO;

		/*
		__construct
		Conectando ao banco de dados
		*/
		function __construct()
		{
			$this->PDO = new \PDO('mysql:host=localhost;dbname=test-dev-db', 'root', 'root'); //Conexão
			$this->PDO->setAttribute( \PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION ); //habilitando erros do PDO
		}
		/*
		lista
		Listand pessoas
		*/
		public function lista()
		{
			global $app;
			$sth = $this->PDO->prepare("SELECT * FROM cars");
			$sth->execute();
			$result = $sth->fetchAll(\PDO::FETCH_ASSOC);
			$app->render('default.php',["data"=>$result],200); 
		}

		/*
		get
		param $id
		Pega pessoa pelo id
		*/
		public function get($id)
		{
			global $app;
			$sth = $this->PDO->prepare("SELECT * FROM cars WHERE id = :id");
			$sth ->bindValue(':id',$id);
			$sth->execute();
			$result = $sth->fetch(\PDO::FETCH_ASSOC);
			$app->render('default.php',["data"=>$result],200); 
		}

		/*
		nova
		Cadastra pessoa
		*/
		public function nova()
		{
			global $app;
			$data = json_decode($app->request->getBody(), true);
			$data = (sizeof($data)==0)? $_POST : $data;
			$keys = array_keys($data); //Paga as chaves do array
			/*
			O uso de prepare e bindValue é importante para se evitar SQL Injection
			*/
			$sth = $this->PDO->prepare("INSERT INTO cars (".implode(',', $keys).") VALUES (:".implode(",:", $keys).")");
			foreach ($data as $key => $value) {
				$sth ->bindValue(':'.$key,$value);
			}
			$sth->execute();
			//Retorna o id inserido
			$app->render('default.php',["data"=>['id'=>$this->PDO->lastInsertId()]],200); 
		}

		/*
		editar
		param $id
		Editando pessoa
		*/
		public function editar($id)
		{
			global $app;
			$data = json_decode($app->request->getBody(), true);
			$data = (sizeof($data)==0)? $_POST : $data;
			$sets = [];
			foreach ($data as $key => $VALUES) {
				$sets[] = $key." = :".$key;
			}

			$sth = $this->PDO->prepare("UPDATE cars SET ".implode(',', $sets)." WHERE id = :id");
			$sth ->bindValue(':id',$id);
			foreach ($data as $key => $value) {
				$sth ->bindValue(':'.$key,$value);
			}
			//Retorna status da edição
			$app->render('default.php',["data"=>['status'=>$sth->execute()==1]],200); 
		}

		/*
		excluir
		param $id
		Excluindo pessoa
		*/
		public function excluir($id)
		{
			global $app;
			$sth = $this->PDO->prepare("DELETE FROM cars WHERE id = :id");
			$sth ->bindValue(':id',$id);
			$app->render('default.php',["data"=>['status'=>$sth->execute()==1]],200); 
		}
	}
}