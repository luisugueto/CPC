<?php
	include_once('Connection.php');

	Class UserDoctors extends Connection
	{
		private $UserDoctorsId;
		private $UserId;
	    private $DoctorId;

		//SET
		public function setUserDoctorsId($value)
		{
			$this->UserDoctorsId = $value;
		}

		public function setUserId($value)
		{
			$this->UserId = $value;
		}

		public function setDoctorId($value)
		{
			$this->DoctorId = $value;
		}

		//GET
		public function getUserDoctorsId()
		{
			return $this->UserDoctorsId;
		}

		public function getUserId()
		{
			return $this->UserId;
		}

		public function getDoctorId()
		{
			return $this->DoctorId;
		}

		public function CreateUserDoctor()
		{
			try
			{
				$sql = "INSERT INTO UserDoctors
										(UserId, DoctorId)
										VALUES
										($this->UserId, $this->DoctorId)";

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

    	public function ListUserForDoctors()
		{
			try
			{
				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence("SELECT ud.*, u.*	FROM UserDoctors as ud INNER JOIN Users as u ON u.UserId = ud.UserId WHERE ud.DoctorId = $this->DoctorId");

				return $result;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function verifyUserinDoctor()
		{
			try
			{
				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence("SELECT ud.*, u.*	FROM UserDoctors as ud INNER JOIN Users as u ON u.UserId = ud.UserId WHERE u.UserId = $this->UserId");

				return $result->rowCount();
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function UserinDoctor()
		{
			try
			{
				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence("SELECT ud.*, u.*	FROM UserDoctors as ud INNER JOIN Users as u ON u.UserId = ud.UserId WHERE u.UserId = $this->UserId");

				if($result->rowCount() > 0)
				{
					$fetchResult = $result->fetch(PDO::FETCH_ASSOC);
					return $fetchResult;
				}
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function GetAllUserDoctors()
		{
			try
			{
				$res = $this->sentence("SET CHARACTER SET utf8");
				$res = $this->sentence("SELECT * FROM UserDoctors");
				return $res;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}


		public function UpdateUserDoctors()
		{
			try
			{
				$sql = "UPDATE UserDoctors SET UserId = $this->UserId, DoctorId = $this->DoctorId
										WHERE UserDoctorsId = $this->UserDoctorsId";

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

		public function DeleteUserDoctors()
		{
			try
			{
				$result = $this->sentence("DELETE FROM UserDoctors WHERE UserDoctorsId = $this->UserDoctorsId");

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
