<?php
include_once('Connection.php');

	Class ValidationCalificationDoctors extends Connection
	{
		private $ValidationCalificationDoctorId;
    	private $CalificationDoctorId;
		private $Link;
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

		public function setLink($value)
		{
			$this->Link = $value;
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

		public function getLink()
		{
			return $this->Link;
		}

		public function getStatus()
		{
			return $this->Status;
		}

		public function CreateValidationCalificationDoctor()
		{
			try
			{
				$sql = "INSERT INTO ValidationCalificationDoctors
										(CalificationDoctorId, Link, Status)
										VALUES
										($this->CalificationDoctorId, $this->Link, $this->Status)";

				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence($sql);

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

		public function GetAllValidationCalificationDoctors()
		{
			try
			{
				$res = $this->sentence("SET CHARACTER SET utf8");
				$res = $this->sentence("SELECT * FROM ValidationCalificationDoctors");
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

		public function UpdateValidationCalificationDoctor()
		{
			try
			{
				$sql = "UPDATE ValidationCalificationDoctors SET CalificationDoctorId = $this->CalificationDoctorId, Link = $this->Link, Status = $this->Status
										WHERE ValidationCalificationDoctorId = $this->ValidationCalificationDoctorId";

				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence($sql);

				if(mysql_errno() == 0)
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

	}

?>
