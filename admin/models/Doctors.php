<?php
	include_once('Connection.php');

	Class Doctors extends Connection
	{
		private $DoctorId;
		private $ClientId;
		private $Name;
	    private $SubTitle;
	    private $Description;
		private $PlanId;
		private $Email;
		private $Logo;
		private $Code;

		//SET
		public function setDoctorId($value)
		{
			$this->DoctorId = $value;
		}

		public function setClientId($value)
		{
			$this->ClientId = $value;
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

		public function setPlanId($value)
		{
			$this->PlanId = $value;
		}

		public function setEmail($value)
		{
			$this->Email = $value;
		}

		public function setLogo($value)
		{
			$this->Logo = $value;
		}

		public function setCode($value)
		{
			$this->Code = $value;
		}


		//GET
		public function getDoctorId()
		{
			return $this->DoctorId;
		}

		public function getClientId()
		{
			return $this->ClientId;
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

		public function getPlanId()
		{
			return $this->PlanId;
		}

		public function getEmail()
		{
			return $this->Email;
		}

		public function getLogo()
		{
			return $this->Logo;
		}

		public function getCode()
		{
			return $this->Code;
		}

		public function CreateDoctor()
		{
			try
			{
				$sql = "INSERT INTO Doctors
										(ClientId, Name, Subtitle, Description, PlanId, Email, Code)
										VALUES
										($this->ClientId, $this->Name, $this->SubTitle, $this->Description, $this->PlanId, $this->Email, $this->Code)";

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

		public function GetDoctorForName()
		{
			try
			{
				$sql = "SELECT * FROM Doctors WHERE Name = '$this->Name'";

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

		public function GetLastDoctors()
		{
			try
			{
				$res = $this->sentence("SET CHARACTER SET utf8");
				$res = $this->sentence("SELECT * FROM Doctors ORDER BY DoctorId DESC LIMIT 4");
				return $res;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function ListDoctorsBySubCategory($id)
		{
			try
			{
				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence("SELECT
											D.*
											FROM ProceduresDoctor PD
											INNER JOIN Doctors D ON D.DoctorId = PD.DoctorId
											WHERE PD.SubCategoryId = $id
										");

				return $result;
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
											, Name, SubTitle, Description, PlanId, Logo
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

		public function ListDoctorsForClientwithPlan()
		{
			try
			{
				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence("SELECT *	FROM Doctors as d INNER JOIN PlanClients as pl ON pl.DoctorId = d.DoctorId WHERE ClientId = $this->ClientId	ORDER BY Name ASC");

				return $result;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function GetTotalDoctors()
		{
			try
			{
				$res = $this->sentence("SET CHARACTER SET utf8");
				$res = $this->sentence("SELECT COUNT(*) AS Total FROM Doctors as d INNER JOIN PlanClients as pl ON pl.DoctorId = d.DoctorId ORDER BY Name ASC");

				$fetchres = $res->fetch(PDO::FETCH_ASSOC);
				return $fetchres["Total"];
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function ListDoctorsForClientwithPlanPagination($page, $num)
		{
			try
			{
				$begin = ($page - 1) * $num;
				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence("SELECT *	FROM Doctors as d INNER JOIN PlanClients as pl ON pl.DoctorId = d.DoctorId ORDER BY Name ASC LIMIT $begin, $num");

				return $result;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function ListDoctorswithPlan()
		{
			try
			{
				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence("SELECT * FROM Doctors as d INNER JOIN PlanClients as pl ON pl.DoctorId = d.DoctorId");

				return $result;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function numDoctorswithPlan()
		{
			try
			{
				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence("SELECT *	FROM Doctors as d INNER JOIN PlanClients as pl ON pl.DoctorId = d.DoctorId");

				return $result->rowCount();
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function numDoctorsForClientwithPlan()
		{
			try
			{
				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence("SELECT *	FROM Doctors as d INNER JOIN PlanClients as pl ON pl.DoctorId = d.DoctorId WHERE ClientId = $this->ClientId	ORDER BY Name ASC");

				return $result->rowCount();
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function ListDoctorsForClient()
		{
			try
			{
				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence("SELECT *	FROM Doctors WHERE ClientId = $this->ClientId	ORDER BY Name ASC");

				return $result;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function existsDoctor()
		{
			try
			{
				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence("SELECT *	FROM Doctors as d INNER JOIN PlanClients as pl ON pl.DoctorId = d.DoctorId WHERE d.DoctorId = $this->DoctorId	ORDER BY Name ASC");

			 	if($result->rowCount() > 0)
					return true;
				else
					return false;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function ListDoctorsName()
		{
			try
			{
				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence("SELECT dr.Name as DoctorName, dr.SubTitle, pl.DoctorId as plDoctorId, pl.* FROM Doctors as dr INNER JOIN PlanClients as pl ON pl.DoctorId = dr.DoctorId WHERE pl.status = 'Active' ORDER BY Name ASC
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
				$sql = "UPDATE Doctors SET Name = $this->Name, SubTitle = $this->SubTitle, PlanId = '$this->PlanId', Email = $this->Email, Code = $this->Code
										WHERE DoctorId = $this->DoctorId";

				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence($sql);

				return "exito";
			}
			catch(Exception $e)
			{
				echo $e;
				return false;
			}
		}

		public function UpdateDoctorDescription()
		{
			try
			{
				$sql = "UPDATE Doctors SET Description = $this->Description
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

		public function UpdateClient()
		{
			try
			{
				$sql = "UPDATE Doctors SET ClientId = $this->ClientId WHERE DoctorId = $this->DoctorId";

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

		public function UpdateDoctorLogo()
		{
			try
			{
				$sql = "UPDATE Doctors SET Logo = '$this->Logo'
										WHERE DoctorId = $this->DoctorId";

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

	}

?>
