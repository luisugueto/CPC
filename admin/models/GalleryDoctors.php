<?php
include_once('Connection.php');

	Class GalleryDoctors extends Connection
	{
			private $GalleryDoctorId;
			private $DoctorId;
			private $Location;

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

		public function CreateGalleryDoctor()
		{
			try
			{
				$sql = "INSERT INTO GalleryDoctors
										(DoctorId, Location)
										VALUES
										($this->DoctorId, $this->Location)";

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

		public function GetGalleryContent()
		{
			try
			{
				$sql = "SELECT DoctorId, Location FROM GalleryDoctors WHERE DoctorId = $this->DoctorId";

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
				$sql = "UPDATE GalleryDoctors SET Location = $this->Location
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
				$result = $this->sentence("DELETE FROM GalleryDoctor WHERE GalleryDoctorId = $this->DoctorId");

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
