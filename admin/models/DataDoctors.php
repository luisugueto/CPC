<?php
include_once('Connection.php');

	Class DataDoctors extends Connection
	{
			private $DataDoctorId;
			private $DoctorId;
			private $Name;
	    private $Description;

		//SET
		public function setDataDoctorId($value)
		{
			$this->DataDoctorId = $value;
		}

		public function setDoctorId($value)
		{
			$this->DoctorId = $value;
		}

		public function setName($value)
		{
			$this->Name = $value;
		}


		public function setDescription($value)
		{
			$this->Description = $value;
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

		public function CreateDataDoctor()
		{
			try
			{
				$result = $this->connection->prepare("INSERT INTO DataDoctors (DoctorId, Name, Description) VALUES (?, ?, ?)");
				$result->bindParam(1, $DoctorId);
				$result->bindParam(2, $Name);
				$result->bindParam(3, $Description);

				// insertar una fila
				$Name = $this->Name;
				$Description = $this->Description;
				$DoctorId = $this->DoctorId;

				$result->execute();

				if($result->rowCount() > 0)
				{
					return "exito";
				}
				else
				{
					return "fallo";
				}
			} catch(Exception $e){

					echo $e->getMessage() ;
					//send errors to system error reporting

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

		public function GetAllDataDoctorsforDoctor($id)
		{
			try
			{
				$sql = "SELECT * FROM datadoctors WHERE DoctorId = $id";

				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence($sql);

				if($result->rowCount() > 0)
				{
					$fetchResult = $result->fetchAll();
					return $fetchResult;
				}
			}
			catch(Exception $e)
			{
				echo $e;
				return false;
			}
		}

		public function ListDoctors()
		{
			try
			{
				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence("SELECT
											DoctorId
											, Name, SubTitle, Description, PlanId
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
				$sql = "UPDATE Doctors SET Name = $this->Name, SubTitle = $this->SubTitle, Description = $this->Description, PlanId = $this->PlanId
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

		public function lastDoctorId()
		{
			try
			{
				$sql = "SELECT DoctorId FROM Doctors ORDER BY DoctorId DESC LIMIT 1";

				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence($sql);

				if($result->rowCount() > 0)
				{
					$fetchResult = $result->fetch(PDO::FETCH_ASSOC);
					return $fetchResult["DoctorId"];
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
