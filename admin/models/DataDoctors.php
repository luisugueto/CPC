<?php
include_once('Connection.php');

	Class DataDoctors extends Connection
	{
		private $DataDoctorId;
    	private $DoctorId;
		private $Name;
    	private $Description;
    	private $PlanId;

		//SET
		public function setDataDoctorId($value)
		{
			$this->DataDoctorId = $value;
		}

		public function setDoctorId($value)
		{
			$this->DoctorId = $value;
		}

		public function setDescription($value)
		{
			$this->Description = $value;
		}

		public function setPlanId($value)
		{
			$this->PlanId = $value;
		}

		public function setName($value)
		{
			$this->Name = $value;
		}

		//GET
		public function getDataDoctorId()
		{
			return $this->DataDoctorId;
		}

		public function getDoctorId()
		{
			return $this->DoctorId;
		}

		public function getName()
		{
			return $this->Name;
		}

		public function getDescription()
		{
			return $this->Description;
		}

		public function getPlanId()
		{
			return $this->PlanId;
		}

		public function CreateDataDoctor()
		{
			try
			{
				$sql = "INSERT INTO DataDoctors
										(DoctorId, Name, Description, PlanId)
										VALUES
										($this->DoctorId, $this->Name, $this->Description, $this->PlanId)";

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

		public function GetDataDoctorContent()
		{
			try
			{
				$sql = "SELECT * FROM DataDoctors WHERE DataDoctorId = $this->DataDoctorId";

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

		public function GetDataDoctorName($catId)
		{
			try
			{
				$sql = "SELECT Name FROM DataDoctors WHERE DataDoctorId = $catId";

				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence($sql);

				if($result->rowCount() > 0)
				{
					$fetchResult = $result->fetch(PDO::FETCH_ASSOC);
					return $fetchResult["Name"];
				}
			}
			catch(Exception $e)
			{
				echo $e;
				return false;
			}
		}

		public function GetAllDataDoctors()
		{
			try
			{
				$res = $this->sentence("SET CHARACTER SET utf8");
				$res = $this->sentence("SELECT * FROM DataDoctors");
				return $res;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function ListDataDoctors()
		{
			try
			{
				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence("SELECT
											DataDoctorId
											, Name
											FROM DataDoctors
											ORDER BY Name ASC
										");

				return $result;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function UpdateDataDoctor()
		{
			try
			{
				$sql = "UPDATE DataDoctors SET Name = $this->Name
										WHERE DataDoctorId = $this->DataDoctorId";

				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence($sql);

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

		public function DeleteDataDoctor()
		{
			try
			{
				$result = $this->sentence("DELETE FROM DataDoctors WHERE DataDoctorId = $this->DataDoctorId");

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
