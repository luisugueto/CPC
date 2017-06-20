<?php
	include_once('Connection.php');

	Class ArticlesPhotos extends Connection
	{
		private $ArticlePhotoId;
		private $ArticleId;
		private $Photo;

		//SET
		public function setArticlePhotoId($value)
		{
			$this->ArticlePhotoId = $value;
		}

		public function setArticleId($value)
		{
			$this->ArticleId = $value;
		}

		public function setPhoto($value)
		{
			$this->Photo = $value;
		}

		//GET
		public function getArticlePhotoId()
		{
			return $this->ArticlePhotoId;
		}
		
		public function getArticleId()
		{
			return $this->ArticleId;
		}

		public function getPhoto()
		{
			return $this->Photo;
		}

		public function GetArticlePhotosByArticleId()
		{
			try
			{
				$res = $this->sentence("SET CHARACTER SET utf8");
				$res = $this->sentence("SELECT * FROM ArticlePhotos WHERE ArticleId = $this->ArticleId");

				return $res;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function DeletePhoto()
		{
			try
			{
				$result = $this->sentence("DELETE FROM ArticlePhotos WHERE ArticlePhotoId = $this->ArticlePhotoId");

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
			}
		}
		
		public function CreateArticlePhoto()
		{
			try
			{
				$sql = "INSERT INTO ArticlePhotos 
										(ArticleId
										, Photo)
										VALUES 
										('$this->ArticleId'
										, '$this->Photo')";

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

	}

?>