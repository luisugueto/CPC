<?php
	include_once('Connection.php');

	Class CalificationDoctors extends Connection
	{
		private $CalificationDoctorId;
    	private $DoctorId;
		private $NameUser;
	    private $CountStars;
	    private $Email;
	    private $Comment;
	    private $DateComment;
		private $Status;
		private $StatusDoctor;

		//SET
		public function setCalificationDoctorId($value)
		{
			$this->CalificationDoctorId = $value;
		}

		public function setDoctorId($value)
		{
			$this->DoctorId = $value;
		}

		public function setNameUser($value)
		{
			$this->NameUser = $value;
		}

		public function setCountStars($value)
		{
			$this->CountStars = $value;
		}

		public function setEmail($value)
		{
			$this->Email = $value;
		}

		public function setComment($value)
		{
			$this->Comment = $value;
		}

		public function setDateComment($value)
		{
			$this->DateComment = $value;
		}

		public function setStatus($value)
		{
			$this->Status = $value;
		}

		public function setStatusDoctor($value)
		{
			$this->StatusDoctor = $value;
		}

		//GET
		public function getCalificationDoctorId()
		{
			return $this->CalificationDoctorId;
		}

		public function getDoctorId()
		{
			return $this->DoctorId;
		}

		public function getNameUser()
		{
			return $this->NameUser;
		}

		public function getCountStars()
		{
			return $this->CountStars;
		}

		public function getEmail()
		{
			return $this->Email;
		}

		public function getComment()
		{
			return $this->Comment;
		}

		public function getDateComment()
		{
			return $this->DateComment;
		}

		public function getStatus()
		{
			return $this->Status;
		}

		public function getStatusDoctor()
		{
			return $this->StatusDoctor;
		}

		public function CreateCalificationDoctor()
		{
			try
			{
				if($this->StatusDoctor){
					$sql = "INSERT INTO CalificationDoctors
					(DoctorId, NameUser, CountStars, Email, Comment, DateComment, Status, StatusDoctor)
					VALUES
					($this->DoctorId, $this->NameUser, $this->CountStars, $this->Email, $this->Comment, NOW(), 'Inactive', 'Active')";
				}
				else{
					$sql = "INSERT INTO CalificationDoctors
					(DoctorId, NameUser, CountStars, Email, Comment, DateComment, Status, StatusDoctor)
					VALUES
					($this->DoctorId, $this->NameUser, $this->CountStars, $this->Email, $this->Comment, NOW(), 'Inactive', 'Inactive')";
				}

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

		public function InsertCalificationDoctor()
		{
			try
			{
				$sql = "INSERT INTO CalificationDoctors
				(DoctorId, NameUser, CountStars, Email, Comment, DateComment, Status, StatusDoctor)
				VALUES
				($this->DoctorId, '$this->NameUser', $this->CountStars, '$this->Email', '$this->Comment', '$this->DateComment', '$this->Status', '$this->StatusDoctor')";

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

		public function numCalificationsForDoctor()
		{
			try
			{
				$sql = "SELECT * FROM CalificationDoctors WHERE DoctorId = $this->DoctorId";

				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence($sql);

				return $result->rowCount();
			}
			catch(Exception $e)
			{
				echo $e;
				return false;
			}
		}

		public function numCalificationsTotalForDoctor($number)
		{
			try
			{
				$sql = "SELECT * FROM CalificationDoctors WHERE DoctorId = $this->DoctorId AND CountStars = $number";

				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence($sql);

				return $result->rowCount();
			}
			catch(Exception $e)
			{
				echo $e;
				return false;
			}
		}

		public function GetLastCalifications()
		{
			try
			{
				$sql = "SELECT CD.*, D.*, PC.* FROM CalificationDoctors CD INNER JOIN Doctors D ON D.DoctorId = CD.DoctorID LEFT JOIN PlanClients PC ON PC.DoctorId = CD.DoctorId WHERE PC.Status = 'Active' ORDER BY CD.CalificationDoctorId DESC LIMIT 5";

				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence($sql);

				return $result;
			}
			catch(Exception $e)
			{
				echo $e;
				return false;
			}
		}

		public function GetCalificationDoctorContent()
		{
			try
			{
				$sql = "SELECT * FROM CalificationDoctors WHERE DoctorId = $this->DoctorId";

				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence($sql);

				return $result;
			}
			catch(Exception $e)
			{
				echo $e;
				return false;
			}
		}

		public function GetCalificationDoctor()
		{
			try
			{
				$sql = "SELECT * FROM CalificationDoctors WHERE CalificationDoctorId = '$this->CalificationDoctorId'";

				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence($sql);

				if($result->rowCount() > 0)
				{
					$fetchResults = $result->fetch(PDO::FETCH_ASSOC);
					return $fetchResults;
				}
			}
			catch(Exception $e)
			{
				echo $e;
				return false;
			}
		}

		public function GetCommentsForDoctor()
		{
			try
			{
				$sql = "SELECT * FROM CalificationDoctors WHERE DoctorId = $this->DoctorId";

				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence($sql);

				return $result;
			}
			catch(Exception $e)
			{
				echo $e;
				return false;
			}
		}

		public function GetCalificationsForDoctorCorreoAndCodigo()
		{
			try
			{
				$sql = "SELECT * FROM CalificationDoctors WHERE DoctorId = $this->DoctorId AND Status = 'Active' AND StatusDoctor = 'Active'";

				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence($sql);

				return $result;
			}
			catch(Exception $e)
			{
				echo $e;
				return false;
			}
		}

		public function GetCalificationsForDoctorCorreo()
		{
			try
			{
				$sql = "SELECT * FROM CalificationDoctors WHERE DoctorId = $this->DoctorId AND Status = 'Active' AND StatusDoctor = 'Inactive'";

				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence($sql);

				return $result;
			}
			catch(Exception $e)
			{
				echo $e;
				return false;
			}
		}

		public function GetCalificationsForDoctorCodigo()
		{
			try
			{
				$sql = "SELECT * FROM CalificationDoctors WHERE DoctorId = $this->DoctorId AND StatusDoctor = 'Active' AND Status = 'Inactive'";

				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence($sql);

				return $result;
			}
			catch(Exception $e)
			{
				echo $e;
				return false;
			}
		}

		public function GetCalificationsForDoctorNoVerificadas()
		{
			try
			{
				$sql = "SELECT * FROM CalificationDoctors WHERE DoctorId = $this->DoctorId AND StatusDoctor = 'Inactive' AND Status = 'Inactive'";

				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence($sql);

				return $result;
			}
			catch(Exception $e)
			{
				echo $e;
				return false;
			}
		}

		public function GetStatusCalification($catId)
		{
			try
			{
				$sql = "SELECT * FROM CalificationDoctors WHERE CalificationDoctorId = $catId";

				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence($sql);

				if($result->rowCount() > 0)
				{
					$fetchResult = $result->fetch(PDO::FETCH_ASSOC);
					return $fetchResult["Status"];
				}
			}
			catch(Exception $e)
			{
				echo $e;
				return false;
			}
		}

		public function GetStatusDoctorCalification($catId)
		{
			try
			{
				$sql = "SELECT * FROM CalificationDoctors WHERE CalificationDoctorId = $catId";

				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence($sql);

				if($result->rowCount() > 0)
				{
					$fetchResult = $result->fetch(PDO::FETCH_ASSOC);
					return $fetchResult["StatusDoctor"];
				}
			}
			catch(Exception $e)
			{
				echo $e;
				return false;
			}
		}

		public function GetCalificationforId($catId)
		{
			try
			{
				$sql = "SELECT * FROM CalificationDoctors WHERE CalificationDoctorId = $catId";

				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence($sql);

				if($result->rowCount() > 0)
				{
					$fetchResult = $result->fetch(PDO::FETCH_ASSOC);
					return $fetchResult["NameUser"];
				}
			}
			catch(Exception $e)
			{
				echo $e;
				return false;
			}
		}

		public function verifyContestCalification($catId)
		{
			try
			{
				$sql = "SELECT c.*, c.CalificationDoctorId as calificationId, ct.* FROM CalificationDoctors as c INNER JOIN ContestCalificationDoctors as ct ON c.CalificationDoctorId=ct.CalificationDoctorId WHERE c.CalificationDoctorId = $catId";

				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence($sql);

				if($result->rowCount() > 0)
					return true;
				else
					return false;

			}
			catch(Exception $e)
			{
				echo $e;
				return false;
			}
		}

		public function GetAllCalificationDoctors()
		{
			try
			{
				$res = $this->sentence("SET CHARACTER SET utf8");
				$res = $this->sentence("SELECT * FROM CalificationDoctors");
				return $res;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function ListCalificationDoctors()
		{
			try
			{
				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence("SELECT
											CalificationDoctorId
											, NameUser
											FROM CalificationDoctors
											ORDER BY NameUser ASC
										");

				return $result;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function UpdateCalificationDoctor($id)
		{
			try
			{
				$sql = "UPDATE CalificationDoctors SET Status = 'Active'
										WHERE CalificationDoctorId = $id"; 

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

		public function lastCalificationDoctorId()
		{
			try
			{
				$sql = "SELECT CalificationDoctorId FROM CalificationDoctors ORDER BY CalificationDoctorId DESC LIMIT 1";

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

		public function DeleteCalificationDoctor()
		{
			try
			{
				$result = $this->sentence("DELETE FROM CalificationDoctors WHERE CalificationDoctorId = $this->CalificationDoctorId");

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
