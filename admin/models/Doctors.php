<?php
include_once('Connection.php');

	Class Doctors extends Connection
	{
		private $DoctorId;
		private $Name;
	    private $SubTitle;
	    private $Description;
	    private $CodeQR;

		//SET
		public function setDoctorId($value)
		{
			$this->DoctorId = $value;
		}

		public function setName($value)
		{
			$this->Name = $value;
		}

		public function setSubTitle($value)
		{
			$this->SubTitle = $value;
		}

		public function setDescription($value)
		{
			$this->Description = $value;
		}

		public function setCodeQR($value)
		{
			$this->CodeQR = $value;
		}

		//GET
		public function getDoctorId()
		{
			return $this->DoctorId;
		}

		public function getName()
		{
			return $this->Name;
		}

		public function getSubTitle()
		{
			return $this->SubTitle;
		}

		public function getDescription()
		{
			return $this->Description;
		}

		public function getCodeQR()
		{
			return $this->CodeQR;
		}

		public function CreateDoctor()
		{
			try
			{
				$sql = "INSERT INTO Doctors
										(Name, Subtitle, Description, CodeQR)
										VALUES
										($this->Name, $this->SubTitle, $this->Description, $this->CodeQR)";

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

		public function GetDoctorContent()
		{
			try
			{
				$sql = "SELECT * FROM Doctors WHERE DoctorId = $this->DoctorId";

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

		public function GetDoctorName($catId)
		{
			try
			{
				$sql = "SELECT Name FROM Doctors WHERE DoctorId = $catId";

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

		public function GetAllDoctors()
		{
			try
			{
				$res = $this->sentence("SET CHARACTER SET utf8");
				$res = $this->sentence("SELECT * FROM Doctors");
				return $res;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function ListDoctors()
		{
			try
			{
				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence("SELECT
											DoctorId
											, Name
											FROM Doctors
											ORDER BY Name ASC
										");

				return $result;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function UpdateDoctor()
		{
			try
			{
				$sql = "UPDATE Doctors SET Name = $this->Name
										WHERE DoctorId = $this->DoctorId";

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

		public function DeleteDoctor()
		{
			try
			{
				$result = $this->sentence("DELETE FROM Doctors WHERE DoctorId = $this->DoctorId");

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
