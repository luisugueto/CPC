<?php
	include_once('Connection.php');

	Class ContestCalification extends Connection
	{
		private $ContestCalificationDoctorId;
      	private $CalificationDoctorId;
	    private $Comment;
	    private $DateComment;

		//SET
    	public function setContestCalificationDoctorId($value)
		{
			$this->ContestCalificationDoctorId = $value;
		}

		public function setCalificationDoctorId($value)
		{
			$this->CalificationDoctorId = $value;
		}

		public function setComment($value)
		{
			$this->Comment = $value;
		}

		//GET
    	public function getContestCalificationDoctorId()
		{
			return $this->ContestCalificationDoctorId;
		}

		public function getCalificationDoctorId()
		{
			return $this->CalificationDoctorId;
		}

		public function getComment()
		{
			return $this->Comment;
		}

		public function CreateContestCalificationDoctor()
		{
			try
			{
				$sql = "INSERT INTO ContestCalificationDoctors
										(CalificationDoctorId, Comment, DateComment)
										VALUES
										($this->CalificationDoctorId, $this->Comment, NOW())";

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

		public function GetContestCalificationDoctor()
		{
			try
			{
				$sql = "SELECT * FROM ContestCalificationDoctors WHERE ContestCalificationDoctorId = '$this->ContestCalificationDoctorId'";

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

		public function GetUnionCommentsUserWithDoctor($catId)
		{
			try
			{
				$sql = "SELECT CalificationDoctorId, Comment, DateComment, NameUser, Email FROM ContestCalificationUsers WHERE CalificationDoctorId = $catId UNION SELECT CalificationDoctorId, Comment, DateComment, null as NameUser, null as Email FROM ContestCalificationDoctors WHERE CalificationDoctorId = $catId ORDER BY DateComment ASC";

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

		public function GetContestCalificationDoctorforCalification($catId)
		{
			try
			{
				$sql = "SELECT * FROM ContestCalificationDoctors WHERE CalificationDoctorId = $catId";

				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence($sql);

				if($result->rowCount() > 0)
				{
					$fetchResult = $result->fetch(PDO::FETCH_ASSOC);
					return $fetchResult["Comment"];
				}
			}
			catch(Exception $e)
			{
				echo $e;
				return false;
			}
		}

		public function UpdateContestCalificationDoctor()
		{
			try
			{
				$sql = "UPDATE ContestCalificationDoctors SET Comment = $this->Comment
										WHERE ContestCalificationDoctorId = $this->ContestCalificationDoctorId";

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

		public function DeleteContestCalificationDoctor()
		{
			try
			{
				$result = $this->sentence("DELETE FROM ContestCalificationDoctors WHERE ContestCalificationDoctorId = $this->ContestCalificationDoctorId");

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
