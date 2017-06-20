<?php
include_once('Connection.php');

	Class Users extends Connection
	{
		private $UserId;
		private $Name;
		private $Email;
		private $Password;
		private $Phone;
		private $Description;
		private $Permissions;

		//SET
		public function setUserId($value)
		{
			$this->UserId = $value;
		}

		public function setName($value)
		{
			$this->Name = $value;
		}

		public function setEmail($value)
		{
			$this->Email = $value;
		}

		public function setPassword($value)
		{
			$this->Password = $value;
		}

		public function setPhone($value)
		{
			$this->Phone = $value;
		}

		public function setDescription($value)
		{
			$this->Description = $value;
		}

		public function setPermissions($value)
		{
			$this->Permissions = $value;
		}

		//GET
		public function getUserId()
		{
			return $this->UserId;
		}

		public function getName()
		{
			return $this->Name;
		}
		
		public function getEmail()
		{
			return $this->Email;
		}

		public function getPassword()
		{
			return $this->Password;
		}

		public function getPhone()
		{
			return $this->Phone;
		}

		public function getDescription()
		{
			return $this->Description;
		}

		public function getPermissions()
		{
			return $this->Permissions;
		}

		public function CreateUser()
		{
			try
			{
				$sql = "INSERT INTO Users 
										(Name
										, Email
										, Password
										, Phone
										, Description
										, Permissions) 
										VALUES 
										($this->Name
										, $this->Email
										, '$this->Password'
										, $this->Phone
										, $this->Description
										, '$this->Permissions')";

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

		public function Login()
		{
			try
			{
				$res = $this->sentence("SELECT * FROM Users WHERE Email = '$this->Email' AND Password = '$this->Password'");

				if($res->rowCount() > 0)
				{
					$fetchResult = $res->fetch(PDO::FETCH_ASSOC);
					
					$this->setName($fetchResult["Name"]);
					$this->setUserId($fetchResult["UserId"]);

					return true;
					
				}
				else
				{
					return false;
				}
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function GetUserContent()
		{
			try
			{
				$sql = "SELECT * FROM Users WHERE UserId = $this->UserId";

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

		public function VerifyMail()
		{
			try
			{
				$sql = "SELECT * FROM Users WHERE Email = '$this->Email'";

				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence($sql);

				if($result->rowCount() > 0)
				{	
					$fetchResult = $result->fetch(PDO::FETCH_ASSOC);
					return $fetchResult["Password"];
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

		public function LastUserId()
		{
			try
			{
				$sql = "SELECT * FROM Users ORDER BY UserId DESC LIMIT 1";
				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence($sql);

				if($result->rowCount() > 0)
				{	
					$fetchResult = $result->fetch(PDO::FETCH_ASSOC);
					return $fetchResult["UserId"];
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

		public function ListUsers()
		{
			try
			{
				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence("SELECT
											*
											FROM Users
											ORDER BY UserId ASC
										");

				return $result;
			}
			catch(Exception $e)
			{ 
				echo $e;
			}
		}

		public function UpdateUser()
		{
			try
			{
				$sql = "UPDATE Users SET Name = $this->Name
										, Email = $this->Email
										, Password = '$this->Password'
										, Phone = $this->Phone
										, Description = $this->Description
										, Permissions = '$this->Permissions'
										WHERE UserId = $this->UserId";

				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence($sql);

				if($result->rowCount() > 0)
				{
					return "exito";
				}
				else
				{
					return "error";
				}
			}

			catch(Exception $e)
			{
				echo $e;
				return false;
			}
		}

		public function UpdatePassword($pass)
		{
			try
			{
				$sql = "UPDATE Users SET Password = '$this->Password'
										WHERE UserId = $this->UserId AND Password = '$pass'";

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

		public function ShuffleNewPassword()
		{
			try
			{
				$sql = "UPDATE Users SET Password = '$this->Password' WHERE Email = '$this->Email'";

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

		public function DeleteUser()
		{
			try
			{
				$result = $this->sentence("DELETE FROM Users WHERE UserId = $this->UserId");

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

		public function DeleteUserFromRestaurant()
		{
			try
			{
				$result = $this->sentence("DELETE FROM RestaurantUsers WHERE UserId = $this->UserId");

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