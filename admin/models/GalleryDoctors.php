<?php
	include_once('Connection.php');

	Class GalleryDoctors extends Connection
	{
		private $GalleryDoctorId;
		private $DoctorId;
		private $Location;
		private $Type;
		private $CalificationDoctorId;

		//SET
		public function setGalleryDoctorId($value)
		{
			$this->GalleryDoctorId = $value;
		}

		public function setDoctorId($value)
		{
			$this->DoctorId = $value;
		}

		public function setLocation($value)
		{
			$this->Location = $value;
		}

		public function setType($value)
		{
			$this->Type = $value;
		}

		public function setCalificationDoctorId($value)
		{
			$this->CalificationDoctorId = $value;
		}

		//GET
		public function getGalleryDoctorId()
		{
			return $this->GalleryDoctorId;
		}

		public function getDoctorId()
		{
			return $this->DoctorId;
		}

		public function getLocation()
		{
			return $this->Location;
		}

		public function getType()
		{
			return $this->Type;
		}

		public function getCalificationDoctorId()
		{
			return $this->CalificationDoctorId;
		}

		public function CreateGalleryDoctor()
		{
			try
			{
				$result = $this->connection->prepare("INSERT INTO GalleryDoctors (DoctorId, Location, Type, CalificationDoctorId) VALUES (?, ?, ?, ?)");
				$result->bindParam(1, $DoctorId);
				$result->bindParam(2, $Location);
				$result->bindParam(3, $Type);
				$result->bindParam(4, $CalificationDoctorId);

				// insertar una fila
				$Location = $this->Location;
				$Type = $this->Type;
				$CalificationDoctorId = $this->CalificationDoctorId;
				$DoctorId = $this->DoctorId;

				$result->execute();

				if($result->rowCount() > 0)
				{
					return "exito";
				}
				else
				{
					return "fallo";
				}
			} catch(Exception $e){

					echo $e->getMessage() ;
					}
		}

		public function GetGalleryDoctorContent()
		{
			try
			{
				$sql = "SELECT * FROM GalleryDoctors WHERE DoctorId = $this->DoctorId AND Type = '$this->Type' AND CalificationDoctorId IS NULL";

				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence($sql);

				return $result;
			}
			catch(Exception $e)
			{
				echo $e;
				return false;
			}
		}

		public function GetAllVideosCalificationActive()
		{
			try
			{
				$sql = "SELECT g.*, g.DoctorId as galleryDId, cd.* FROM GalleryDoctors as g INNER JOIN CalificationDoctors as cd ON cd.CalificationDoctorId = g.CalificationDoctorId WHERE cd.Status = 'Active' AND g.Type = 'Video'";

				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence($sql);

				return $result;
			}
			catch(Exception $e)
			{
				echo $e;
				return false;
			}
		}

		public function GetAllVideosCalificationNull()
		{
			try
			{
				$sql = "SELECT * FROM GalleryDoctors WHERE Type = 'Video' AND CalificationDoctorId IS NULL";

				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence($sql);

				return $result;
			}
			catch(Exception $e)
			{
				echo $e;
				return false;
			}
		}

		public function GetGalleryUserContent()
		{
			try
			{
				$sql = "SELECT g.*, g.DoctorId as galleryDId, cd.* FROM GalleryDoctors as g INNER JOIN CalificationDoctors as cd ON cd.CalificationDoctorId = g.CalificationDoctorId WHERE cd.DoctorId = $this->DoctorId AND cd.Status = 'Active' AND g.Type = '$this->Type'";

				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence($sql);

				return $result;
			}
			catch(Exception $e)
			{
				echo $e;
				return false;
			}
		}

		public function GetGalleryForComment($catId)
		{
			try
			{
				$sql = "SELECT g.*, g.DoctorId as galleryDId, cd.* FROM GalleryDoctors as g INNER JOIN CalificationDoctors as cd ON cd.CalificationDoctorId = g.CalificationDoctorId WHERE cd.CalificationDoctorId = $catId";
				 
				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence($sql);

				return $result;
			}
			catch(Exception $e)
			{
				echo $e;
				return false;
			}
		}

		public function GetGalleryLocation($catId)
		{
			try
			{
				$sql = "SELECT Location FROM GalleryDoctors WHERE GalleryDoctorId = $catId";

				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence($sql);

				if($result->rowCount() > 0)
				{
					$fetchResult = $result->fetch(PDO::FETCH_ASSOC);
					return $fetchResult["Location"];
				}
			}
			catch(Exception $e)
			{
				echo $e;
				return false;
			}
		}

		public function GetAllDoctors()
		{
			try
			{
				$res = $this->sentence("SET CHARACTER SET utf8");
				$res = $this->sentence("SELECT * FROM GalleryDoctors");
				return $res;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function ListGallery()
		{
			try
			{
				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence("SELECT
											DoctorId
											, Location
											FROM GalleryDoctors
											ORDER BY Location ASC
										");

				return $result;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function UpdateDoctor()
		{
			try
			{
				$sql = "UPDATE GalleryDoctors SET CalificationDoctorId = $this->CalificationDoctorId
										WHERE DoctorId = $this->DoctorId";

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

		public function DeleteGalleryDoctor()
		{
			try
			{
				$result = $this->sentence("DELETE FROM GalleryDoctors WHERE GalleryDoctorId = $this->GalleryDoctorId");

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

		public function numGalleryForDoctor()
		{
			try
			{
				$sql = "SELECT * FROM GalleryDoctors WHERE DoctorId = $this->DoctorId";

				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence($sql);

				return $result->rowCount();
			}
			catch(Exception $e)
			{
				echo $e;
				return false;
			}
		}

		public function numGalleryForDoctorUser()
		{
			try
			{
				$sql = "SELECT g.*, g.DoctorId as galleryDId, cd.* FROM GalleryDoctors as g INNER JOIN CalificationDoctors as cd ON cd.CalificationDoctorId = g.CalificationDoctorId WHERE cd.DoctorId = $this->DoctorId AND cd.Status = 'Active'";

				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence($sql);

				return $result->rowCount();
			}
			catch(Exception $e)
			{
				echo $e;
				return false;
			}
		}

		public function GetGalleryType($catId)
		{
			try
			{
				$sql = "SELECT Type FROM GalleryDoctors WHERE GalleryDoctorId = $catId";

				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence($sql);

				if($result->rowCount() > 0)
				{
					$fetchResult = $result->fetch(PDO::FETCH_ASSOC);
					return $fetchResult["Type"];
				}
			}
			catch(Exception $e)
			{
				echo $e;
				return false;
			}
		}

		public function deleteFile($file){
			return unlink($file);
		}

	}

?>
