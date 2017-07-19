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

		public function CreateCalificationDoctor()
		{
			try
			{
				$sql = "INSERT INTO CalificationDoctors
										(DoctorId, NameUser, CountStars, Email, Comment, DateComment)
										VALUES
										($this->DoctorId, $this->NameUser, $this->CountStars, $this->Email, $this->Comment, 'now()')";

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

		public function GetCalificationDoctorContent()
		{
			try
			{
				$sql = "SELECT * FROM CalificationDoctors WHERE DoctorId = $this->DoctorId";

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

		public function GetCalificationDoctorNameUser($catId)
		{
			try
			{
				$sql = "SELECT Name FROM CalificationDoctors WHERE CalificationDoctorId = $catId";

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

		public function UpdateCalificationDoctor()
		{
			try
			{
				$sql = "UPDATE CalificationDoctors SET NameUser = $this->NameUser
										WHERE CalificationDoctorId = $this->CalificationDoctorId";

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
