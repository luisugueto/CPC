<?php
include_once('Connection.php');

	Class ArticlesCategories extends Connection
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
		public function CreateArticleCategory()
		{
			try
			{
				$sql = "INSERT INTO ArticlesCategories
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

		public function GetArticleCategoryContent()
		{
			try
			{
				$sql = "SELECT * FROM ArticlesCategories WHERE CategoryId = $this->CategoryId";

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

		public function GetArticleCategoryName($catId)
		{
			try
			{
				$sql = "SELECT Name FROM ArticlesCategories WHERE CategoryId = $catId";

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

		public function GetAllArticlesCategories()
		{
			try
			{
				$res = $this->sentence("SET CHARACTER SET utf8");
				$res = $this->sentence("SELECT * FROM ArticlesCategories");
				return $res;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function ListArticlesCategories()
		{
			try
			{
				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence("SELECT
											CategoryId
											, Name
											FROM ArticlesCategories
											ORDER BY Name ASC
										");

				return $result;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function UpdateArticleCategory()
		{
			try
			{
				$sql = "UPDATE ArticlesCategories SET Name = $this->Name
										WHERE CategoryId = $this->CategoryId";

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

		public function DeleteArticleCategory()
		{
			try
			{
				$result = $this->sentence("DELETE FROM ArticlesCategories WHERE CategoryId = $this->CategoryId");

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
