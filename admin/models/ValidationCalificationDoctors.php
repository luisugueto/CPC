<?php
	include_once('Connection.php');

	Class ValidationCalificationDoctors extends Connection
	{
		private $ValidationCalificationDoctorId;
    	private $CalificationDoctorId;
		private $Code;
    	private $Status;

		//SET
		public function setValidationCalificationDoctorId($value)
		{
			$this->ValidationCalificationDoctorId = $value;
		}

		public function setCalificationDoctorId($value)
		{
			$this->CalificationDoctorId = $value;
		}

		public function setCode($value)
		{
			$this->Code = $value;
		}

		public function setStatus($value)
		{
			$this->Status = $value;
		}

		//GET
		public function getValidationCalificationDoctorId()
		{
			return $this->ValidationCalificationDoctorId;
		}

		public function getCalificationDoctorId()
		{
			return $this->CalificationDoctorId;
		}

		public function getCode()
		{
			return $this->Code;
		}

		public function getStatus()
		{
			return $this->Status;
		}

		public function CreateValidationCalificationDoctor()
		{
			try
			{
				$result = $this->connection->prepare("INSERT INTO ValidationCalificationDoctors (CalificationDoctorId, Code) VALUES (?, ?)");
				$result->bindParam(1, $CalificationDoctorId);
				$result->bindParam(2, $Code);

				// insertar una fila
				$Code = $this->Code;
				$CalificationDoctorId = $this->CalificationDoctorId;

				$result->execute();

				if($result->rowCount() > 0)
				{
					return "exito";
				}
				else
				{
					return "fallo";
				}
			}

			catch(Exception $e)
			{
				echo $e;
				return false;
			}
		}

		public function GetValidationCalificationDoctorContent()
		{
			try
			{
				$sql = "SELECT * FROM ValidationCalificationDoctors WHERE ValidationCalificationDoctorId = $this->ValidationCalificationDoctorId";

				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence($sql);

				if($result->rowCount() > 0)
				{
					$fetchResult = $result->fetch(PDO::FETCH_ASSOC);
					return $fetchResult;
				}
			}
			catch(Exception $e)
			{
				echo $e;
				return false;
			}
		}

		public function GetValidationCalificationDoctorCalificationDoctorId($catId)
		{
			try
			{
				$sql = "SELECT CalificationDoctorId FROM ValidationCalificationDoctors WHERE ValidationCalificationDoctorId = $catId";

				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence($sql);

				if($result->rowCount() > 0)
				{
					$fetchResult = $result->fetch(PDO::FETCH_ASSOC);
					return $fetchResult["CalificationDoctorId"];
				}
			}
			catch(Exception $e)
			{
				echo $e;
				return false;
			}
		}

		public function GetCalificationDoctorIdForCode($catId)
		{
			try
			{
				$sql = "SELECT * FROM ValidationCalificationDoctors WHERE `Code` = '$catId'";

				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence($sql);

				if($result->rowCount() > 0)
				{
					$fetchResult = $result->fetch(PDO::FETCH_ASSOC);
					return $fetchResult["CalificationDoctorId"];
				} 
			}
			catch(Exception $e)
			{
				echo $e;
				return false;
			}
		}

		public function GetAllValidationCalificationDoctors()
		{
			try
			{
				$res = $this->sentence("SET CHARACTER SET utf8");
				$res = $this->sentence("SELECT * FROM ValidationCalificationDoctors ORDER BY ValidationCalificationDoctorId ASC");
				return $res;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function ListValidationCalificationDoctors()
		{
			try
			{
				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence("SELECT
											ValidationCalificationDoctorId
											, CalificationDoctorId
											FROM ValidationCalificationDoctors
											ORDER BY CalificationDoctorId ASC
										");

				return $result;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function UpdateValidationCalificationDoctor($code)
		{
			try
			{
				$result = $this->connection->prepare("UPDATE ValidationCalificationDoctors SET Status = 'Active' WHERE Code = :code");
				$result->bindParam(':code', $code);

				$result->execute();
				$query = $result->rowCount() ? true : false;
				if($query)
				{
					return "exito";
				}
				else
				{
					return "fallo";
				}
			}

			catch(Exception $e)
			{
				echo $e;
				return false;
			}
		}

		public function DeleteValidationCalificationDoctor()
		{
			try
			{
				$result = $this->sentence("DELETE FROM ValidationCalificationDoctors WHERE ValidationCalificationDoctorId = $this->ValidationCalificationDoctorId");

				if($result->rowCount() > 0)
				{
					return "success";
				}
				else
				{
					return "fallo";
				}
			}

			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function getValidationId($code)
		{
			try
			{
				$sql = "SELECT CalificationDoctorId FROM ValidationCalificationDoctors WHERE Code = $code";

				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence($sql);

				if($result->rowCount() > 0)
				{
					$fetchResult = $result->fetch(PDO::FETCH_ASSOC);
					return $fetchResult["CalificationDoctorId"];
				}
			}
			catch(Exception $e)
			{
				echo $e;
				return false;
			}
		}

	}

?>
