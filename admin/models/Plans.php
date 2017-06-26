<?php
include_once('Connection.php');

	Class Plans extends Connection
	{
		private $PlanId;
		private $Name;
	    private $Price;
	    private $Characteristic;

		//SET
		public function setPlanId($value)
		{
			$this->PlanId = $value;
		}

		public function setName($value)
		{
			$this->Name = $value;
		}

		public function setPrice($value)
		{
			$this->Price = $value;
		}

		public function setCharacteristic($value)
		{
			$this->Characteristic = $value;
		}

		//GET
		public function getPlanId()
		{
			return $this->PlanId;
		}

		public function getName()
		{
			return $this->Name;
		}

		public function getPrice()
		{
			return $this->Price;
		}

		public function getCharacteristic()
		{
			return $this->Characteristic;
		}

		public function CreatePlan()
		{
			try
			{
				$sql = "INSERT INTO Plans
										(Name, Price, Characteristic)
										VALUES
										($this->Name, $this->Price, $this->Characteristic)";

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

		public function GetPlanContent()
		{
			try
			{
				$sql = "SELECT * FROM Plans WHERE PlanId = $this->PlanId";

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

		public function GetPlanName($catId)
		{
			try
			{
				$sql = "SELECT Name FROM Plans WHERE PlanId = $catId";

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

		public function GetAllPlans()
		{
			try
			{
				$res = $this->sentence("SET CHARACTER SET utf8");
				$res = $this->sentence("SELECT * FROM Plans");
				return $res;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function ListPlans()
		{
			try
			{
				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence("SELECT
											PlanId
											, Name
											FROM Plans
											ORDER BY Name ASC
										");

				return $result;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function UpdatePlan()
		{
			try
			{
				$sql = "UPDATE plans SET Name = $this->Name
										WHERE PlanId = $this->PlanId";

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

		public function DeletePlan()
		{
			try
			{
				$result = $this->sentence("DELETE FROM Plans WHERE PlanId = $this->PlanId");

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
