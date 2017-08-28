<?php
	include_once('Connection.php');

	Class SubCategories extends Connection
	{
		private $SubCategoryId;
		private $CategoryId;
		private $Name;
		private $Description;
		private $Content;
	    private $Photo;

		//SET
		public function setSubCategoryId($value)
		{
			$this->SubCategoryId = $value;
		}

		public function setCategoryId($value)
		{
			$this->CategoryId = $value;
		}

		public function setName($value)
		{
			$this->Name = $value;
		}

		public function setDescription($value)
		{
			$this->Description = $value;
		}

		public function setContent($value)
		{
			$this->Content = $value;
		}

		public function setPhoto($value)
		{
			$this->Photo = $value;
		}

		//GET
		public function getSubCategoryId()
		{
			return $this->SubCategoryId;
		}

		public function getCategoryId()
		{
			return $this->CategoryId;
		}

		public function getName()
		{
			return $this->Name;
		}

		public function getDesciption()
		{
			return $this->Desciption;
		}

		public function getContent()
		{
			return $this->Content;
		}

		public function getPhoto()
		{
			return $this->Photo;
		}

		public function CreateSubCategory()
		{
			try
			{
				$sql = "INSERT INTO SubCategories
										(CategoryId, Name, Description, Content, Photo)
										VALUES
										($this->CategoryId, $this->Name, $this->Description, '$this->Content', '$this->Photo')";

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

		public function GetSubCategoryContent()
		{
			try
			{
				$sql = "SELECT * FROM SubCategories WHERE SubCategoryId = $this->SubCategoryId";

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

		public function GetCategoryContent($id)
		{
			try
			{
				$sql = "SELECT * FROM SubCategories WHERE CategoryId = $id";

				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence($sql);

				if($result->rowCount() > 0)
				{
					$fetchResult = $result->fetchAll();
					return $fetchResult;
				}
			}
			catch(Exception $e)
			{
				echo $e;
				return false;
			}
		}

		public function GetSubCategoryName($catId)
		{
			try
			{
				$sql = "SELECT Name FROM SubCategories WHERE SubCategoryId = $catId";

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

		public function GetAllSubCategories()
		{
			try
			{
				$res = $this->sentence("SET CHARACTER SET utf8");
				$res = $this->sentence("SELECT * FROM SubCategories");
				return $res;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function GetSubCategoriesByCategory()
		{
			try
			{
				$res = $this->sentence("SET CHARACTER SET utf8");
				$res = $this->sentence("SELECT * FROM SubCategories WHERE CategoryId = $this->CategoryId");
				return $res;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function ListSubCategories()
		{
			try
			{
				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence("SELECT
											SubCategoryId
											, Name, CategoryId, Photo
											FROM SubCategories
											ORDER BY Name ASC
										");

				return $result;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function UpdateSubCategory()
		{
			try
			{
				$sql = "UPDATE SubCategories SET Name = $this->Name, CategoryId = $this->CategoryId, Description = $this->Description, Content = '$this->Content', Photo = '$this->Photo'
										WHERE SubCategoryId = $this->SubCategoryId";

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

		public function DeleteSubCategory()
		{
			try
			{
				$result = $this->sentence("DELETE FROM SubCategories WHERE SubCategoryId = $this->SubCategoryId");

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
