<?php
namespace controllers
{
    /**
     * Class Car
     * @package controllers
     */
	class Car
	{
        /**
         * @var \PDO
         */
		private $PDO;

        /**
         * Car constructor.
         */
		function __construct()
		{
			$this->PDO = new \PDO('mysql:host=localhost;dbname=test-dev-db', 'root', 'root'); //Conexão
			$this->PDO->setAttribute( \PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION ); //habilitando erros do PDO
		}

        /**
         * TODO render the list
         */
		public function list()
		{
			global $app;
			$sth = $this->PDO->prepare("SELECT * FROM cars");
			$sth->execute();
			$result = $sth->fetchAll(\PDO::FETCH_ASSOC);
			$app->render('default.php',["data"=>$result],200); 
		}

        /**
         * @param $id
         * TODO search a car by ID
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

        /**
         * TODO create a new car
         */
		public function add()
		{
			global $app;
			$data = json_decode($app->request->getBody(), true);
			$data = (sizeof($data)==0)? $_POST : $data;
			$keys = array_keys($data); //Paga as chaves do array

			$sth = $this->PDO->prepare("INSERT INTO cars (".implode(',', $keys).") VALUES (:".implode(",:", $keys).")");
			foreach ($data as $key => $value) {
				$sth ->bindValue(':'.$key,$value);
			}
			$sth->execute();

			$app->render('default.php',["data"=>['id'=>$this->PDO->lastInsertId()]],200); 
		}

        /**
         * @param $id
         * TODO update a car by ID
         */
		public function edit($id)
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

			$app->render('default.php',["data"=>['status'=>$sth->execute()==1]],200); 
		}

        /**
         * @param $id
         * TODO delete a car by ID
         */
		public function delete($id)
		{
			global $app;
			$sth = $this->PDO->prepare("DELETE FROM cars WHERE id = :id");
			$sth ->bindValue(':id',$id);
			$app->render('default.php',["data"=>['status'=>$sth->execute()==1]],200); 
		}
	}
}