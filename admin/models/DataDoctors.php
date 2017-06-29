<?php
include_once('Connection.php');

	Class DataDoctors extends Connection
	{
    	private $DataId;
		private $DoctorId;
		private $Name;
    	private $Description;

		//SET
		public function setDataId($value)
		{
			$this->DataId = $value;
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
		public function getDataId()
		{
			return $this->DataId;
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

		public function CreateData()
		{
			try
			{
				$result = $this->connection->prepare("INSERT INTO data (DoctorId, Name, Description) VALUES (?, ?, ?)");
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
					}
		}

		public function GetDataforDoctor($id)
		{
			try
			{
				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence("SELECT
											DataDoctorId,DoctorId, Name, Description
											FROM data WHERE DoctorId = $id
										");

				return $result;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function GetDoctorName($catId)
		{
			try
			{
				$sql = "SELECT Name FROM data WHERE DoctorId = $catId";

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

		public function GetAllData()
		{
			try
			{
				$res = $this->sentence("SET CHARACTER SET utf8");
				$res = $this->sentence("SELECT * FROM Data");
				return $res;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function ListData()
		{
			try
			{
				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence("SELECT
											DataId
											, DoctorId
											FROM Data
											ORDER BY DoctorId ASC
										");

				return $result;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function UpdateData()
		{
			try
			{
				$sql = "UPDATE Data SET DoctorId = $this->DoctorId, Name = $this->Name, Description = $this->Description
										WHERE DataId = $this->DataId";

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

		public function DeleteData($id)
		{
			try
			{
				$result = $this->connection->prepare("DELETE FROM data WHERE DataDoctorId = ?");
				$result->bindParam(1, $DataDoctorId);

				// insertar una fila
				$DataDoctorId = $id;

				$result->execute();


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
