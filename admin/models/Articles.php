<?php
	include_once('Connection.php');

	Class Articles extends Connection
	{
		private $ArticleId;
		private $Title;
		private $Photo;
		private $Content;
		private $PublishDate;
		private $StatusId;
		private $Author;
		private $Slug;
		private $MetaTitle;
		private $MetaDescription;

		//SET
		public function setArticleId($value)
		{
			$this->ArticleId = $value;
		}

		public function setTitle($value)
		{
			$this->Title = $value;
		}

		public function setPhoto($value)
		{
			$this->Photo = $value;
		}

		public function setContent($value)
		{
			$this->Content = $value;
		}

		public function setPublishDate($value)
		{
			$this->PublishDate = $value;
		}

		public function setStatusId($value)
		{
			$this->StatusId = $value;
		}

		public function setAuthor($value)
		{
			$this->Author = $value;
		}

		public function setSlug($value)
		{
			$this->Slug = $value;
		}

		public function setMetaTitle($value)
		{
			$this->MetaTitle = $value;
		}

		public function setMetaDescription($value)
		{
			$this->MetaDescription = $value;
		}

		//GET
		public function getArticleId()
		{
			return $this->ArticleId;
		}

		public function getTitle()
		{
			return $this->Title;
		}

		public function getPhoto()
		{
			return $this->Photo;
		}

		public function getContent()
		{
			return $this->Content;
		}

		public function getPublishDate()
		{
			return $this->PublishDate;
		}

		public function getStatusId()
		{
			return $this->StatusId;
		}

		public function getAuthor()
		{
			return $this->Author;
		}

		public function getSlug()
		{
			return $this->Slug;
		}

		public function getMetaTitle()
		{
			return $this->MetaTitle;
		}

		public function getMetaDescription()
		{
			return $this->MetaDescription;
		}

		public function CreateArticle()
		{
			try
			{
				$sql = "INSERT INTO Articles
										(Title
										, Photo
										, Content
										, PublishDate
										, StatusId
										, Author
										, Slug
										, MetaTitle
										, MetaDescription)
										VALUES
										('$this->Title'
										, '$this->Photo'
										, '$this->Content'
										, STR_TO_DATE('$this->PublishDate', '%d/%m/%Y')
										, '$this->StatusId'
										, '$this->Author'
										, '$this->Slug'
										, '$this->MetaTitle'
										, '$this->MetaDescription')";

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

		public function LastArticleId()
		{
			try
			{
				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence("SELECT
											ArticleId
											FROM Articles
											ORDER BY ArticleId DESC
											LIMIT 1
										");

				$fetchResult = $result->fetch(PDO::FETCH_ASSOC);
				return $fetchResult["ArticleId"];
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function LastArticleDashboard()
		{
			try
			{
				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence("SELECT
											A.ArticleId
											, A.Title
											, A.Photo
											, A.Content
											, A.PublishDate
											, A.MetaDescription
											, A.StatusId
											, A.Author
											, A.Slug
											FROM Articles A
											ORDER BY ArticleId DESC
											LIMIT 1
										");

				return $result;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function GetArticleCategories()
		{
			try
			{
				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence("SELECT
											*
											FROM ArticleCategories
											WHERE ArticleId = $this->ArticleId
										");

				return $result;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function GetCategoryIdByArticleId($categoryId)
		{
			try
			{
				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence("SELECT
											*
											FROM ArticleCategories
											WHERE ArticleId = $this->ArticleId
											AND CategoryId = $categoryId
										");

				$fetchResult = $result->fetch(PDO::FETCH_ASSOC);
				return $fetchResult["CategoryId"];
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function SaveCategoryByArticle($articleId, $categoryId)
		{
			try
			{
				$sql = "INSERT INTO ArticleCategories
										(ArticleId
										, CategoryId)
										VALUES
										($articleId, '$categoryId')";

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

		public function DeleteArticleCategories($articleId)
		{
			try
			{
				$result = $this->sentence("DELETE FROM ArticleCategories WHERE ArticleId = $articleId");

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

		public function UpdateArticle()
		{
			try
			{
				$sql = "UPDATE Articles SET Title = '$this->Title'
										, Photo = '$this->Photo'
										, Content = '$this->Content'
										, PublishDate = STR_TO_DATE('$this->PublishDate', '%d/%m/%Y')
										, StatusId = '$this->StatusId'
										, Slug = '$this->Slug'
										, MetaTitle = '$this->MetaTitle'
										, MetaDescription = '$this->MetaDescription'
										WHERE ArticleId = '$this->ArticleId'";

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

		public function UpdateArticlePhoto()
		{
			try
			{
				$sql = "UPDATE Articles SET Photo = '$this->Photo'
										WHERE ArticleId = $this->ArticleId";

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

		public function UpdateArticleStatus()
		{
			try
			{
				$sql = "UPDATE Articles SET StatusId = '$this->StatusId'
										WHERE ArticleId = $this->ArticleId";

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

		public function GetArticleContent()
		{
			try
			{
				$sql = "SELECT * FROM Articles WHERE ArticleId = $this->ArticleId";

				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence($sql);

				if($result->rowCount() > 0)
				{
					$fetchResult = $result->fetch(PDO::FETCH_ASSOC);
					$this->setTitle($fetchResult["Title"]);
					$this->setContent($fetchResult["Content"]);
					$this->setPublishDate($fetchResult["PublishDate"]);
					$this->setStatusId($fetchResult["StatusId"]);
					$this->setPhoto($fetchResult["Photo"]);
					$this->setSlug($fetchResult["Slug"]);
					$this->setAuthor($fetchResult["Author"]);
					$this->setMetaTitle($fetchResult["MetaTitle"]);
					$this->setMetaDescription($fetchResult["MetaDescription"]);
					return true;
				}
			}
			catch(Exception $e)
			{
				echo $e;
				return false;
			}
		}

		public function DeleteArticle()
		{
			try
			{
				$result = $this->sentence("DELETE FROM Articles WHERE ArticleId = $this->ArticleId");

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

		public function GetTotalArticles()
		{
			try
			{
				$res = $this->sentence("SET CHARACTER SET utf8");
				$res = $this->sentence("SELECT A.ArticleId, COUNT(*) AS Total FROM Articles A WHERE (SELECT AC.CategoryId FROM ArticleCategories AC WHERE AC.ArticleId = A.ArticleId LIMIT 1) != '8'");
				return $res;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function GetArticlesByCategory($pag, $num, $today, $categoryId)
		{
			try
			{

				$begin = ($pag - 1) * $num;

				$res = $this->sentence("SET CHARACTER SET utf8");
				$res = $this->sentence("SELECT
										AC.ArticleId
										,AC.CategoryId
										,A.ArticleId
										,A.Title
										,A.Photo
										,A.Content
										,A.PublishDate
										,A.StatusId
										,A.Author
										,A.MetaDescription
										,A.Slug
									FROM ArticleCategories AC
									INNER JOIN Articles A ON A.ArticleId = AC.ArticleId
									WHERE AC.CategoryId = $categoryId
									AND A.PublishDate <= '$today'
									AND A.StatusId = 1
									ORDER BY A.Title ASC
									LIMIT $begin, $num");

				return $res;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function GetTotalArticlesByCategory($categoryId)
		{
			try
			{
				$res = $this->sentence("SET CHARACTER SET utf8");
				$res = $this->sentence("SELECT COUNT(*) AS Total FROM ArticleCategories WHERE CategoryId = $categoryId");
				return $res;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function ListArticles()
		{
			try
			{
				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence("SELECT
											A.ArticleId
											, A.Photo
											, A.Title
											, A.StatusId
											, (SELECT GROUP_CONCAT((ACS.Name) SEPARATOR ', ') FROM ArticleCategories AC INNER JOIN SubCategories ACS ON ACS.SubCategoryId = AC.CategoryId WHERE AC.ArticleId = A.ArticleId) AS Categories
											FROM Articles A
											ORDER BY PublishDate DESC
										");

				return $result;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function ListArticlesSearch($search)
		{
			try
			{
				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence("SELECT
											ArticleId
											, Photo
											, Title
											, StatusId
											FROM Articles
											WHERE Title LIKE '%$search%'
											ORDER BY PublishDate DESC
										");

				return $result;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function GetAllArticles($pag, $num, $today)
		{
			try
			{

				$begin = ($pag - 1) * $num;

				$res = $this->sentence("SET CHARACTER SET utf8");
				$res = $this->sentence("SELECT
										A.ArticleId
										,A.Title
										,A.Photo
										,A.Content
										,A.PublishDate
										,A.Author
										,A.MetaDescription
										,A.Slug
									FROM Articles A
									WHERE A.PublishDate <= '$today'
									AND A.StatusId = 1
									AND (SELECT AC.CategoryId FROM ArticleCategories AC WHERE AC.ArticleId = A.ArticleId LIMIT 1) != '8'
									ORDER BY A.PublishDate DESC
									LIMIT $begin, $num");
				return $res;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function GetLastArticles($today)
		{
			try
			{
				$res = $this->sentence("SET CHARACTER SET utf8");
				$res = $this->sentence("SELECT
										ArticleId
										, Photo
										, Title
										, MetaDescription
										, PublishDate
										, Slug
										, Author
									FROM Articles
									WHERE PublishDate <= '$today'
									AND StatusId = 1
									ORDER BY PublishDate DESC
									LIMIT 5");
				return $res;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

	}

?>
