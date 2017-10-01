<?php
	include_once('Connection.php');

	Class ProceduresDoctor extends Connection
	{
    	private $ProceduresDoctorId;
		private $DoctorId;
		private $CategoryId;
    	private $SubCategoryId;

		//SET
		public function setProceduresDoctorId($value)
		{
			$this->ProceduresDoctorId = $value;
		}

		public function setDoctorId($value)
		{
			$this->DoctorId = $value;
		}

		public function setCategoryId($value)
		{
			$this->CategoryId = $value;
		}

		public function setSubCategoryId($value)
		{
			$this->SubCategoryId = $value;
		}

		//GET
		public function getProceduresDoctorId()
		{
			return $this->ProceduresDoctorId;
		}

		public function getDoctorId()
		{
			return $this->DoctorId;
		}

		public function getCategoryId()
		{
			return $this->CategoryId;
		}

		public function getSubCategoryId()
		{
			return $this->SubCategoryId;
		}

		public function CreateProceduresDoctor()
		{
			try
			{
				$sql = "INSERT INTO ProceduresDoctor
										(DoctorId, CategoryId, SubCategoryId)
										VALUES
										($this->DoctorId, $this->CategoryId, $this->SubCategoryId)";

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
		public function ListProceduresName()
		{
			try
			{
				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence("SELECT pro.*, pro.DoctorId as proDoctorId, d.*, d.DoctorId as doctoridd FROM ProceduresDoctor as pro INNER JOIN Doctors as d ON d.DoctorId=pro.DoctorId INNER JOIN PlanClients as pl ON pl.DoctorId = d.DoctorId WHERE pl.status = 'Active'");

				return $result;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function ListProceduresCategory()
		{
			try
			{
				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence("SELECT pro.*, pro.DoctorId as proDoctorId, d.* FROM ProceduresDoctor as pro INNER JOIN Doctors as d ON d.DoctorId=pro.DoctorId INNER JOIN PlanClients as pl ON pl.DoctorId = d.DoctorId WHERE d.PlanId != 9 AND pl.status = 'Active' AND pro.SubCategoryId = $this->CategoryId");

				return $result;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function GetProceduresDoctorforDoctor($id)
		{
			try
			{
				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence("SELECT
											*
											FROM ProceduresDoctor WHERE DoctorId = $id
										");

				return $result;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function GetDoctorProcedures($id)
		{
			try
			{
				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence("SELECT DISTINCT
											CategoryId
											FROM ProceduresDoctor WHERE DoctorId = $id
										");

				return $result;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function GetDoctorSubProcedures($id, $catId)
		{
			try
			{
				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence("SELECT
											SubCategoryId
											FROM ProceduresDoctor WHERE DoctorId = $id AND CategoryId = $catId
										");

				return $result;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function GetAllProceduresDoctor()
		{
			try
			{
				$res = $this->sentence("SET CHARACTER SET utf8");
				$res = $this->sentence("SELECT * FROM ProceduresDoctor");
				return $res;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function ListProceduresDoctor()
		{
			try
			{
				$result = $this->sentence("SET CHARACTER SET utf8");
				$result = $this->sentence("SELECT
											ProceduresDoctorId
											, DoctorId
											FROM ProceduresDoctor
											ORDER BY DoctorId ASC
										");

				return $result;
			}
			catch(Exception $e)
			{
				echo $e;
			}
		}

		public function UpdateProceduresDoctor()
		{
			try
			{
				$sql = "UPDATE ProceduresDoctor SET DoctorId = $this->DoctorId, CategoryId = $this->CategoryId, SubCategoryId = $this->SubCategoryId
										WHERE ProceduresDoctorId = $this->ProceduresDoctorId";

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

		public function DeleteProceduresDoctor()
		{
			try
			{
				$result = $this->sentence("DELETE FROM ProceduresDoctor WHERE ProceduresDoctorId = $this->ProceduresDoctorId");

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
