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

		public function getCharacteristic()
		{
			return $this->Characteristic;

		public function CreateGallery()
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
				$sql = "SELECT GalleryDoctorId, DoctorId, Location FROM GalleryDoctors WHERE GalleryDoctorId = $this->GalleryDoctorId";

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

		public function GetGalleryId($catId)
		{
			try
			{
				$sql = "SELECT GalleryDoctors FROM Plans WHERE GalleryDoctorId = $catId";

				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence($sql);

				if($result->rowCount() > 0)
				{
					$fetchResult = $result->fetch(PDO::FETCH_ASSOC);
					return $fetchResult["DoctorId"];
				}
			}
			catch(Exception $e)
			{
				echo $e;
				return false;
			}
		}

		public function GetAllGallery()
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
											GalleryDoctorId
											, DoctorId, Location
											FROM GalleryDoctors
											ORDER BY GalleryDoctorId ASC
										");

				return $result;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function UpdateGallery()
		{
			try
			{
				$sql = "UPDATE GalleryDoctors SET DoctorId = $this->DoctorId, Location = $this->Location
										WHERE GalleryDoctorId = $this->GalleryDoctorId";

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

		public function DeleteGallery()
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

	}

?>
