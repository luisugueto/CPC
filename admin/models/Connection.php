<?php
	class Connection
	{
		//Produccion
//		protected $hostname = "localhost";
//		protected $dbusrname = "";
//		protected $dbpassword = "";
//		protected $dbname = "";

		//Local
		protected $hostname = "localhost";
 		protected $dbusrname = "root";
		protected $dbpassword = "";
		protected $dbname = "cpc_db";

		public function __construct()
		{
			try
			{
				$this->connection = new PDO("mysql:host=$this->hostname; dbname=$this->dbname", $this->dbusrname, $this->dbpassword);
				$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}
			catch (PDOException $e)
			{
				$this->connection = null;
				die($e->getMessage());
			}
		}

		public function sentence($query)
		{
			$stmt = $this->connection->prepare($query);
			if($stmt)
			{
				$stmt->execute();
				return $stmt;
			}
			else
			{
				return self::get_error();
			}
		}

		public function get_error()
		{
			$this->connection->errorInfo();
		}

		public function __destruct()
		{
			$this->connection = null;
		}
	}
?>