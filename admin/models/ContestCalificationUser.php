<?php
	include_once('Connection.php');

	Class ContestCalificationUser extends Connection
	{
		private $ContestCalificationUserId;
      	private $CalificationDoctorId;
      	private $NameUser;
      	private $Email;
	    private $Comment;
	    private $DateComment;

		//SET
    	public function setContestCalificationUserId($value)
		{
			$this->ContestCalificationUserId = $value;
		}

		public function setCalificationDoctorId($value)
		{
			$this->CalificationDoctorId = $value;
		}

		public function setNameUser($value)
		{
			$this->NameUser = $value;
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
    	public function getContestCalificationUserId()
		{
			return $this->ContestCalificationUserId;
		}

		public function getCalificationDoctorId()
		{
			return $this->CalificationDoctorId;
		}

		public function getNameUser()
		{
			return $this->NameUser;
		}

		public function getEmail()
		{
			return $this->Email;
		}

		public function getComment()
		{
			return $this->Comment;
		}

		public function CreateContestCalificationUser()
		{
			try
			{
				$sql = "INSERT INTO ContestCalificationUsers
										(CalificationDoctorId, NameUser, Comment, DateComment)
										VALUES
										($this->CalificationDoctorId, $this->NameUser, $this->Comment, NOW())";

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

		public function GetContestCalificationUser()
		{
			try
			{
				$sql = "SELECT * FROM ContestCalificationDoctors WHERE ContestCalificationUserId = '$this->ContestCalificationUserId'";

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

		public function GetContestCalificationUserforCalification($catId)
		{
			try
			{
				$sql = "SELECT * FROM ContestCalificationUsers WHERE CalificationDoctorId = $catId";

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

	}

?>
