<?php
	include_once('Connection.php');

	Class Clients extends Connection
	{
		private $ClientId;
		private $BusinessName;
		private $Identification;
		private $Name;
		private $Email;
		private $MobilePhone;
		private $LocalPhone;
		private $Address;
		private $City;
		private $Address2;
		private $Country;
		private $Discount;
		private $Calification;

		//SET
		public function setClientId($value)
		{
			$this->ClientId = $value;
		}

		public function setBusinessName($value)
		{
			$this->BusinessName = $value;
		}

		public function setIdentification($value)
		{
			$this->Identification = $value;
		}

		public function setName($value)
		{
			$this->Name = $value;
		}

		public function setEmail($value)
		{
			$this->Email = $value;
		}

		public function setMobilePhone($value)
		{
			$this->MobilePhone = $value;
		}

		public function setLocalPhone($value)
		{
			$this->LocalPhone = $value;
		}

		public function setAddress($value)
		{
			$this->Address = $value;
		}

		public function setCity($value)
		{
			$this->City = $value;
		}

		public function setAddress2($value)
		{
			$this->Address2 = $value;
		}

		public function setCountry($value)
		{
			$this->Country = $value;
		}

		public function setDiscount($value)
		{
			$this->Discount = $value;
		}

		public function setCalification($value)
		{
			$this->Calification = $value;
		}

		//GET
		public function getClientId()
		{
			return $this->ClientId;
		}

		public function getBusinessName()
		{
			return $this->BusinessName;
		}

		public function getIdentification()
		{
			return $this->Identification;
		}

		public function getName()
		{
			return $this->Name;
		}

		public function getEmail()
		{
			return $this->Email;
		}

		public function getMobilePhone()
		{
			return $this->MobilePhone;
		}

		public function getLocalPhone()
		{
			return $this->LocalPhone;
		}

		public function getAddress()
		{
			return $this->Address;
		}

		public function getCity()
		{
			return $this->City;
		}

		public function getAddress2()
		{
			return $this->Address2;
		}

		public function getCountry()
		{
			return $this->Country;
		}

		public function getDiscount()
		{
			return $this->Discount;
		}

		public function getCalification()
		{
			return $this->Calification;
		}

		public function CreateClient()
		{
			try
			{
				$sql = "INSERT INTO Clients 
										(BusinessName
										, Identification
										, Name
										, Email
										, MobilePhone
										, LocalPhone
										, Address
										, City
										, Address2
										, Country
										, Discount
										, Calification) 
										VALUES 
										( $this->BusinessName
										, $this->Identification
										, $this->Name
										, $this->Email
										, $this->MobilePhone
										, $this->LocalPhone
										, $this->Address
										, $this->City
										, $this->Address2
										, $this->Country
										, $this->Discount
										, $this->Calification)";

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

		public function GetClientContent()
		{
			try
			{
				$sql = "SELECT * FROM Clients WHERE ClientId = $this->ClientId";

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

		public function ListClients($buscar = NULL)
		{
			if (isset($buscar))
			{
				try
				{
					$result = $this->sentence("SET CHARACTER SET utf8");
					$result = $this->sentence("SELECT
												*
												FROM Clients
												WHERE Name LIKE '%".$buscar."%'
												ORDER BY ClientId ASC
											");

					return $result;
				}
				catch(Exception $e)
				{ 
					echo $e;
				}
			}
			else
			{
				try
				{
					$result = $this->sentence("SET CHARACTER SET utf8");
					$result = $this->sentence("SELECT
												*
												FROM Clients
												ORDER BY ClientId ASC
											");

					return $result;
				}
				catch(Exception $e)
				{ 
					echo $e;
				}
			}
		}

		public function UpdateClient()
		{
			try
			{
				$sql = "UPDATE Clients SET BusinessName = $this->BusinessName
										, Identification = $this->Identification
										, Name = $this->Name
										, Email = $this->Email
										, MobilePhone = $this->MobilePhone
										, LocalPhone = $this->LocalPhone
										, Address = $this->Address
										, City = $this->City
										, Address2 = $this->Address2
										, Country = $this->Country
										, Discount = $this->Discount
										, Calification = $this->Calification
										WHERE ClientId = $this->ClientId";

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

	}

?>