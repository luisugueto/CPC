<?php
include_once('Connection.php');

  	Class PlanClients extends Connection
	{
		private $PlanClientId;
    	private $ClientId;
		private $Status;

		//SET
		public function setPlanClientId($value)
		{
			$this->PlanClientId = $value;
		}

		public function setClientId($value)
		{
			$this->ClientId = $value;
		}

		public function setStatus($value)
		{
			$this->Status = $value;
		}

		//GET
		public function getPlanClientId()
		{
			return $this->PlanClientId;
		}

		public function getClientId()
		{
			return $this->ClientId;
		}

		public function getStatus()
		{
			return $this->Status;
		}

		public function CreatePlanClient()
		{
			try
			{
				$sql = "INSERT INTO PlanClients
										(ClientId, Status)
										VALUES
										($this->ClientId, $this->Status)";

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

		public function GetPlanClientContent()
		{
			try
			{
				$sql = "SELECT * FROM PlanClients WHERE PlanClientId = $this->PlanClientId";

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

		public function GetPlanClientStatus($catId)
		{
			try
			{
				$sql = "SELECT Status FROM PlanClients WHERE PlanClientId = $catId";

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

		public function GetAllPlanClients()
		{
			try
			{
				$res = $this->sentence("SET CHARACTER SET utf8");
				$res = $this->sentence("SELECT * FROM PlanClients");
				return $res;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function ListPlanClients()
		{
			try
			{
				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence("SELECT
											PlanClientId
											, Name
											FROM PlanClients
											ORDER BY Name ASC
										");

				return $result;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function UpdatePlanClient()
		{
			try
			{
				$sql = "UPDATE PlanClients SET Status = $this->Status
										WHERE PlanClientId = $this->PlanClientId";

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

		public function DeletePlanClient()
		{
			try
			{
				$result = $this->sentence("DELETE FROM PlanClients WHERE PlanClientId = $this->PlanClientId");

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
