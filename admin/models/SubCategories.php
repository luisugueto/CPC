<?php
include_once('Connection.php');

	Class SubCategories extends Connection
	{
		private $SubCategoryId;
		private $CategoryId;
		private $Name;
	    private $Description;
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

		public function setPhoto($value)
		{
			// $file = $value["file"]["name"];

			// if(!is_dir("files/"))
			// 	mkdir("files/", 0777);
			//
			// switch($value["file"]["type"]){
			// 				case 'image/jpg':
			// 				case 'image/jpeg':
			// 					$extension = 'jpeg';
			// 				break;
			// 				case 'image/png':
			// 					$extension = 'png';
			// 				break;
			// 				}
			//
			//
			// $nombre = $_POST['name']. ".".$extension;
			// if($value["file"]["type"] == "image/jpeg" or $value["file"]["type"] == "image/jpg" or $value["file"]["type"] == "image/png")
			// {
			// 	if($file && move_uploaded_file($value["file"]["tmp_name"], "files/$nombre"))
			// 	{
			//
			// 	}
			// }

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

		public function getPhoto()
		{
			return $this->Photo;
		}

		public function CreateSubCategory()
		{
			try
			{
				$sql = "INSERT INTO subcategories
										(CategoryId, Name,Description)
										VALUES
										($this->CategoryId, $this->Name, $this->Description)";

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
				$sql = "SELECT * FROM subcategories WHERE SubCategoryId = $this->SubCategoryId";

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
				$sql = "SELECT Name FROM subcategories WHERE SubCategoryId = $catId";

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
				$res = $this->sentence("SELECT * FROM subcategories");
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
											, Name, CategoryId
											FROM subcategories
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
				$sql = "UPDATE subcategories SET Name = $this->Name, CategoryId = $this->CategoryId, Description = $this->Description
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
				$result = $this->sentence("DELETE FROM subcategories WHERE SubCategoryId = $this->SubCategoryId");

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
