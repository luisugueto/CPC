<?php
include_once('Connection.php');

	Class Categories extends Connection
	{
		private $CategoryId;
		private $Name;

		//SET
		public function setCategoryId($value)
		{
			$this->CategoryId = $value;
		}

		public function setName($value)
		{
			$this->Name = $value;
		}

		//GET
		public function getCategoryId()
		{
			return $this->CategoryId;
		}

		public function getName()
		{
			return $this->Name;
		}
		public function CreateCategory()
		{
			try
			{
				$sql = "INSERT INTO Categories
										(Name)
										VALUES
										($this->Name)";

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

		public function GetCategoryContent()
		{
			try
			{
				$sql = "SELECT * FROM Categories WHERE CategoryId = $this->CategoryId";

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

		public function GetCategoryName($catId)
		{
			try
			{
				$sql = "SELECT Name FROM Categories WHERE CategoryId = $catId";

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

		public function GetAllCategories()
		{
			try
			{
				$res = $this->sentence("SET CHARACTER SET utf8");
				$res = $this->sentence("SELECT * FROM Categories");
				return $res;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function ListCategories()
		{
			try
			{
				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence("SELECT
											CategoryId
											, Name
											FROM Categories
											ORDER BY Name ASC
										");

				return $result;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function UpdateCategory()
		{
			try
			{
				$sql = "UPDATE Categories SET Name = $this->Name
										WHERE CategoryId = $this->CategoryId";

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

		public function DeleteCategory()
		{
			try
			{
				$result = $this->sentence("DELETE FROM Categories WHERE CategoryId = $this->CategoryId");

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
