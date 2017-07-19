<?php
include_once('Connection.php');

	Class Publicitys extends Connection
	{
			private $PublicityId;
			private $Content;

		//SET
		public function setPublicityId($value)
		{
			$this->PublicityId = $value;
		}

		public function setContent($value)
		{
			$this->Content = $value;
		}

		//GET
		public function getPublicityId()
		{
			return $this->PublicityId;
		}

		public function getContent()
		{
			return $this->Content;
		}

		public function CreatePublicity()
		{

			try
			{
				$sql = "INSERT INTO publicitys
										(Content)
										VALUES
										($this->Content)";

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

		public function GetPublicityContent()
		{
			try
			{
				$sql = "SELECT PublicityId, Content FROM publicitys WHERE PublicityId = $this->PublicityId";

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

		public function GetAllPublicitys()
		{
			try
			{
				$res = $this->sentence("SET CHARACTER SET utf8");
				$res = $this->sentence("SELECT * FROM publicitys");
				return $res;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function ListPublicitys()
		{
			try
			{
				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence("SELECT
											PublicityId
											, Content
											FROM publicitys
											ORDER BY Content ASC
										");

				return $result;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function UpdatePublicity()
		{
			try
			{
				$sql = "UPDATE publicitys SET Content = $this->Content
										WHERE PublicityId = $this->PublicityId";

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

		public function DeletePublicity()
		{
			try
			{
				$result = $this->sentence("DELETE FROM publicitys WHERE PublicityId = $this->PublicityId");

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
