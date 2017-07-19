<?php
include_once('Connection.php');

	Class CommentCalifications extends Connection
	{
		  private $CommentCalificationId;
		  private $NameUser;
	    private $Email;
	    private $Comment;
	    private $DateComment;

		//SET
		public function setCommentCalificationId($value)
		{
			$this->CommentCalificationId = $value;
		}

		public function setNameUser($value)
		{
			$this->NameUser = $value;
		}

		public function setEmail($value)
		{
			$this->Email = $value;
		}

		public function setComment($value)
		{
			$this->Comment = $value;
		}

		//GET
		public function getCommentCalificationId()
		{
			return $this->CommentCalificationId;
		}

		public function getNameUser()
		{
			return $this->NameUser;
		}

		public function getEmail()
		{
			return $this->Email;
		}

		public function getComment()
		{
			return $this->Comment;
		}

		public function CreateCommentCalifications()
		{
			try
			{
				$sql = "INSERT INTO CommentCalifications
										(NameUser, Email, Comment, DateComment)
										VALUES
										($this->NameUser, $this->Email, $this->Comment, 'now()')";

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

		public function GetCommentCalificationsContent()
		{
			try
			{
				$sql = "SELECT * FROM CommentCalifications WHERE CommentCalificationId = $this->CommentCalificationId";

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

		public function GetCommentCalificationsNameUser($catId)
		{
			try
			{
				$sql = "SELECT NameUser FROM CommentCalifications WHERE CommentCalificationId = $catId";

				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence($sql);

				if($result->rowCount() > 0)
				{
					$fetchResult = $result->fetch(PDO::FETCH_ASSOC);
					return $fetchResult["NameUser"];
				}
			}
			catch(Exception $e)
			{
				echo $e;
				return false;
			}
		}

		public function GetAllCommentCalifications()
		{
			try
			{
				$res = $this->sentence("SET CHARACTER SET utf8");
				$res = $this->sentence("SELECT * FROM CommentCalifications");
				return $res;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function ListCommentCalifications()
		{
			try
			{
				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence("SELECT
											CommentCalificationId
											, NameUser
											FROM CommentCalifications
											ORDER BY NameUser ASC
										");

				return $result;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function UpdateCommentCalification()
		{
			try
			{
				$sql = "UPDATE CommentCalifications SET NameUser = $this->NameUser
										WHERE CommentCalificationId = $this->CommentCalificationId";

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

		public function DeleteCommentCalification()
		{
			try
			{
				$result = $this->sentence("DELETE FROM CommentCalifications WHERE CommentCalificationId = $this->CommentCalificationId");

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
